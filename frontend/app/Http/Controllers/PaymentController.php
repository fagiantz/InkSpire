<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OrderService;

class PaymentController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function create(Request $request)
    {
        if (!session('token')) {
            return redirect()->route('login');
        }

        $orderId = $request->query('order_id');

        // Fallback to session last_order if no query param is provided
        if (!$orderId) {
            $lastOrder = session('last_order');
            if ($lastOrder && isset($lastOrder['id_pesanan'])) {
                $orderId = $lastOrder['id_pesanan'];
            }
        }

        if (!$orderId) {
            return redirect()->route('dashboard')->with('error', 'Tidak ada pesanan yang perlu dibayar.');
        }

        $response = $this->orderService->getOrderById((int) $orderId);
        $order = $response['data'] ?? null;

        if (!$order) {
            return redirect()->route('dashboard')->with('error', 'Pesanan tidak ditemukan.');
        }

        return view('payment.create', compact('order'));
    }

    public function store(Request $request)
    {
        if (!session('token')) {
            return redirect()->route('login');
        }

        $request->validate([
            'order_id' => 'required|integer',
            'receipt'  => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $this->orderService->uploadReceipt(
            (int) $request->order_id,
            $request->file('receipt')
        );

        if (isset($data['error'])) {
            return back()->with('error', $data['error'])->withInput();
        }

        // Hapus data pesanan dari session setelah berhasil
        session()->forget('last_order');

        return redirect()->route('orders.status')
            ->with('success', 'Bukti pembayaran berhasil diupload! Pesanan Anda sedang diproses.');
    }
}