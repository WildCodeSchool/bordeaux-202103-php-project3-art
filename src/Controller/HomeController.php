<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\GlobalSearchType;
use App\Form\MessageType;
use App\Entity\GlobalSearch;
use App\Repository\ArticleRepository;
use App\Repository\ExternalArticleRepository;
use App\Repository\HappeningRepository;
use App\Repository\PresentationRepository;
use App\Repository\UserRepository;
use App\Service\GlobalSearchProvider;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

    /**
     * @Route("/", name="home_")
     */
class HomeController extends AbstractController
{
    public const MAX_ARTICLES_CAROUSEL = 3;

    /**
     * @Route("/", name="page")
     */
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        UserRepository $userRepository,
        HappeningRepository $happeningRepository,
        ExternalArticleRepository $externalArticleRepository,
        PresentationRepository $presentationRepository,
        ArticleRepository $articleRepository
    ): Response {
        $users = $userRepository->findWithPosition();
        if (empty($users)) {
           $users = $userRepository->findAll('DESC', 6);
        }
        $happenings = $happeningRepository->findBy(
            [],
            ['id' => 'DESC'],
            self::MAX_ARTICLES_CAROUSEL,
        );
        $externals = $externalArticleRepository->findBy(
            [],
            ['id' => 'DESC'],
            self::MAX_ARTICLES_CAROUSEL,
        );
        $articlesAboutThem = $articleRepository->findWithPosition();

        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $adminContact = $userRepository->findOneBy(['email' => Message::ADMIN_MAIL]);
            $message->setUser($adminContact);
            $message->onPrePersist();
            $message->setIsRead(false);
            $entityManager->persist($message);
            $entityManager->flush();

            $this->addFlash('success', 'Message envoyé !');

            return $this->redirectToRoute('home_page');
        }
        $presentation = $presentationRepository->findAll()[0];
        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
            'artists' => $users,
            'happenings' => $happenings,
            'externals' => $externals,
            'articles' => $articlesAboutThem,
            'presentation' => $presentation
        ]);
    }

    /**
     * @Route("/recherche", name="search")
     */
    public function search(Request $request, GlobalSearchProvider $globalSearchProvider): Response
    {
        $globalSearch = new GlobalSearch();
        $form = $this->createForm(GlobalSearchType::class, $globalSearch);
        $form->handleRequest($request);
        $globalSearchProvider->initSearch($globalSearch);
        if ($form->isSubmitted() && $form->isValid()) {
            $globalSearchProvider->createSearch($globalSearch);
        }
        $results = $globalSearch->getResults();
        return $this->render('home/searchBar.html.twig', [
            'form' => $form->createView(),
            'results' => $results,
        ]);
    }
}
