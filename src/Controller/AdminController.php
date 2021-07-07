<?php

namespace App\Controller;

use App\Entity\Announcement;
use App\Form\AnnouncementType;
use App\Repository\AnnouncementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/admin", name="admin_")
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboard(): Response
    {
        return $this->render('admin/dashboard.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/showAnnouncements", name="show_announcements")
     */
    public function showAnnouncements(AnnouncementRepository $announcementRepository): Response
    {
        $announcements =  $announcementRepository->findAll();
        return $this->render('admin/show_announcements.html.twig', [
            'announcements' => $announcements,
        ]);
    }

    /**
     * @Route("/announcement/{id}", name="delete_announcement", methods={"GET","POST"})
     */
    public function deleteAnnouncement(
        Request $request,
        Announcement $announcement,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $announcement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($announcement);
            $entityManager->flush();
        }
        return $this->redirectToRoute('admin_show_announcements');
    }

    /**
     * @Route("/announcement/edit/{id}", name="edit_announcement", methods={"GET","POST"})
     */
    public function edit(Request $request, Announcement $announcement): Response
    {
        $form = $this->createForm(AnnouncementType::class, $announcement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_show_announcements');
        }
        return $this->render('admin/edit_announcement.html.twig', [
            'announcement' => $announcement,
            'form' => $form->createView(),
        ]);
    }
}
