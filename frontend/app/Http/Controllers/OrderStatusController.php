<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OrderService;

class OrderStatusController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Menampilkan halaman status pesanan terbaru.
     */
    public function show()
    {
        if (!session('token')) {
            return redirect()->route('login');
        }

        // Ambil data pesanan terakhir dari session (sama dengan payment)
        $order = session('last_order');

        if (!$order) {
            return redirect()->route('dashboard')->with('error', 'Tidak ada pesanan yang perlu dicek.');
        }

        return view('orders.status', compact('order'));
    }
}