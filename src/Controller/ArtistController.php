<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/artist", name="artist_")
 */
class ArtistController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('artist/index.html.twig', [
            'controller_name' => 'ArtistController',
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function show(User $user): Response
    {
        return $this->render('artist/edit.html.twig', [
            'artist' => $user,
        ]);
    }

     /**
     * @Route("/update/{id}", name="update")
     */
    public function update(User $user): Response
    {
        return $this->render('artist/update_artist_page.html.twig', [
            'artist' => $user,
        ]);
    }
}
