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

    public function index(Request $request)
    {
        $response = $this->produkService->getAll();
        $produks = $response['data'] ?? [];

        $query = $request->query('query');
        if (!empty($query)) {
            $produks = array_filter($produks, function ($produk) use ($query) {
                return stripos($produk['nama_produk'], $query) !== false;
            });
        }

        $cat = $request->query('cat');
        if (!empty($cat)) {
            $produks = array_filter($produks, function ($produk) use ($cat) {
                return strtolower($produk['kategori'] ?? '') === strtolower($cat);
            });
        }

        $produks = array_values($produks);

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

    public function viewProductImage($filename)
    {
        $cachePath = storage_path("app/products/{$filename}");
        $ttl = 3600;

        if (file_exists($cachePath) && (time() - filemtime($cachePath)) < $ttl) {
            $contentType = mime_content_type($cachePath) ?: 'image/jpeg';
            return response()->file($cachePath, ['Content-Type' => $contentType]);
        }

        $backendHost = env('BACKEND_HOST', 'localhost');
        $backendPort = env('BACKEND_PORT', '5000');
        $backendUrl = "http://{$backendHost}:{$backendPort}/products/{$filename}";

        $response = \Illuminate\Support\Facades\Http::get($backendUrl);

        if ($response->failed()) {
            if (file_exists($cachePath)) {
                $contentType = mime_content_type($cachePath) ?: 'image/jpeg';
                return response()->file($cachePath, ['Content-Type' => $contentType]);
            }
            abort(404, 'Gambar produk tidak ditemukan.');
        }

        $body = $response->body();
        $contentType = $response->header('Content-Type') ?: 'image/jpeg';

        try {
            $dir = dirname($cachePath);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            file_put_contents($cachePath, $body);
        } catch (\Exception $e) {
        }

        return response($body, 200)
            ->header('Content-Type', $contentType);
    }
}