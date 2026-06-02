<?php

namespace App\Http\Controllers;

use App\Services\OrderService;

class OrderStatusController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function show()
    {
        if (!session('token')) {
            return redirect()->route('login');
        }

        $order = session('last_order');

        if (!$order) {
            return redirect()->route('dashboard')->with('error', 'Tidak ada pesanan yang perlu dicek.');
        }

        return view('orders.status', compact('order'));
    }
}