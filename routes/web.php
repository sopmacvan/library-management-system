<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/', function () {
    return redirect('login');
});

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['role:user'])->group(function () {
    //    if user has the role 'user', he can access these routes.
    //    put user routes here.
    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::get('/books', [UserController::class, 'showBooks'])->name('books');
    Route::get('/borrowed-books', [UserController::class, 'showBorrowedBooks'])->name('borrowed-books');
    Route::get('/reserved-books', [UserController::class, 'showReservedBooks'])->name('reserved-books');
    Route::get('/create-book-reservation/{id}', [UserController::class, 'createBookReservation'])->name('create-book-reservation');

});
Route::middleware(['role:admin'])->group(function () {
    //    if user has the role 'admin', he can access these routes.
    //    put admin routes here.
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
//manage users
    Route::get('/manage-users', [AdminController::class, 'showUsers'])->name('manage-users');
    Route::get('/change-user-status/{id}', [AdminController::class, 'changeUserStatus'])->name('change-user-status');
//manage borrowers
    Route::get('/manage-borrowed-books', [AdminController::class, 'showManageBorrowedBooks'])->name('manage-borrowed-books');
    Route::get('/add-borrower', [AdminController::class, 'addBorrower']);
    Route::post('/save-added-borrower', [AdminController::class, 'saveAddedBorrower']);
    Route::get('/return-book/{id}', [AdminController::class, 'returnBook']);
//manage books
    Route::get('/manage-books', [AdminController::class, 'showBooks'])->name('manage-books');
    Route::get('/create-book', [AdminController::class, 'createBook'])->name('create-book');
    Route::post('/save-created-book', [AdminController::class, 'saveCreatedBook'])->name('save-created-book');
    Route::get('/edit-book/{id}', [AdminController::class, 'editBook'])->name('edit-book');
    Route::post('/save-edited-book', [AdminController::class, 'saveEditedBook'])->name('save-edited-book');
    Route::get('/delete-book/{id}', [AdminController::class, 'deleteBook'])->name('delete-book');
//manage reserved books
    Route::get('/manage-reserved-books', [AdminController::class, 'showReservedBooks'])->name('manage-reserved-books');
    Route::get('/complete-book-reservation/{id}', [AdminController::class, 'completeBookReservation'])->name('complete-book-reservation');
    Route::get('/transaction-history', [AdminController::class, 'showTransactionHistory'])->name('transaction-history');


});

Route::middleware(['auth'])->group(function () {
    //    if user is authenticated, he can access these routes.
    //    put default routes here.
    Route::get('/cancel-book-reservation/{id}', [UserController::class, 'cancelBookReservation'])->name('cancel-book-reservation');

});
