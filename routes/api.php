<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\CinemaController;
use App\Http\Controllers\Api\HallController;
use App\Http\Controllers\Api\SeatController;
use App\Http\Controllers\Api\ShowtimeController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\StaffController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// Browse Movies
Route::get('/movies', [MovieController::class, 'index']);
Route::get('/movies/{movie}', [MovieController::class, 'show']);

Route::get('/cinemas', [CinemaController::class, 'index']);
Route::get('/cinemas/{cinema}', [CinemaController::class, 'show']);

Route::get('/halls', [HallController::class, 'index']);
Route::get('/halls/{hall}', [HallController::class, 'show']);

Route::get('/seats', [SeatController::class, 'index']);
Route::get('/seats/{seat}', [SeatController::class, 'show']);

Route::get('/showtimes', [ShowtimeController::class, 'index']);
Route::get('/showtimes/{showtime}', [ShowtimeController::class, 'show']);

//| Customer Routes
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/profile', [AuthController::class, 'profile']);

    Route::put('/profile', [AuthController::class, 'updateProfile']);

    Route::post('/bookings', [BookingController::class, 'book']);

    Route::get('/bookings', [BookingController::class, 'index']);

    Route::get('/bookings/{booking}', [BookingController::class, 'show']);

    Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel']);

});

// Staff route

Route::middleware(['auth:sanctum', 'staff'])->group(function () {

    Route::get('/staff/bookings/today', [StaffController::class, 'todayBookings']);

    Route::patch('/staff/bookings/{booking}/check-in', [StaffController::class, 'checkIn']);

});

// Admin Routes
Route::middleware(['auth:sanctum', 'admin'])->group(function () {

    Route::post('/movies', [MovieController::class, 'store']);
    Route::put('/movies/{movie}', [MovieController::class, 'update']);
    Route::delete('/movies/{movie}', [MovieController::class, 'destroy']);

    Route::post('/cinemas', [CinemaController::class, 'store']);
    Route::put('/cinemas/{cinema}', [CinemaController::class, 'update']);
    Route::delete('/cinemas/{cinema}', [CinemaController::class, 'destroy']);

    Route::post('/halls', [HallController::class, 'store']);
    Route::put('/halls/{hall}', [HallController::class, 'update']);
    Route::delete('/halls/{hall}', [HallController::class, 'destroy']);

    Route::post('/seats', [SeatController::class, 'store']);
    Route::put('/seats/{seat}', [SeatController::class, 'update']);
    Route::delete('/seats/{seat}', [SeatController::class, 'destroy']);

    Route::post('/showtimes', [ShowtimeController::class, 'store']);
    Route::put('/showtimes/{showtime}', [ShowtimeController::class, 'update']);
    Route::delete('/showtimes/{showtime}', [ShowtimeController::class, 'destroy']);

});

