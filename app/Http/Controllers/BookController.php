<?php

namespace App\Http\Controllers;

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
        $remaining_copy = DB::table('users')->where('id', $book_id)->value('remaining_copies');

        if ($remaining_copy > 0) {
            DB::table('books')->decrement('remaining_copies', 1, ['id' => $book_id]);
            DB::table('reservations')->insert([
                'book_id' => $book_id,
                'user_id' => Auth::user()->getId(),
                'reservation_date' => Carbon::now()->format('Y-m-d'),
            ]);
        }
//        print session message "book reserved"


    }
}
