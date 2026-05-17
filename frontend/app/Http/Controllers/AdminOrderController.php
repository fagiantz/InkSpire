<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OrderService;

class AdminOrderController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Menampilkan daftar semua pesanan aktif (hanya staff).
     */
    public function index()
    {
        if (!session('token')) {
            return redirect()->route('login');
        }

        $user = session('user', []);

        // Proteksi ganda: hanya staff yang bisa akses
        if (!isset($user['role']) || $user['role'] !== 'staff') {
            return redirect()->route('main')->with('error', 'Akses khusus admin.');
        }

        $response = $this->orderService->getActiveOrders();
        $orders = $response['data'] ?? [];

        return view('admin.orders', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        if (!session('token')) {
            return redirect()->route('login');
        }

        $user = session('user', []);
        if (!isset($user['role']) || $user['role'] !== 'staff') {
            return redirect()->route('home')->with('error', 'Akses khusus admin.');
        }

        $request->validate([
            'status' => 'required|in:unpaid,process,done,paid',
        ]);

        $data = $this->orderService->updateStatus((int) $id, $request->status);

        if (isset($data['error'])) {
            return back()->with('error', $data['error']);
        }

        return redirect()->route('admin.orders')->with('success', 'Status pesanan berhasil diperbarui!');
    }

    /**
     * Proxy request ke backend Go untuk menampilkan bukti pembayaran.
     */
    public function viewReceipt($filename)
    {
        if (!session('token')) {
            abort(401);
        }

        $user = session('user', []);
        if (!isset($user['role']) || $user['role'] !== 'staff') {
            abort(403, 'Akses khusus admin.');
        }

        $backendHost = env('BACKEND_HOST', 'localhost');
        $backendPort = env('BACKEND_PORT', '5000');
        $backendUrl = "http://{$backendHost}:{$backendPort}/receipts/{$filename}";

        $token = session('token');
        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->get($backendUrl);

        if ($response->failed()) {
            abort(404, 'Bukti pembayaran tidak ditemukan.');
        }

        $contentType = $response->header('Content-Type') ?: 'image/jpeg';

        return response($response->body(), 200)
            ->header('Content-Type', $contentType);
    }
}