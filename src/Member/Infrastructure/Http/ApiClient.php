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

        // Get HTTP status code
        $statusCode = $response->getStatusCode();

        // Get raw content without throwing on 4xx/5xx
        $content = $response->getContent(false);

        if (!empty($content)) {
            // Decode JSON body if exists
            return $response->toArray(false);
        }

        // No content returned (204, DELETE, PUT without body)
        // Consider 2xx status as success
        if ($statusCode >= 200 && $statusCode < 300) {
            return ['success' => true];
        }

        // If 4xx/5xx and no content, return false
        return ['success' => false];
    }
}
