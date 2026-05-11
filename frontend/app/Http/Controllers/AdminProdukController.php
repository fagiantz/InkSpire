<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProdukService;

class AdminProdukController extends Controller
{
    protected ProdukService $produkService;

    public function __construct(ProdukService $produkService)
    {
        $this->produkService = $produkService;
    }

    /**
     * Menampilkan daftar semua produk (staff only).
     */
    public function index()
    {
        if (!session('token')) {
            return redirect()->route('login');
        }

        $user = session('user', []);
        if (!isset($user['role']) || $user['role'] !== 'staff') {
            return redirect()->route('home')->with('error', 'Akses khusus admin.');
        }

        $response = $this->produkService->getAll();
        $produks = $response['data'] ?? [];

        return view('admin.produk.index', compact('produks'));
    }

    /**
     * Menyimpan produk baru (staff only).
     */
    public function store(Request $request)
    {
        if (!session('token')) {
            return redirect()->route('login');
        }

        $user = session('user', []);
        if (!isset($user['role']) || $user['role'] !== 'staff') {
            return redirect()->route('home')->with('error', 'Akses khusus admin.');
        }

        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
        ]);

        $data = $this->produkService->create(
            $request->nama_produk,
            (float) $request->harga
        );

        if (isset($data['error'])) {
            return back()->with('error', $data['error'])->withInput();
        }

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Mengupdate produk (staff only).
     */
    public function update(Request $request, $id)
    {
        if (!session('token')) {
            return redirect()->route('login');
        }

        $user = session('user', []);
        if (!isset($user['role']) || $user['role'] !== 'staff') {
            return redirect()->route('home')->with('error', 'Akses khusus admin.');
        }

        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
        ]);

        $data = $this->produkService->update(
            (int) $id,
            $request->nama_produk,
            (float) $request->harga
        );

        if (isset($data['error'])) {
            return back()->with('error', $data['error'])->withInput();
        }

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Menghapus produk (staff only).
     */
    public function destroy($id)
    {
        if (!session('token')) {
            return redirect()->route('login');
        }

        $user = session('user', []);
        if (!isset($user['role']) || $user['role'] !== 'staff') {
            return redirect()->route('home')->with('error', 'Akses khusus admin.');
        }

        $data = $this->produkService->delete((int) $id);

        if (isset($data['error'])) {
            return back()->with('error', $data['error']);
        }

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}