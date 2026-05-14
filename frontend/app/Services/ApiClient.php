<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class ApiClient
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('app.go_backend_url', env('GO_BACKEND_URL', 'http://127.0.0.1:8080/api'));
    }

    /**
     * Kirim permintaan ke backend Go.
     */
    public function request(string $method, string $endpoint, array $data = [], bool $multipart = false): Response
    {
        $token = session('token');
        $headers = [];
        if ($token) {
            $headers['Authorization'] = 'Bearer ' . $token;
        }

        $url = $this->baseUrl . $endpoint;

        if ($multipart) {
            // Untuk upload file
            $http = Http::withHeaders($headers)->asMultipart();
            foreach ($data as $key => $value) {
                if ($value instanceof \Illuminate\Http\UploadedFile) {
                    $http->attach($key, file_get_contents($value->getPathname()), $value->getClientOriginalName());
                } else {
                    $http->attach($key, $value);
                }
            }
            return $http->post($url);
        }

        return Http::withHeaders($headers)->$method($url, $data);
    }
}