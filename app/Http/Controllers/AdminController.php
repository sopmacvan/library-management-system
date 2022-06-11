<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\BookAuthor;
use App\Models\Category;
use App\Models\Loan;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Boolean;
use phpDocumentor\Reflection\Types\False_;

class AdminController extends Controller
{

    public function index()
    {
        $total_copies = Book::sum('copies_owned');
        $remaining_copies = Book::sum('remaining_copies');
        $reserved_copies = Reservation::where('reservation_status_id', 1)->count();
        $borrowed_copies = $total_copies - ($remaining_copies + $reserved_copies);

        $user_accounts = DB::table('user_statuses')
            ->join('users', 'user_statuses.id', '=', 'users.user_status_id')
            ->select('user_statuses.status_value', DB::raw('count(1) as total'))
            ->groupBy('user_statuses.status_value')
            ->get();

        return view('admin.home', compact('remaining_copies', 'reserved_copies', 'borrowed_copies', 'user_accounts'));
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
        return view('admin.manage-books.books', compact('books'));
    }

    public function showReservedBooks()
    {
        $reserved_books = DB::table('reservations')
            ->join('books', 'reservations.book_id', '=', 'books.id')
            ->join('users', 'reservations.user_id', '=', 'users.id')
            ->join('reservation_statuses', 'reservations.reservation_status_id', '=', 'reservation_statuses.id')
            ->select(
                'books.title',
                'users.name',
                'reservations.id', 'reservations.book_id', 'reservations.user_id', 'reservations.reservation_date',
                'reservation_statuses.status_value')
            ->whereIn('reservations.reservation_status_id', [1])
            ->get();
        return view('admin.manage-reserved-books', compact('reserved_books'));
    }

    public function showUsers()
    {
        $users = DB::table('users')
            ->join('user_statuses', 'users.user_status_id', '=', 'user_statuses.id')
            ->select(
                'users.id', 'users.name', 'users.email', 'users.created_at', 'users.updated_at',
                'user_statuses.status_value')
            ->where('users.user_role_id', '=', '1')
            ->get();


        return view('admin.manage-users', compact('users'));

    }

    public function changeUserStatus(Request $request)
    {
        $user_id = $request->id;
        $user = User::find($user_id);
        $status = $user->user_status_id;

//        if user status is active, deactivate
//        else, activate
        if ($status == 1) {
            $user->user_status_id = 2;
            $request->session()->flash('deactivated', "Deactivated user {$user_id} successfully.");

        } else {
            $user->user_status_id = 1;
            $request->session()->flash('activated', "Activated user {$user_id} successfully.");
        }
        $user->save();

        return redirect()->back();
    }

    public function completeBookReservation(Request $request)
    {
        $reservation_id = $request->id;
        $reservation = Reservation::find($reservation_id);
//        if reservation status is not accepted, return
//        else, update status to claimed

        if ($reservation->reservation_status_id != 1) {
            $request->session()->flash('error', 'You may only mark book reservations that are accepted as claimed.');
            return redirect()->back();
        }

        $this->addBorrower($request, true);
        Reservation::where('id', $reservation_id)
            ->update([
                'reservation_status_id' => 2
            ]);
        $request->session()->flash('message', "Marked book reservation {$reservation_id} as claimed successfully.");

        return redirect()->back();

    }

    public function addBorrower(Request $request, $from_reservation = false)
    {
        if ($from_reservation) {
            $reservation_id = $request->id;
            $reservation = Reservation::find($reservation_id);
            $book_id = $reservation->book_id;
            $user_id = $reservation->user_id;

            Loan::create([
                'book_id' => $book_id,
                'user_id' => $user_id,
                'loan_date' => Carbon::now()->format('Y-m-d'),
                'expected_return_date' => Carbon::now()->addDay(14)->format('Y-m-d'),
            ]);
        }

    }

    public function createBook()
    {
        $categories = Category::all();
        return view('admin.manage-books.create-book', compact('categories'));
    }

    public function saveCreatedBook(Request $request)
    {
        $author_fname = $request->author_fname;
        $author_lname = $request->author_lname;

        $book_title = $request->title;
        $category_id = $request->category;
        $copies_owned = $request->copies_owned;
        $publication_date = $request->publication_date;

        //convert date format to y-m-d
        $timestamp = strtotime($publication_date);
        $publication_date = date("Y-m-d", $timestamp);

        //create book
        $book = Book::create([
            'title' => $book_title,
            'publication_date' => $publication_date,
            'copies_owned' => $copies_owned,
            'remaining_copies' => $copies_owned,
            'category_id' => $category_id
        ]);
        //create author
        $author = Author::create([
            'first_name' => $author_fname,
            'last_name' => $author_lname
        ]);

        //create book author
        DB::table('book_authors')->insert([
            'book_id' => $book->id,
            'author_id' => $author->id
        ]);

        $request->session()->flash('message', "Created book '{$book->title}' successfully.");
        return redirect('/manage-books');


    }

    public function editBook(Request $request)
    {
//        get book author, book, author, category
//        display them in blade
//        save changes using saveEditedBook()

        $book = DB::table('book_authors')
            ->join('books', 'book_authors.book_id', '=', 'books.id')
            ->join('authors', 'book_authors.author_id', '=', 'authors.id')
            ->join('categories', 'books.category_id', '=', 'categories.id')
            ->select(
                'books.id', 'books.title', 'books.publication_date', 'books.copies_owned',
                'authors.first_name', 'authors.last_name')
            ->where('book_authors.book_id', '=', $request->id)
            ->first();

        $categories = Category::all();
        return view('admin.manage-books.edit-book', compact('book', 'categories'));
    }

    public function saveEditedBook(Request $request)
    {
//        update book and author
        $book_id = $request->id;
        $author_id = BookAuthor::where('book_id', $book_id)->first()->author_id;

        $book = Book::find($book_id);
        $book->title = $request->title;
        $book->category_id = $request->category;
        $book->publication_date = $request->publication_date;


//        if copies owned is less than new value, add
//        if greater, subtract
        $amount = $book->copies_owned;
        $new_amount = $request->copies_owned;
        if ($amount < $new_amount) {
            $book->copies_owned += ($new_amount - $amount);
            $book->remaining_copies += ($new_amount - $amount);
        } elseif ($amount > $new_amount) {
            $book->copies_owned -= ($amount - $new_amount);
            $book->remaining_copies -= ($amount - $new_amount);
        }

        $author = Author::find($author_id);
        $author->first_name = $request->author_fname;
        $author->last_name = $request->author_lname;

        $book->save();
        $author->save();

        $request->session()->flash('message', "Edited book {$book->id} successfully.");
        return redirect('/manage-books');

    }

    public function deleteBook(Request $request)
    {
        $book = Book::find($request->id);
        $book->delete();

        $request->session()->flash('info', "Deleted book {$book->id} successfully.");
        return redirect('/manage-books');
    }
}
