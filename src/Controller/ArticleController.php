<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    public const MAX_ARTICLES_DISPLAY = 3;

    /**
     * @Route("/article/{id}", name="article")
     */
    public function index(Article $article, ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findBy(
            [],
            ['id' => 'DESC'],
            self::MAX_ARTICLES_DISPLAY,
        );

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
            'article' => $article,
        ]);
    }
}
