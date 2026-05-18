<?php

namespace App\Http\Controllers;

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
        if (!session('token')) {
            return redirect()->route('login');
        }

        $response = $this->orderService->getMyActiveOrders();
        $orders = $response['data'] ?? [];

        return view('dashboard', compact('orders'));
    }

}