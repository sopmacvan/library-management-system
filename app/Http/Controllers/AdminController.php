<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Reservation;
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
        return view('admin.home');
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
}
