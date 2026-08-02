<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Web\MovieController;


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

// Booking routes
Route::get('/movies/{movie}/showtime', function($movie) {
    $movie = \App\Models\Movie::findOrFail($movie);
    return view('booking.showtime', compact('movie'));
})->name('booking.showtime');

Route::get('/booking/seats', function() {
    return view('booking.seats');
})->name('booking.seats');

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

    Route::get('/dashboard', function(){
        return view('admin.dashboard');
    })->name('dashboard');

    // Movies Resource
    Route::get('/movies', function() {
        return view('admin.movies.index');
    })->name('movies.index');

    // Cinemas Resource
    Route::get('/cinemas', function() {
        return view('admin.cinemas.index');
    })->name('cinemas.index');

    // Halls Resource
    Route::get('/halls', function() {
        return view('admin.halls.index');
    })->name('halls.index');

    // Showtimes Resource
    Route::get('/showtimes', function() {
        return view('admin.showtimes.index');
    })->name('showtimes.index');

    // Bookings Resource
    Route::get('/bookings', function() {
        return view('admin.bookings.index');
    })->name('bookings.index');

    // Users Resource
    Route::get('/users', function() {
        return view('admin.users.index');
    })->name('users.index');

});

require __DIR__.'/auth.php';
