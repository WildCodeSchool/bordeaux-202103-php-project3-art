<?php

namespace App\Controller;

use App\Entity\Happening;
use App\Repository\HappeningRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/blog", name="blog_")
 */
class BlogController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(HappeningRepository $happeningRepository): Response
    {
        $happenings = $happeningRepository->findAll();

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
