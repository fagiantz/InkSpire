<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Landing page (hanya untuk yang sudah login)
Route::get('/home', function () {
    // Cek manual session token
    if (!session('token')) {
        return redirect()->route('login');
    }
    return view('landing');
})->name('home');

// Halaman utama (redirect ke home jika sudah login)
Route::get('/', function () {
    if (session('token')) {
        return redirect()->route('home');
    }
    return view('welcome'); // atau langsung redirect ke login
})->name('main');

// Register
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/katalog', function () {
    return view('katalog'); // nanti buat view katalog.blade.php
})->name('katalog');