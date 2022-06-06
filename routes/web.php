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
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/books', [UserController::class, 'showBooks']);
    Route::get('/reserved-books', [UserController::class, 'showReservedBooks']);
    Route::get('/create-book-reservation/{id}', [UserController::class, 'createBookReservation']);
    Route::get('/cancel-book-reservation/{id}', [UserController::class, 'cancelBookReservation']);

});
Route::middleware(['role:admin'])->group(function () {
    //    if user has the role 'admin', he can access these routes.
    //    put admin routes here.
    Route::get('/admin', [AdminController::class, 'index']);
    Route::get('/manage-reserved-books', [AdminController::class, 'showReservedBooks']);
    Route::get('/complete-book-reservation/{id}', [AdminController::class, 'completeBookReservation']);

});

