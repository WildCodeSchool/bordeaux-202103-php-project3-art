<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class GlobalSearch
{
    public const TYPES = ['category', 'artist', 'event', 'location', 'announcement'];

    private ?string $textTyped;

    /**
     * @Assert\Choice(choices=GlobalSearch::TYPES, message="Choisissez un filtre valide.")
     */
    private string $type = 'artist';
    private array $keywords;
    private array $results;

    /**
     * @return ?string
     */
    public function getTextTyped(): ?string
    {
        return $this->textTyped;
    }

    /**
     * @param ?string $textTyped
     */
    public function setTextTyped(?string $textTyped): void
    {
        $this->textTyped = $textTyped;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return array
     */
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
     * @param array $keywords
     */
    public function setKeywords(array $keywords): void
    {
        $this->keywords = $keywords;
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
