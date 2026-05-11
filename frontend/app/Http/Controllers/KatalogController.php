<?php

namespace App\Http\Controllers;

use App\Services\ProdukService;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    protected ProdukService $produkService;

    public function __construct(ProdukService $produkService)
    {
        $this->produkService = $produkService;
    }

    public function index()
    {
        $response = $this->produkService->getAll();
        $produks = $response['data'] ?? [];
        return view('katalog', compact('produks'));
    }

    public function show($id)
    {
        $response = $this->produkService->getById((int) $id);

        if (isset($response['error'])) {
            return redirect()->route('katalog')->with('error', $response['error']);
        }

        $produk = $response['data'] ?? null;
        if (!$produk) {
            return redirect()->route('katalog')->with('error', 'Produk tidak ditemukan.');
        }

        return view('produk.detail', compact('produk'));
    }
    
}