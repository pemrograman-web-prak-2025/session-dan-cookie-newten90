<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('events.index');
});

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Dark Mode Toggle Route
Route::post('/toggle-dark-mode', [AuthController::class, 'toggleDarkMode'])->name('toggle.dark.mode');

// Event Routes
Route::middleware('auth')->group(function () {
    Route::resource('events', EventController::class);
    Route::patch('/events/{event}/toggle-complete', [EventController::class, 'toggleComplete'])->name('events.toggle-complete');
});