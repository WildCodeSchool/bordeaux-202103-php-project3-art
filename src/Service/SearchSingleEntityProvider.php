<?php

namespace App\Service;

use App\Entity\SearchSingleEntity;
use App\Repository\AnnouncementRepository;
use App\Repository\ArticleRepository;
use App\Repository\HappeningRepository;
use App\Repository\UserRepository;

class SearchSingleEntityProvider
{
    private UserRepository $userRepository;
    private HappeningRepository $happeningRepository;
    private AnnouncementRepository $announcementRepository;
    private ArticleRepository $articleRepository;

    public function __construct(
        UserRepository $userRepository,
        HappeningRepository $happeningRepository,
        AnnouncementRepository $announcementRepository,
        ArticleRepository $articleRepository
    ) {
        $this->userRepository = $userRepository;
        $this->happeningRepository = $happeningRepository;
        $this->announcementRepository = $announcementRepository;
        $this->articleRepository = $articleRepository;
    }

    public function createSearchForUsers(SearchSingleEntity $searchSingleEntity): void
    {
        $keywords = $searchSingleEntity->getKeywords();
        $results = $this->userRepository->findByFirstnameAndLastname($keywords);
        $searchSingleEntity->setResults($results);
    }

    public function createSearchForHappenings(SearchSingleEntity $searchSingleEntity): void
    {
        $keywords = $searchSingleEntity->getKeywords();
        $results = $this->happeningRepository->findByName($keywords);
        $searchSingleEntity->setResults($results);
    }

    public function createSearchForAnnouncements(SearchSingleEntity $searchSingleEntity): void
    {
        $keywords = $searchSingleEntity->getKeywords();
        $results = $this->announcementRepository->findByTitleOrDiscipline($keywords);
        $searchSingleEntity->setResults($results);
    }

    public function createSearchForArticles(SearchSingleEntity $searchSingleEntity): void
    {
        $keywords = $searchSingleEntity->getKeywords();
        $results = $this->articleRepository->findByTitle($keywords);
        $searchSingleEntity->setResults($results);
    }
}
