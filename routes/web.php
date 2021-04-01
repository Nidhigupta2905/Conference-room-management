<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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


// Route::get('/login', [LoginController::class, 'index'])->name('user.login');

// Route::get('auth/google', [UserController::class, 'redirectToGoogle'])->name('google.login');
// Route::get('auth/google/callback', [UserController::class, 'handleGoogleCallback'])->name('google.handleCallback');

// Route::get('login/google', function () {
//     return Socialite::driver('google')->redirect();
// });

Route::get('login/google', [UserController::class, 'redirectToGoogle']);
Route::get('login/google/callback', [UserController::class, 'handleGoogleCallback']);


