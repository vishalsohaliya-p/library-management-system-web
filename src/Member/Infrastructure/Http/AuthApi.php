<?php

namespace App\Member\Infrastructure\Http;

class AuthApi
{
    public function __construct(private ApiClient $apiClient) {}

    public function login(string $email, string $password): array
    {
        return $this->apiClient->request('POST', '/librarian/login', [
            'json' => ['email' => $email, 'password' => $password]
        ]);
    }
}
