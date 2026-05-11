<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Services\ProdukService;

class OrderController extends Controller
{
    protected OrderService $orderService;
    protected ProdukService $produkService;

    public function __construct(OrderService $orderService, ProdukService $produkService)
    {
        $this->orderService = $orderService;
        $this->produkService = $produkService;
    }

    /**
     * Menampilkan halaman form pemesanan.
     */
    public function create($id)
    {
        if (!session('token')) {
            return redirect()->route('login');
        }

        $response = $this->produkService->getById((int) $id);
        $produk = $response['data'] ?? null;

        if (!$produk) {
            return redirect()->route('katalog')->with('error', 'Produk tidak ditemukan.');
        }

        return view('orders.create', compact('produk'));
    }

    /**
     * Menyimpan pesanan baru ke backend Go.
     */
    public function store(Request $request)
    {
        if (!session('token')) {
            return redirect()->route('login');
        }

        $request->validate([
            'id_produk' => 'required|integer',
            'kuantitas' => 'required|integer|min:1',
        ]);

        $data = $this->orderService->create([
            [
                'id_produk' => (int) $request->id_produk,
                'kuantitas' => (int) $request->kuantitas,
            ]
        ]);

        if (isset($data['error'])) {
            return back()->with('error', $data['error'])->withInput();
        }

        session(['last_order' => $data['data']]);

        return redirect()->route('payment.create')->with('success', 'Pesanan berhasil dibuat! Silakan lanjutkan pembayaran.');
    }

    /**
     * Menampilkan daftar pesanan aktif milik user yang login.
     */
    public function index()
    {
        if (!session('token')) {
            return redirect()->route('login');
        }

        $response = $this->orderService->getMyActiveOrders();
        $orders = $response['data'] ?? [];

        return view('orders.index', compact('orders'));
    }
}