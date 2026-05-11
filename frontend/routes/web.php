<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminProdukController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\AdminDashboardController;

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
Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog');

// User Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Orders (User)
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/detail', function () {
    if (!session('token')) {
        return redirect()->route('login');
    }
    return view('orders.detail');
})->name('orders.detail');

// Payment
Route::get('/payment', [PaymentController::class, 'create'])->name('payment.create');

// Order Status
Route::get('/orders/status', [OrderStatusController::class, 'show'])->name('orders.status');

// Buat Pesanan
Route::get('/order/create/{id}', [OrderController::class, 'create'])->name('orders.create');
Route::post('/order/store', [OrderController::class, 'store'])->name('orders.store');

// Detail Produk
Route::get('/produk/{id}', [KatalogController::class, 'show'])->name('produk.detail');

// Admin Routes (staff only)
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders');
    Route::put('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Admin Produk (CRUD)
    Route::get('/produk', [AdminProdukController::class, 'index'])->name('produk.index');
    Route::post('/produk', [AdminProdukController::class, 'store'])->name('produk.store');
    Route::put('/produk/{id}', [AdminProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}', [AdminProdukController::class, 'destroy'])->name('produk.destroy');
});