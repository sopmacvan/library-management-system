<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function index()
    {
        $categories = DB::table('categories')
            ->leftJoin('books', 'categories.id', '=', 'books.category_id')
            ->select('categories.category_name', DB::raw('count(1) as total'))
            ->groupBy('categories.category_name')
            ->get();

        $borrowed_books = DB::table('loans')
            ->join('books', 'loans.book_id', '=', 'books.id')
            ->select('books.id', 'books.title', DB::raw('count(1) as total'))
            ->whereNull('loans.returned_date')
            ->groupBy('books.id', 'books.title')
            ->orderBy('total', 'DESC')
            ->limit(5)
            ->get();

        return view('user.home', compact('categories', 'borrowed_books'));
    }

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

    // Borrowed Books method from route get('/borrowed-books')
    // Added by James
    public function showBorrowedBooks()
    {
        $user_id = Auth::user()->id;
        $borrowed_books = DB::table('loans')
            ->leftjoin('books', 'loans.book_id', '=', 'books.id')
            ->select('loans.book_id',
                'books.title',
                'loans.loan_date', 'loans.expected_return_date')
            ->where('loans.user_id', '=', $user_id)
            ->whereNull('loans.returned_date')
            ->whereNull('loans.deleted_at')
            ->get();
        return view('user.borrowed-books', compact('borrowed_books'));
    }

    public function showReservedBooks()
    {
        $user_id = Auth::user()->id;
        $reserved_books = DB::table('reservations')
            ->join('books', 'reservations.book_id', '=', 'books.id')
            ->join('reservation_statuses', 'reservations.reservation_status_id', '=', 'reservation_statuses.id')
            ->select(
                'books.title',
                'reservations.id', 'reservations.book_id', 'reservations.reservation_date',
                'reservation_statuses.status_value')
            ->where('reservations.user_id', '=', $user_id)
            ->whereIn('reservations.reservation_status_id', [1, 4])
            ->get();
        return view('user.reserved-books', compact('reserved_books'));
    }

    public function createBookReservation(Request $request)
    {
        if (!Auth::user()->isActive()) {
            $request->session()->flash('error', 'Your account is inactive. Please contact your librarian.');

            return redirect()->back();
        }

        $user_id = Auth::user()->id;
        $book_id = $request->id;
        $reservation = Reservation::where('book_id', '=', $book_id)
            ->where('user_id', '=', $user_id)
            ->whereIn('reservation_status_id', array(1, 3, 4))
            ->first();

        $remaining_copy = Book::find($book_id)->remaining_copies;
//        if remaining copy <= 0, return
//        if reservation exists and already accepted , return
//        if reservation exists, decrement and update status to accepted
//        else, decrement and create new reservation

        if ($remaining_copy <= 0) {
            $request->session()->flash('error', 'No more copies remaining.');

            return redirect()->back();
        }

        if (!empty($reservation) and $reservation->reservation_status_id == 1) {
            $request->session()->flash('error', 'You already reserved this book.');

            return redirect()->back();
        }

        if (!empty($reservation)) {
            Book::find($book_id)->decrement('remaining_copies');
            $reservation->reservation_status_id = 1;
            $reservation->save();
        } else {
            Book::find($book_id)->decrement('remaining_copies');
            Reservation::create([
                'book_id' => $book_id,
                'user_id' => $user_id,
                'reservation_date' => Carbon::now()->format('Y-m-d'),
            ]);

        }
        $request->session()->flash('message', "Reserved book {$book_id} successfully.");
        return redirect()->back();
    }


    public function cancelBookReservation(Request $request)
    {
        $reservation_id = $request->id;
        $reservation = Reservation::find($reservation_id);
//        if reservation status is already accepted, return
//        else, update status to cancelled

        if ($reservation->reservation_status_id != 1) {
            $request->session()->flash('error', 'You may only cancel book reservations that are accepted.');
            return redirect()->back();
        }

        Book::find($reservation->book_id)->increment('remaining_copies');
        Reservation::where('id', $reservation_id)
            ->update([
                'reservation_status_id' => 3
            ]);
        $request->session()->flash('message', "Cancelled book reservation {$reservation_id} successfully.");

        return redirect()->back();

    }

    public function showTransactionHistory()
    {
        $user_id = Auth::user()->id;
        $transactions = DB::table('loans')
            ->join('books', 'loans.book_id', '=', 'books.id')
            ->join('users', 'loans.user_id', '=', 'users.id')
            ->select('books.title', 'users.name', 'users.email', 'loans.book_id', 'loans.user_id',
                'loans.loan_date', 'loans.expected_return_date', 'loans.returned_date')
            ->where('loans.user_id', '=', $user_id)
            ->get();

        return view('admin.transaction-history', compact('transactions'));
    }
}
