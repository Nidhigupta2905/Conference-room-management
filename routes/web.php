<?php

use App\Http\Controllers\AdminModule\AdminController;
use App\Http\Controllers\AdminModule\ConferenceRoomController;
use App\Http\Controllers\AdminModule\EmployeeController;
use App\Http\Controllers\AdminModule\EmployeeMeetingController;
use App\Http\Controllers\EmployeeModule\DashboardController;
use App\Http\Controllers\EmployeeModule\MeetingController;
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

    Route::get('/meeting-history', [EmployeeMeetingController::class, 'meetingHistory'])->name('employee.meeting-history');

    Route::resource('conference_room', ConferenceRoomController::class);
    Route::resource('employee', EmployeeController::class);
    Route::get('/active-meetings/{id}', [ConferenceRoomController::class, 'activeMeetings'])->name('cr.active-meetings');

    Route::resource('meetings', EmployeeMeetingController::class);


});

//employee
Route::group(["middleware" => ["auth", "employee"], "prefix" => "employee", "as" => "employee."], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/getChartData', [DashboardController::class, 'getChartData'])->name('meeting_data');

    Route::get('/meeting-history', [MeetingController::class, 'meetingHistory'])->name('meeting-history');

    Route::resource('meeting', MeetingController::class);
});
