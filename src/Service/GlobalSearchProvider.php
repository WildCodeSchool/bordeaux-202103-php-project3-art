<?php

namespace App\Service;

use App\Entity\GlobalSearch;
use App\Repository\AnnouncementRepository;
use App\Repository\HappeningRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;

class GlobalSearchProvider
{
    private UserRepository $userRepository;
    private HappeningRepository $happeningRepository;
    private AnnouncementRepository $announcementRepository;
    public function __construct(
        UserRepository $userRepository,
        HappeningRepository $happeningRepository,
        AnnouncementRepository $announcementRepository
    ) {
        $this->userRepository = $userRepository;
        $this->happeningRepository = $happeningRepository;
        $this->announcementRepository = $announcementRepository;
    }

    public function initSearch(GlobalSearch $globalSearch): void
    {
        $allResults = [];
        $users = $this->userRepository->findAll('DESC');
        $happenings = $this->happeningRepository->findBy([], ['createdAt' => 'DESC']);
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
            case 'announcement':
                $results['announcements'] = $this->announcementRepository->findByTitleOrDiscipline($keywords);
        }
        $globalSearch->setResults($results);
    }
}
