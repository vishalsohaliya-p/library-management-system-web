<?php

namespace App\Member\Application\Auth;

use App\Member\Infrastructure\Http\AuthApi;
use App\Member\Infrastructure\Security\JwtStorage;

class AuthService
{
    public function __construct(
        private AuthApi $authApi,
        private JwtStorage $jwtStorage
    ) {}

    public function login(string $email, string $password): bool
    {
        $response = $this->authApi->login($email, $password);

        if (isset($response['data']['token'])) {
            $this->jwtStorage->saveToken($response['data']['token']);
            return true;
        }

        return false;
    }

    public function logout(): void
    {
        $this->jwtStorage->clearToken();
    }
}
