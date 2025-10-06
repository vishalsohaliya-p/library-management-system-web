<?php

namespace App\Member\Application\Language\Model;

class LanguageListModel
{
    public function __construct(
        public int $languageId,
        public string $languageName,
        public bool $isActive) {
    }
    
}
