<?php

namespace App\Http\Controllers;

use App\Models\Book;
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

    // Route /manage-borrowed-books 
    public function showManageBorrowedBooks () 
    {
        $borrowed_books = DB::table('users')
        ->join('reservations', 'users.id', '=', 'reservations.user_id')
        ->join('loans', 'users.id', '=', 'loans.user_id')
        ->join('books', 'reservations.book_id', '=', 'books.id')
        ->select(   'reservations.book_id',
                    'books.title', 
                    'users.id', 'users.name', 'users.email', 
                    'loans.loan_date', 'loans.expected_return_date')
        // ->where('loans.return_date', '=', 'null')
        ->get();
        return view('admin.manage-borrowed-books', compact('borrowed_books'));
    }

    // Route get() /add-borrower/{id}
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
        } else {
            
            $user_id = Auth::user()->id;
            $book_id=$request->id;

            Loan::create([
                'book_id' => $book_id,
                'user_id' => $user_id,
                'loan_date' => Carbon::now()->format('Y-m-d'),
                'expected_return_date' => Carbon::now()->addDay(14)->format('Y-m-d'),
            ]);

        }
        return redirect()->back();
    }

    public function showTransactionHistory () 
    {
        $transactions = DB::table('loans')
        ->join('books', 'loans.book_id', '=', 'books.id')
        ->join('users', 'loans.user_id', '=', 'users.id')
        ->select( 'books.title', 'users.name', 'users.email', 'loans.book_id', 'loans.user_id',
                    'loans.loan_date', 'loans.expected_return_date', 'loans.returned_date')
        ->get();

        return view('admin.transaction-history', compact('transactions'));
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

    
}
