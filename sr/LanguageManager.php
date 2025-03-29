<?php
/**
 * 
 * Copyright &copy; 20250 WebjetClouds-agency
 * wp-webjetclouds-php translattion
 * 
 * **/
namespace App;

class LanguageManager
{
    private $language;
    private $translations;

    public function __construct(string $language = 'en')
    {
        $this->language = $language;
        $this->loadTranslations();
    }

    private function loadTranslations(): void
    {
        $filePath = __DIR__ . '/../lang/' . $this->language . '.json';

        if (!file_exists($filePath)) {
            throw new \Exception("Translation file not found for language: {$this->language}");
        }

        $jsonContent = file_get_contents($filePath);
        $this->translations = json_decode($jsonContent, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Error parsing translation file for language: {$this->language}");
        }
    }

    public function getTranslation(string $key): string
    {
        $keys = explode('.', $key);
        $value = $this->translations;

        foreach ($keys as $keyPart) {
            if (isset($value[$keyPart])) {
                $value = $value[$keyPart];
            } else {
                return $key; // Return the original key if not found
            }
        }

        return $value;
    }

    public function setLanguage(string $language): void
    {
        $this->language = $language;
        $this->loadTranslations();
    }
}
