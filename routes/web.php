<?php

use App\Http\Controllers\AdminModule\AdminController;
use App\Http\Controllers\AdminModule\ConferenceRoomController;
use App\Http\Controllers\EmployeeModule\EmployeeController;
use App\Http\Controllers\GoogleModule\GoogleController;
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

Route::group(["middleware" => "guest"], function () {
    Route::get('/', function () {
        return view('welcome');
    });

    //employee Authentication
    Route::group(["prefix" => "auth", "as" => "auth."], function () {
        Route::get('login/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
        Route::get('login/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');
    });

});

//admin Authentication
Auth::routes(['register' => false]);

//admin route
Route::group(["middleware" => ["auth", "admin"], "prefix" => "admin", "as" => "admin."], function () {
    Route::get('/home', [AdminController::class, 'index'])->name('home');
    Route::resource('conference_room', ConferenceRoomController::class);
});

//employee
Route::group(["middleware" => ["auth", "employee"], "prefix" => "employee", "as" => "employee."], function () {
    Route::get('/home', [EmployeeController::class, 'index'])->name('home');
});



