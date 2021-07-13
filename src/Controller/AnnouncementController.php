<?php

namespace App\Controller;

use App\Entity\Announcement;
use App\Entity\Message;
use App\Entity\Response as EntityResponse;
use App\Entity\SearchSingleEntity;
use App\Form\AnnouncementType;
use App\Form\MessageType;
use App\Form\EntitySearchType;
use App\Repository\AnnouncementRepository;
use App\Service\SearchSingleEntityProvider;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/announcement", name="announcement_")
 */
class AnnouncementController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET","POST"})
     */
    public function index(
        Request $request,
        AnnouncementRepository $announcementRepository,
        SearchSingleEntityProvider $searchProvider
    ): Response {
        $searchEntity = new SearchSingleEntity();
        $form = $this->createForm(EntitySearchType::class, $searchEntity);
        $form->handleRequest($request);

        $announcements = $announcementRepository->getAnnouncementsByDate();
        if ($form->isSubmitted() && $form->isValid()) {
            $searchProvider->createSearchForAnnouncements($searchEntity);
            $announcements = $searchEntity->getResults();
        }
        return $this->render('announcement/index.html.twig', [
            'announcements' => $announcements,
            'form' =>$form->createView()
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
            $entityManager->remove($announcement);
            $entityManager->flush();
        }
        return $this->redirectToRoute('artist_profil', ['_fragment' => 'myAnnouncements']);
    }

    /**
     * @Route("/response/{id}", name="response")
     * @IsGranted("ROLE_USER")
     */
    public function response(
        Request $request,
        EntityManagerInterface $entityManager,
        Announcement $announcement
    ): Response {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $poster = $announcement->getUser();
            $respondant = $this->getUser();
            $response = new EntityResponse();
            $response->setRespondant($respondant);
            $response->setAnnouncement($announcement);
            $entityManager->persist($response);
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
