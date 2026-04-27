<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Halaman utama
Route::get('/', function () {
    if (session('token')) {
        $user = session('user');
        if ($user && isset($user['role']) && $user['role'] === 'staff') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('home');
    }
    return view('welcome');
})->name('main');

// Landing page khusus user biasa
Route::get('/home', function () {
    if (!session('token')) {
        return redirect()->route('login');
    }
    return view('landing');
})->name('home');

// Autentikasi
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Katalog
Route::get('/katalog', function () {
    return view('katalog');
})->name('katalog');

// User Dashboard
Route::get('/dashboard', function () {
    if (!session('token')) {
        return redirect()->route('login');
    }
    return view('dashboard');
})->name('dashboard');

// Orders
Route::get('/orders', function () {
    if (!session('token')) {
        return redirect()->route('login');
    }
    return view('orders.index');
})->name('orders.index');

Route::get('/orders/detail', function () {
    if (!session('token')) {
        return redirect()->route('login');
    }
    return view('orders.detail');
})->name('orders.detail');

// Payment
Route::get('/payment', function () {
    if (!session('token')) {
        return redirect()->route('login');
    }
    return view('payment.create');
})->name('payment.create');

// Order Status
Route::get('/orders/status', function () {
    if (!session('token')) {
        return redirect()->route('login');
    }
    return view('orders.status');
})->name('orders.status');

// Admin Routes (hanya untuk staff)
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/orders', function () {
        return view('admin.orders');
    })->name('orders');
});