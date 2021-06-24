<?php

namespace App\Controller;

use App\Entity\Announcement;
use App\Entity\Message;
use App\Entity\Response as EntityResponse;
use App\Form\AnnouncementType;
use App\Form\MessageType;
use App\Repository\AnnouncementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/announcement", name="announcement_")
 */
class AnnouncementController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(AnnouncementRepository $announcementRepository): Response
    {
        return $this->render('announcement/index.html.twig', [
            'announcements' => $announcementRepository->getAnnouncementsByDate()
            ]);
    }




    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Announcement $announcement): Response
    {
        $form = $this->createForm(AnnouncementType::class, $announcement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('artist_profil', ['_fragment' => 'myAnnouncements']);

        }

        return $this->render('announcement/edit.html.twig', [
            'announcement' => $announcement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"GET","POST"})
     */
    public function delete(
        Request $request,
        Announcement $announcement,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $announcement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($announcement);
            $entityManager->flush();
        }
        return $this->redirectToRoute('artist_profil', ['_fragment' => 'myAnnouncements']);
    }

    /**
     * @Route("/response/{id}", name="response")
     */
    public function response(
        Request $request,
        EntityManagerInterface $entityManager,
        Announcement $announcement
    ): Response {
        $message = new Message();
        $poster = $announcement->getUser();
        $respondant = $this->getUser();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($respondant) {
                $response = new EntityResponse();
                $response->setRespondant($respondant);
                $response->setAnnouncement($announcement);
                $entityManager->persist($response);
            }
            $message->setIsRead(false);
            $message->setUser($poster);
            $entityManager->persist($message);
            $entityManager->flush();
            return $this->redirectToRoute('announcement_index');
        }
        return $this->render('announcement/response.html.twig', [
            'form' => $form->createView(),
            'announcement' => $announcement,
        ]);
    }
}
