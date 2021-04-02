<?php

use App\Http\Controllers\HomeController;

use App\Http\Controllers\GoogleController;
use App\Http\Controllers\ConferenceRoomController;
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
    return view('welcome');
});

Route::get('/home', [ConferenceRoomController::class, 'index'])->name('booking.home');

Route::get('login/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('login/google/callback', [GoogleController::class, 'handleGoogleCallback']);
Route::post('logout', [GoogleController::class, 'logout'])->name('googleUser.logout');


Route::get('book/conference', [ConferenceRoomController::class, 'create'])->name('booking.book-conference');

