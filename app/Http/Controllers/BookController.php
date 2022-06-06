<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function showBooks()
    {
        $books = DB::table('book_authors')
            ->join('books', 'book_authors.book_id', '=', 'books.id')
            ->join('authors', 'book_authors.author_id', '=', 'authors.id')
            ->join('categories', 'books.category_id', '=', 'categories.id')
            ->select(
                'books.id', 'books.title', 'books.publication_date', 'books.copies_owned', 'books.remaining_copies',
                'authors.first_name', 'authors.last_name',
                'categories.category_name')
            ->get();
        return view('user.books', compact('books'));
    }

    public function reserveBook(Request $request)
    {
        $book_id = $request->id;
        $user_id = Auth::user()->getId();
        $reservation_record = DB::table('reservations')
            ->where('book_id', $book_id)
            ->where('user_id', $user_id)
            ->first();

        if (!empty($reservation_record)) {
//            check if user already reserved the book
            $request->session()->flash('error', 'You already reserved this book.');

            return redirect()->back();
        }
        $remaining_copy = DB::table('books')->where('id', $book_id)->value('remaining_copies');

//        maybe check if user has exceeded borrow + reservation limit of 3

        if ($remaining_copy > 0) {
//            check if there are still copies remaining
            Book::find($book_id)->decrement('remaining_copies');
            Reservation::create([
                'book_id' => $book_id,
                'user_id' => $user_id,
                'reservation_date' => Carbon::now()->format('Y-m-d'),
            ]);
            $request->session()->flash('message', 'Book has been reserved successfully.');
        } else {
            $request->session()->flash('error', 'No more copies remaining.');
        }

        return redirect()->back();

    }
}
