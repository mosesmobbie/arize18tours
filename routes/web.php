<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiteController;
use \App\Http\Controllers\Booking;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [SiteController::class, 'index'])->name('home');
Route::get('/about-us', [SiteController::class, 'about'])->name('about-us');
Route::redirect('/services', '/services/shuttle');
Route::get('/services/{slug}', [SiteController::class, 'services'])->name('services');
Route::get('/fleet', [SiteController::class, 'fleet'])->name('fleet');
Route::get('/booking', [Booking::class, 'index'])->name('booking');
Route::post('/booking', [Booking::class, 'store'])->name('booking.store');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

