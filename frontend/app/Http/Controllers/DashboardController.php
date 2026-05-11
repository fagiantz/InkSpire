<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OrderService;

class DashboardController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        // Cek apakah user sudah login
        if (!session('token')) {
            return redirect()->route('login');
        }

        // Ambil data pesanan aktif dari backend Go
        $response = $this->orderService->getMyActiveOrders();
        $orders = $response['data'] ?? [];

        return view('dashboard', compact('orders'));
    }
}