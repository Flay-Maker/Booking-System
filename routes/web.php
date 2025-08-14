<?php

use Illuminate\Support\Facades\Route;



 use App\Http\Controllers\BookingController;


// Route::get('/', function () {
//     return view('homepage.landing');
// });

Route::get('/', [BookingController::class, 'create'])->name('appointment.form');

Route::get('/admin', [BookingController::class, 'index'])->name('admin.page');

Route::post('/submit', [BookingController::class, 'store'])->name('appointment.store');

// Admin form (modal in admin page)
Route::post('/admin/submit', [BookingController::class, 'adminStore'])->name('appointment.admin.store');
// CRUD
Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
Route::get('/booking/{id}/edit', [BookingController::class, 'edit'])->name('booking.edit');
Route::put('/booking/{id}', [BookingController::class, 'update'])->name('booking.update');
Route::delete('/booking/{id}', [BookingController::class, 'destroy'])->name('booking.destroy');

