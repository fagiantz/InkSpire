<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class ApiClient
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('app.go_backend_url');
    }

    public function request(string $method, string $endpoint, array $data = []): Response
    {
        $token = session('token');
        $headers = [];
        if ($token) {
            $headers['Authorization'] = 'Bearer ' . $token;
        }

        $url = $this->baseUrl . $endpoint;

        return Http::withHeaders($headers)->$method($url, $data);
    }
}