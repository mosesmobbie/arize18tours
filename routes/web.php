<?php

use App\Mail\NewBookingNotification;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\InvoiceController;
use \App\Http\Controllers\Booking;
use App\Http\Controllers\FleetController;
use App\Models\Booking as BookingModel;
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
Route::get('/fleet', [FleetController::class, 'index'])->name('fleet');
Route::get('/booking', [Booking::class, 'index'])->name('booking');
Route::post('/booking', [Booking::class, 'store'])->name('booking.store');

Route::get('/dev/mail/booking-preview', function () {
    abort_unless(app()->environment('local'), 404);

    $booking = BookingModel::query()->latest()->first() ?? new BookingModel([
        'service_type' => 'shuttle',
        'vehicle_type' => 'standard',
        'name' => 'Demo Customer',
        'email' => 'demo@example.com',
        'phone' => '0712345678',
        'pickup_address' => 'Johannesburg Airport',
        'dropoff_address' => 'Sandton Hotel',
        'pickup_time' => now()->addDay()->toDateTimeString(),
        'dropoff_time' => now()->addDay()->addHour()->toDateTimeString(),
        'passengers' => 2,
        'transmission' => 'Auto',
        'flight_number' => 'SA123',
        'reservation_number' => 'RES-001',
        'id_number' => '9001015009087',
        'notes' => 'Demo preview booking',
    ]);

    return (new NewBookingNotification($booking))->render();
})->name('dev.mail.booking-preview');

Route::middleware('auth')->group(function () {
    Route::get('/invoice/preview', [InvoiceController::class, 'preview'])->name('invoice.preview');
    Route::get('/invoice/download', [InvoiceController::class, 'generateInvoice'])->name('invoice.download');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

