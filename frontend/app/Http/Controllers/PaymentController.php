<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Menampilkan halaman pembayaran dengan data pesanan terbaru.
     */
    public function create()
    {
        if (!session('token')) {
            return redirect()->route('login');
        }

        // Ambil data pesanan terakhir dari session
        $order = session('last_order');

        if (!$order) {
            return redirect()->route('dashboard')->with('error', 'Tidak ada pesanan yang perlu dibayar.');
        }

        return view('payment.create', compact('order'));
    }
}