<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProdukService;
use App\Services\OrderService;

class CartController extends Controller
{
    protected ProdukService $produkService;
    protected OrderService $orderService;

    public function __construct(ProdukService $produkService, OrderService $orderService)
    {
        $this->produkService = $produkService;
        $this->orderService = $orderService;
    }

    public function index()
    {
        if (!session('token')) {
            return redirect()->route('login');
        }

        $cart = session()->get('cart', []);
        
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        if (!session('token')) {
            return redirect()->route('login');
        }

        $id = $request->id_produk;
        $kuantitas = (int) $request->kuantitas;

        $response = $this->produkService->getById((int) $id);
        $produk = $response['data'] ?? null;

        if (!$produk) {
            return back()->with('error', 'Produk tidak ditemukan.');
        }

        $cart = session()->get('cart', []);

        // Jika produk sudah ada di keranjang, tambahkan kuantitasnya
        if (isset($cart[$id])) {
            $cart[$id]['kuantitas'] += $kuantitas;
        } else {
            // Jika belum ada, tambahkan ke keranjang
            $cart[$id] = [
                'id_produk' => $produk['id_produk'],
                'nama_produk' => $produk['nama_produk'],
                'harga' => $produk['harga'],
                'kuantitas' => $kuantitas,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Produk ditambahkan ke keranjang!');
    }

    public function remove(Request $request)
    {
        if (!session('token')) {
            return redirect()->route('login');
        }

        $id = $request->id_produk;
        $cart = session()->get('cart');

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    public function checkout(Request $request)
    {
        if (!session('token')) {
            return redirect()->route('login');
        }

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Keranjang kosong.');
        }

        $items = [];
        foreach ($cart as $item) {
            $items[] = [
                'id_produk' => (int) $item['id_produk'],
                'kuantitas' => (int) $item['kuantitas'],
            ];
        }

        $data = $this->orderService->create($items);

        if (isset($data['error'])) {
            return back()->with('error', $data['error']);
        }

        // Hapus session keranjang setelah checkout berhasil
        session()->forget('cart');
        session(['last_order' => $data['data']]);

        return redirect()->route('payment.create', ['order_id' => $data['data']['id_pesanan']])->with('success', 'Checkout berhasil! Silakan lanjutkan pembayaran.');
    }
}
