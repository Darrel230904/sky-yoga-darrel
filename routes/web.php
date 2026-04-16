<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Member\BookingController as MemberBookingController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use Illuminate\Support\Facades\Route;

// --- Public Routes (Web Platform) ---
Route::get('/', [LandingPageController::class, 'index'])->name('landing');

// Autentikasi [cite: 19]
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// --- Member Routes (Self-Service)  ---
Route::middleware(['auth', 'role:member'])->group(function () {
    Route::get('/booking', [MemberBookingController::class, 'index'])->name('member.booking.index');
    Route::post('/booking/{schedule}', [MemberBookingController::class, 'store'])->name('member.booking.store');
    Route::get('/my-bookings', [MemberBookingController::class, 'history'])->name('member.booking.history');
});

// --- Admin Routes (Sky Yoga CMS) [cite: 25] ---
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    // Manajemen Data Member [cite: 34]
    Route::get('/members', [MemberController::class, 'index'])->name('admin.members.index');
    Route::get('/members/{user}', [MemberController::class, 'show'])->name('admin.members.show');

    // Pengaturan Slot & Jadwal [cite: 39]
    Route::resource('schedules', ScheduleController::class)->names('admin.schedules');

    // Monitoring Booking [cite: 37]
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('admin.bookings.index');
});