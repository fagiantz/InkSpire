<?php

namespace App\Services;

class OrderService
{
    protected ApiClient $client;

    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    public function create(array $items): array
    {
        $response = $this->client->request('post', '/order', ['items' => $items]);
        return $response->json();
    }

    public function getMyActiveOrders(): array
    {
        $response = $this->client->request('get', '/order/my-active');
        return $response->json();
    }

    public function getActiveOrders(): array
    {
        $response = $this->client->request('get', '/order/active');
        return $response->json();
    }

    public function updateStatus(int $orderId, string $status): array
    {
        $response = $this->client->request('put', "/order/{$orderId}/status", [
            'status' => $status,
        ]);
        return $response->json();
    }

    public function getOrderById(int $id): array
    {
        $response = $this->client->request('get', "/order/{$id}");
        return $response->json();
    }

    /**
     * Upload bukti pembayaran ke backend Go.
     */
    public function uploadReceipt(int $orderId, $file): array
    {
        $response = $this->client->request('post', "/order/{$orderId}/receipt", [
            'receipt' => $file,
        ], true); // true = multipart

        return $response->json();
    }
}