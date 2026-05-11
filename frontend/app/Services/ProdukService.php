<?php

// 1. Wajib ada namespace ini
namespace App\Services;

class ProdukService
{
    protected ApiClient $client;

    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    public function getAll(): array
    {
        $response = $this->client->request('get', '/produk');
        return $response->json();
    }

    public function getById(int $id): array
    {
        $response = $this->client->request('get', '/produk/' . $id);
        return $response->json();
    }

    public function create(string $namaProduk, float $harga): array
    {
        $response = $this->client->request('post', '/produk', [
            'nama_produk' => $namaProduk,
            'harga' => $harga,
        ]);
        return $response->json();
    }

    public function update(int $id, string $namaProduk, float $harga): array
    {
        $response = $this->client->request('put', '/produk/' . $id, [
            'nama_produk' => $namaProduk,
            'harga' => $harga,
        ]);
        return $response->json();
    }

    public function delete(int $id): array
    {
        $response = $this->client->request('delete', '/produk/' . $id);
        return $response->json();
    }
}