<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminProdukController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;

// Halaman utama
Route::get('/', function () {
    if (session('token')) {
        $user = session('user');
        if ($user && isset($user['role']) && $user['role'] === 'staff') {
            return redirect()->route('admin.orders');
        }
        return redirect()->route('home');
    }
    return redirect()->route('login');
})->name('main');

// Landing page
Route::get('/home', function () {
    if (!session('token')) {
        return redirect()->route('login');
    }
    return view('landing');
})->name('home');

// Autentikasi
Route::redirect('/register', '/login');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Katalog
Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog');

// User Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Orders (User)
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.detail');

// Payment
Route::get('/payment', [PaymentController::class, 'create'])->name('payment.create');
Route::post('/payment', [PaymentController::class, 'store'])->name('payment.store');

// Order Status
Route::get('/orders/status', [OrderStatusController::class, 'show'])->name('orders.status');

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

// Buat Pesanan
Route::get('/order/create/{id}', [OrderController::class, 'create'])->name('orders.create');
Route::post('/order/store', [OrderController::class, 'store'])->name('orders.store');

// Detail Produk
Route::get('/produk/{id}', [KatalogController::class, 'show'])->name('produk.detail');

// Admin Routes (staff only)
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders');
    Route::put('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

    Route::get('/produk', [AdminProdukController::class, 'index'])->name('produk.index');
    Route::post('/produk', [AdminProdukController::class, 'store'])->name('produk.store');
    Route::put('/produk/{id}', [AdminProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}', [AdminProdukController::class, 'destroy'])->name('produk.destroy');
});
