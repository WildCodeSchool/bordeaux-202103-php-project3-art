<?php

namespace App\Controller;

use App\Entity\Artwork;
use App\Form\ArtworkType;
use App\Repository\ArtworkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/artwork")
 */
class ArtworkController extends AbstractController
{
    /**
     * @Route("/new", name="artwork_new", methods={"GET","POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $artwork = new Artwork();
        $form = $this->createForm(ArtworkType::class, $artwork);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $artwork->setUser($this->getUser());
            $entityManager->persist($artwork);
            $entityManager->flush();
            return $this->redirectToRoute('artist_profil');
        }
        return $this->render('artwork/new.html.twig', [
            'artwork' => $artwork,
            'formArtwork' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="artwork_delete", methods={"POST"})
     */
    public function delete(Request $request, Artwork $artwork): Response
    {
        if ($this->isCsrfTokenValid('delete' . $artwork->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($artwork);
            $entityManager->flush();
        }
        return $this->redirectToRoute('artist_profil');
    }

    /**
     * @Route("/{id}/edit", name="artwork_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Artwork $artwork): Response
    {
        $formArtwork = $this->createForm(ArtworkType::class, $artwork);
        $formArtwork->handleRequest($request);
        if ($formArtwork->isSubmitted() && $formArtwork->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('artist_profil');
        }
        return $this->render('artwork/edit.html.twig', [
            'artwork' => $artwork,
            'formArtwork' => $formArtwork->createView(),
        ]);
    }


}
