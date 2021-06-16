<?php

namespace App\Service;

use App\Entity\GlobalSearch;
use App\Repository\HappeningRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;

class GlobalSearchProvider
{
    private UserRepository $userRepository;
    private HappeningRepository $happeningRepository;
    // TODO implements City
    public function __construct(UserRepository $userRepository, HappeningRepository $happeningRepository)
    {
        $this->userRepository = $userRepository;
        $this->happeningRepository = $happeningRepository;
    }

    public function initSearch(): array
    {
        $allResults = [];
        $users = $this->userRepository->findAll();
        $happenings = $this->happeningRepository->findAll();
        $allResults[] = $users;
        $allResults[] = $happenings;
        return $allResults;
    }

    public function createSearch(GlobalSearch $globalSearch)
    {
        $type = $globalSearch->getType();
        $keywords = $globalSearch->getKeywords();
        switch ($type) {
            case 'artist':
                $results = $this->userRepository->findBy(['lastname' => $globalSearch->getTextTyped()]);
                break;
            case 'category':
                $results = $this->userRepository->findBy(['expertise' => $globalSearch->getTextTyped()]);
                break;
            case 'event':
                $results = $this->happeningRepository->findBy(['title' => $globalSearch->getTextTyped()]);
                break;
            case 'location':
               //TODO IMPLEMENT CITIEs
                break;
            default:
                $results = $this->userRepository->findBy(['lastname' => $globalSearch->getTextTyped()]);
        }
        $globalSearch->setKeywords($keywords);
    }
}
