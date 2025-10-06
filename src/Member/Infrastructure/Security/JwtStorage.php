<?php

namespace App\Member\Infrastructure\Security;

use Symfony\Component\HttpFoundation\RequestStack;

class JwtStorage
{
    private const SESSION_KEY = 'jwt_token';

    public function __construct(
        private RequestStack $requestStack
    ) {}

    public function saveToken(string $token): void
    {
        $this->requestStack->getSession()->set(self::SESSION_KEY, $token);
    }

    public function getToken(): ?string
    {
        return $this->requestStack->getSession()->get(self::SESSION_KEY);
    }

    public function clearToken(): void
    {
        $this->requestStack->getSession()->remove(self::SESSION_KEY);
    }

    public function isTokenExpired(): bool
    {
        $token = $this->getToken();
        if (!$token) {
            return true;
        }

        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            return true; // invalid format
        }

        $payload = json_decode(base64_decode(strtr($parts[1], '-_', '+/')), true);

        if (!isset($payload['exp'])) {
            return true;
        }

        return $payload['exp'] < time();
    }
}
