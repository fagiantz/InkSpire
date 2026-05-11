<?php

namespace App\Services;

class AdminService
{
    protected ApiClient $client;

    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    public function getStats(): array
    {
        $response = $this->client->request('get', '/order/stats');
        return $response->json();
    }
}