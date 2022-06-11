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
    Route::get('/reserved-books', [UserController::class, 'showReservedBooks'])->name('reserved-books');
    Route::get('/create-book-reservation/{id}', [UserController::class, 'createBookReservation'])->name('create-book-reservation');

});
Route::middleware(['role:admin'])->group(function () {
    //    if user has the role 'admin', he can access these routes.
    //    put admin routes here.
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    Route::get('/manage-users', [AdminController::class, 'showUsers'])->name('manage-users');
    Route::get('/change-user-status/{id}', [AdminController::class, 'changeUserStatus'])->name('change-user-status');

    Route::get('/manage-books', [AdminController::class, 'showBooks'])->name('manage-books');
    Route::get('/create-book', [AdminController::class, 'createBook'])->name('create-book');
    Route::post('/save-created-book', [AdminController::class, 'saveCreatedBook'])->name('save-created-book');
    Route::get('/edit-book/{id}', [AdminController::class, 'editBook'])->name('edit-book');
    Route::post('/save-edited-book', [AdminController::class, 'saveEditedBook'])->name('save-edited-book');
//    Route::post('/delete-book', [AdminController::class, 'deleteBook'])->name('delete-book');

    Route::get('/manage-reserved-books', [AdminController::class, 'showReservedBooks'])->name('manage-reserved-books');
    Route::get('/complete-book-reservation/{id}', [AdminController::class, 'completeBookReservation'])->name('complete-book-reservation');


});

Route::middleware(['auth'])->group(function () {
    //    if user is authenticated, he can access these routes.
    //    put default routes here.
    Route::get('/cancel-book-reservation/{id}', [UserController::class, 'cancelBookReservation'])->name('cancel-book-reservation');

});
