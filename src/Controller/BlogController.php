<?php

namespace App\Controller;

use App\Entity\Happening;
use App\Repository\ArticleRepository;
use App\Repository\HappeningRepository;
use App\Service\Fusion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/blog", name="blog_")
 */
class BlogController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(HappeningRepository $happeningRepository,ArticleRepository $articleRepository, Request $request, PaginatorInterface $paginator, Fusion $fusion): Response
    {
        $happeningsData = $happeningRepository->findBy(
            [],
            ['createdAt' => 'desc']
        );
        $articleData =$articleRepository->findBY(
            [],
            ['createdAt' => 'desc']
        );
        $orderedMixedTable = $fusion->goTenks($happeningsData, $articleData);

        $happenings = $paginator->paginate(
            $orderedMixedTable,
            $request->query->getInt('page', 1),
            3
        );


        return $this->render('blog/index.html.twig', [
            'happenings' => $happenings,
        ]);
    }

    /**
     * @Route("/article/{id}", name="article")
     */
    public function showArticle(Happening $happening): Response
    {
        return $this->render('blog/article.html.twig', [
            'happening' => $happening
        ]);
    }
}
