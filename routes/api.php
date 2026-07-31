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
 
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'admin'])->group(function () {

    Route::apiResource('movies', MovieController::class);
    Route::apiResource('cinemas', CinemaController::class);
    Route::apiResource('halls', HallController::class);
    Route::apiResource('seats', SeatController::class);
    Route::apiResource('showtimes', ShowtimeController::class);

});

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/profile', [AuthController::class, 'profile']);

    Route::put('/profile', [AuthController::class, 'updateProfile']);

    Route::post('/bookings', [BookingController::class, 'book']);
    Route::get('/bookings', [BookingController::class, 'index']);   // keep it in private , can access iff user login or register
    Route::get('/bookings/{booking}', [BookingController::class, 'show']);
    Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel']);


});
