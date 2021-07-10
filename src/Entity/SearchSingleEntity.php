<?php

namespace App\Entity;

class SearchSingleEntity
{
    private ?string $textTyped;
    private array $results;

    public function getKeywords(): array
    {
        if (!empty($this->textTyped)) {
            $words = trim($this->textTyped);
            $keywords = explode(' ', $words);
        } else {
            $keywords = [];
        }
        return  $keywords;
    }

    /**
     * @return string|null
     */
    public function getTextTyped(): ?string
    {
        return $this->textTyped;
    }

    /**
     * @param string|null $textTyped
     */
    public function setTextTyped(?string $textTyped): void
    {
        $this->textTyped = $textTyped;
    }

    /**
     * @return array
     */
    public function getResults(): array
    {
        return $this->results;
    }

    /**
     * @param array $results
     */
    public function setResults(array $results): void
    {
        $this->results = $results;
    }


}