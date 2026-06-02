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


}