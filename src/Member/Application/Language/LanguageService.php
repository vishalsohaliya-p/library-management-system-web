<?php

namespace App\Member\Application\Language;

use App\Member\Infrastructure\Http\LanguageApi;

class LanguageService
{
    public function __construct(private LanguageApi $languageApi) {}

    public function getAll(): array
    {
        $response = $this->languageApi->getAll();
        return $response['data'] ?? [];
    }

    public function getById(int $id): array
    {
        $response = $this->languageApi->getById($id);
        return $response['data'] ?? [];
    }

    public function add(array $data): bool
    {
        $response = $this->languageApi->add($data);
        return ($response['status'] ?? false) === true;
    }

    public function update(int $id, array $data): bool
    {
        $response = $this->languageApi->update($id, $data);
        return ($response['status'] ?? false) === true;
    }

    public function delete(int $id): bool
    {
        $response = $this->languageApi->delete($id);
        return ($response['status'] ?? false) === true;
    }
}
