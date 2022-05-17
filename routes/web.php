<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['user'])->group(function () {
    //authenticates user
    //return to auth.login if not authenticated
    //return to admin.home if admin
    //located in app\Http\Middleware\EnsureUserIsNonAdmin
    Route::get('/user', [UserController::class, 'index']);
});

Route::middleware(['admin'])->group(function () {
    //authenticates user
    //return to auth.login if not authenticated
    //return to user.home if not admin
    //located in app\Http\Middleware\EnsureUserIsAdmin
    Route::get('/admin', [AdminController::class, 'index']);

});

