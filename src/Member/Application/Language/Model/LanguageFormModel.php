<?php

namespace App\Member\Application\Language\Model;

class LanguageFormModel
{
    private int $languageId;
    private string $languageName;
    private bool $isActive;
    private bool $isDeleted;

    public function getLanguageId(): int { return $this->languageId; }
    public function setLanguageId(int $id): void { $this->languageId = $id; }

    public function getLanguageName(): string { return $this->languageName; }
    public function setLanguageName(string $name): void { $this->languageName = $name; }

    public function isIsActive(): bool { return $this->isActive; }
    public function setIsActive(bool $active): void { $this->isActive = $active; }

    public function isIsDeleted(): bool { return $this->isDeleted; }
    public function setIsDeleted(bool $isDeleted): void { $this->isDeleted = $isDeleted; }
}
