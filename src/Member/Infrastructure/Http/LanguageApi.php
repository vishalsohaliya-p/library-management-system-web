<?php

namespace App\Member\Infrastructure\Http;

class LanguageApi
{
    public function __construct(private ApiClient $apiClient) {}

    public function getAll(): array
    {
        return $this->apiClient->request('GET', '/language/');
    }

    public function getById(int $id): array
    {
        return $this->apiClient->request('GET', "/language/{$id}");
    }

    public function add(array $data): array
    {
        return $this->apiClient->request('POST', '/language/', ['json' => $data]);
    }

    public function update(int $id, array $data): array
    {
        return $this->apiClient->request('PUT', "/language/{$id}", ['json' => $data]);
    }

    public function delete(int $id): array
    {
        return $this->apiClient->request('DELETE', "/language/{$id}");
    }
}
