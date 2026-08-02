<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Web\BookingController as WebBookingController;
use App\Http\Controllers\Web\MovieController;

use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\CinemaController as AdminCinemaController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\HallController as AdminHallController;
use App\Http\Controllers\Admin\MovieController as AdminMovieController;
use App\Http\Controllers\Admin\ShowtimeController as AdminShowtimeController;
use App\Http\Controllers\Admin\UserController as AdminUserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class,'index'])->name('home');

Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');

// Booking flow: pick a screening on the movie page, then choose seats.
Route::get('/showtimes/{showtime}/seats', [WebBookingController::class, 'seats'])
    ->middleware('auth')
    ->name('booking.seats');

Route::middleware('auth')->group(function () {
    Route::post('/bookings', [WebBookingController::class, 'store'])->name('bookings.store');
    Route::get('/my-tickets', [WebBookingController::class, 'index'])->name('bookings.index');
    Route::get('/my-tickets/{booking}', [WebBookingController::class, 'show'])->name('bookings.show');
    Route::patch('/my-tickets/{booking}/cancel', [WebBookingController::class, 'cancel'])->name('bookings.cancel');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])
->prefix('admin')
->name('admin.')
->group(function(){

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Movies Resource
    Route::get('/movies', [AdminMovieController::class, 'index'])->name('movies.index');
    Route::get('/movies/create', [AdminMovieController::class, 'create'])->name('movies.create');
    Route::post('/movies', [AdminMovieController::class, 'store'])->name('movies.store');
    Route::get('/movies/{movie}/edit', [AdminMovieController::class, 'edit'])->name('movies.edit');
    Route::put('/movies/{movie}', [AdminMovieController::class, 'update'])->name('movies.update');
    Route::delete('/movies/{movie}', [AdminMovieController::class, 'destroy'])->name('movies.destroy');

    // Cinemas Resource
    Route::get('/cinemas', [AdminCinemaController::class, 'index'])->name('cinemas.index');
    Route::get('/cinemas/create', [AdminCinemaController::class, 'create'])->name('cinemas.create');
    Route::post('/cinemas', [AdminCinemaController::class, 'store'])->name('cinemas.store');
    Route::get('/cinemas/{cinema}/edit', [AdminCinemaController::class, 'edit'])->name('cinemas.edit');
    Route::put('/cinemas/{cinema}', [AdminCinemaController::class, 'update'])->name('cinemas.update');
    Route::delete('/cinemas/{cinema}', [AdminCinemaController::class, 'destroy'])->name('cinemas.destroy');

    // Halls Resource
    Route::get('/halls', [AdminHallController::class, 'index'])->name('halls.index');
    Route::get('/halls/create', [AdminHallController::class, 'create'])->name('halls.create');
    Route::post('/halls', [AdminHallController::class, 'store'])->name('halls.store');
    Route::get('/halls/{hall}/edit', [AdminHallController::class, 'edit'])->name('halls.edit');
    Route::put('/halls/{hall}', [AdminHallController::class, 'update'])->name('halls.update');
    Route::delete('/halls/{hall}', [AdminHallController::class, 'destroy'])->name('halls.destroy');

    // Showtimes Resource
    Route::get('/showtimes', [AdminShowtimeController::class, 'index'])->name('showtimes.index');
    Route::get('/showtimes/create', [AdminShowtimeController::class, 'create'])->name('showtimes.create');
    Route::post('/showtimes', [AdminShowtimeController::class, 'store'])->name('showtimes.store');
    Route::get('/showtimes/{showtime}/edit', [AdminShowtimeController::class, 'edit'])->name('showtimes.edit');
    Route::put('/showtimes/{showtime}', [AdminShowtimeController::class, 'update'])->name('showtimes.update');
    Route::delete('/showtimes/{showtime}', [AdminShowtimeController::class, 'destroy'])->name('showtimes.destroy');

    // Bookings Resource
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create', [AdminBookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [AdminBookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::get('/bookings/{booking}/edit', [AdminBookingController::class, 'edit'])->name('bookings.edit');
    Route::put('/bookings/{booking}', [AdminBookingController::class, 'update'])->name('bookings.update');
    Route::delete('/bookings/{booking}', [AdminBookingController::class, 'destroy'])->name('bookings.destroy');

    // Users Resource
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
    Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

});

require __DIR__.'/auth.php';
