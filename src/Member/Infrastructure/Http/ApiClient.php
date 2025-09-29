<?php

namespace App\Member\Infrastructure\Http;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Member\Infrastructure\Security\JwtStorage;

class ApiClient
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private RequestStack $requestStack,
        private JwtStorage $jwtStorage,
    ) {}

    public function request(string $method, string $uri, array $options = [])
    {
        $token = $this->jwtStorage->getToken();

        if ($token) {
            $options['headers']['Authorization'] = 'Bearer ' . $token;
        }

        $response = $this->httpClient->request($method, $_ENV['API_BASE_URL'] . $uri, $options);

        return $response->toArray(false); // return array, don’t throw on 4xx/5xx
    }
}
