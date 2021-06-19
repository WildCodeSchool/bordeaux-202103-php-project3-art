<?php

namespace App\Service;

use App\Entity\GlobalSearch;
use App\Repository\CityRepository;
use App\Repository\HappeningRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;

class GlobalSearchProvider
{
    private UserRepository $userRepository;
    private HappeningRepository $happeningRepository;
    private CityRepository $cityRepository;
    public function __construct(
        UserRepository $userRepository,
        HappeningRepository $happeningRepository,
        CityRepository $cityRepository
    ) {
        $this->userRepository = $userRepository;
        $this->happeningRepository = $happeningRepository;
        $this->cityRepository = $cityRepository;
    }

    public function initSearch(GlobalSearch $globalSearch): void
    {
        $allResults = [];
        $users = $this->userRepository->findBy([],['createdAt' => 'DESC']);
        $happenings = $this->happeningRepository->findBy([],['createdAt' => 'DESC']);
        $allResults['users'] = $users;
        $allResults['happenings'] = $happenings;
        $globalSearch->setResults($allResults);
    }

    public function createSearch(GlobalSearch $globalSearch): void
    {
        $type = $globalSearch->getType();
        $keywords = $globalSearch->getKeywords();
        $results = [];
        switch ($type) {
            case 'artist':
                $results['users'] = $this->userRepository->findByFirstnameAndLastname($keywords);
                break;
            case 'category':
                $results['users'] = $this->userRepository->findByExpertise($keywords);
                break;
            case 'event':
                $results['happenings'] = $this->happeningRepository->findByName($keywords);
                break;
            case 'location':
                $results['users'] = $this->userRepository->findByCitiesNameAndZipcode($keywords);
                break;
        }
        $globalSearch->setResults($results);
    }
}