<?php

namespace App\Controller;

use App\Entity\article;
use App\Form\ArticleType;
use App\Form\HappeningType;
use App\Repository\ArticleRepository;
use App\Repository\HappeningRepository;
use App\Entity\Announcement;
use App\Entity\User;
use App\Form\AnnouncementType;
use App\Repository\AnnouncementRepository;
use App\Repository\UserRepository;
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
     * @Route("/happening/show", name="happening_show")
     */
    public function happeningShow(HappeningRepository $happeningRepository): Response
    {
        $happenings = $happeningRepository->findAll();
        return $this->render('admin/happening/show_article.html.twig', [
            'happenings' => $happenings
        ]);
    }
    /**
     * @Route("/happening/new", name="happening_new")
     */
    public function happeningNew(Request $request, EntityManagerInterface $entityManager): Response
    {
        $happening = new Happening();
        $form = $this->createForm(HappeningType::class, $happening);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $happening->setUser($this->getUser());
            $entityManager->persist($happening);
            $entityManager->flush();
            return $this->redirectToRoute('admin_happening_show');
        }
        return $this->render('admin/happening/new_happening.html.twig', [
            'form' => $form->createView(),

        ]);
    }
    /**
     * @Route("/happening/edit/{id}", name="happening_edit")
     */
    public function happeningEdit(Request $request, EntityManagerInterface $entityManager, Happening $happening): Response
    {
        $form = $this->createForm(HappeningType::class, $happening);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $happening->setUser($this->getUser());
            $entityManager->flush();
            return $this->redirectToRoute('admin_happening_show');
        }
        return $this->render('admin/happening/edit_happening.html.twig', [
            'form' => $form->createView(),

        ]);
    }
    /**
     * @Route("/happening/delete/{id}", name="happening_delete", methods={"POST"})
     */
    public function delete(Happening $happening, EntityManagerInterface $entityManager, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete' . $happening->getId(), $request->request->get('_token'))) {
            $entityManager->remove($happening);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_happening_show');
    }

    /**
     * @Route("/showAnnouncements", name="show_announcements")
     */
    public function showAnnouncements(AnnouncementRepository $announcementRepository): Response
    {
        $announcements =  $announcementRepository->findAll();
        return $this->render('admin/announcement/show_announcements.html.twig', [
            'announcements' => $announcements,
        ]);
    }

    /**
     * @Route("/announcement/delete/{id}", name="delete_announcement", methods={"GET","POST"})
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
    public function editAnnouncement(Request $request, Announcement $announcement): Response
    {
        $form = $this->createForm(AnnouncementType::class, $announcement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_show_announcements');
        }
        return $this->render('admin/announcement/edit_announcement.html.twig', [
            'announcement' => $announcement,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/showArtists", name="show_artists")
     */
    public function showUsers(UserRepository $userRepository): Response
    {
        $users =  $userRepository->findByRoleUser($order = 'DESC');
        return $this->render('admin/user/show_artists.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("user/delete/{id}", name="delete_user",  methods={"GET","POST"})
     */
    public function changeIsActiveArtist(
        Request $request,
        User $user,
        EntityManagerInterface $entityManager
    ): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            if ($user->isActive()) {
                $user->setIsActive(false);
            } else {
                $user->setIsActive(true);
            }
            $entityManager->flush();
        }
        return $this->redirectToRoute('admin_show_artists');
    }

    /**
     * @Route("/article/show", name="article_show")
     */
    public function articleShow(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();
        return $this->render('admin/article/show_article.html.twig', [
            'articles' => $articles
        ]);
    }
    /**
     * @Route("/article/new", name="article_new")
     */
    public function articleNew(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = new article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article->setUser($this->getUser());
            $entityManager->persist($article);
            $entityManager->flush();
            return $this->redirectToRoute('admin_article_show');
        }
        return $this->render('admin/article/new_article.html.twig', [
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/article/edit/{id}", name="article_edit")
     */
    public function articleEdit(Request $request, EntityManagerInterface $entityManager, article $article): Response
    {
        $form = $this->createForm(articleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article->setUser($this->getUser());
            $entityManager->flush();
            return $this->redirectToRoute('admin_article_show');
        }
        return $this->render('admin/article/edit_article.html.twig', [
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/article/delete/{id}", name="article_delete", methods={"POST"})
     */
    public function articleDelete(article $article, EntityManagerInterface $entityManager, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_article_show');
    }
}
