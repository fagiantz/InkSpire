<?php

namespace App\Services;

class AuthService
{
    protected ApiClient $client;

    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    public function login(string $email, string $password): array
    {
        $response = $this->client->request('post', '/auth/login', [
            'email' => $email,
            'password' => $password,
        ]);

        return $response->json();
    }

    public function logout(): array
    {
        $response = $this->client->request('post', '/auth/logout');
        return $response->json();
    }

    public function register(string $email, string $password, string $name): array
    {
        $response = $this->client->request('post', '/auth/register', [
            'email' => $email,
            'password' => $password,
            'name' => $name,
        ]);

        return $response->json();
    }
    
}