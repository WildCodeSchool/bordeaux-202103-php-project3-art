<?php

namespace App\Controller;

use App\Entity\article;
use App\Entity\ExternalArticle;
use App\Entity\SearchSingleEntity;
use App\Form\ArticleType;
use App\Form\EntitySearchType;
use App\Form\ExternalType;
use App\Form\HappeningType;
use App\Entity\Happening;
use App\Repository\ArticleRepository;
use App\Repository\ExternalArticleRepository;
use App\Repository\HappeningRepository;
use App\Entity\Announcement;
use App\Entity\User;
use App\Form\AnnouncementType;
use App\Repository\AnnouncementRepository;
use App\Repository\UserRepository;
use App\Service\SearchSingleEntityProvider;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
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
    public function happeningShow(
        HappeningRepository $happeningRepository,
        Request $request,
        SearchSingleEntityProvider $searchProvider,
        PaginatorInterface $paginator
    ): Response {
        $happeningsData = $happeningRepository->findBy([], ['createdAt' => 'ASC']);
        $happenings = $paginator->paginate(
            $happeningsData,
            $request->query->getInt('page', 1),
            10
        );
        $searchEntity = new SearchSingleEntity();
        $form = $this->createForm(EntitySearchType::class, $searchEntity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $searchProvider->createSearchForHappenings($searchEntity);
            $happenings = $searchEntity->getResults();
        }
        return $this->render('admin/happening/show_happening.html.twig', [
            'happenings' => $happenings,
            'form' => $form->createView(),
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
    public function showAnnouncements(
        AnnouncementRepository $announcementRepository,
        Request $request,
        SearchSingleEntityProvider $searchProvider,
        PaginatorInterface $paginator
    ): Response {
        $announcementsData =  $announcementRepository->findBy([], ['createdAt' => 'DESC']);
        $announcements = $paginator->paginate(
            $announcementsData,
            $request->query->getInt('page', 1),
            10
        );
        $searchEntity = new SearchSingleEntity();
        $form = $this->createForm(EntitySearchType::class, $searchEntity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $searchProvider->createSearchForAnnouncements($searchEntity);
            $announcements = $searchEntity->getResults();
        }
        return $this->render('admin/announcement/show_announcements.html.twig', [
            'announcements' => $announcements,
            'form' => $form->createView(),
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
    public function showUsers(
        UserRepository $userRepository,
        Request $request,
        SearchSingleEntityProvider $searchProvider,
        PaginatorInterface $paginator
    ): Response {
        $usersData =  $userRepository->findByRoleUser('DESC');
        $users = $paginator->paginate(
            $usersData,
            $request->query->getInt('page', 1),
            10
        );
        $searchEntity = new SearchSingleEntity();
        $form = $this->createForm(EntitySearchType::class, $searchEntity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $searchProvider->createSearchForUsers($searchEntity);
            $users = $searchEntity->getResults();
        }
        return $this->render('admin/user/show_artists.html.twig', [
            'users' => $users,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("user/delete/{id}", name="delete_user",  methods={"GET","POST"})
     */
    public function changeIsActiveArtist(
        Request $request,
        User $user,
        EntityManagerInterface $entityManager
    ): Response {
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
    public function articleShow(
        ArticleRepository $articleRepository,
        Request $request,
        SearchSingleEntityProvider $searchProvider,
        PaginatorInterface $paginator
    ): Response {
        $articlesData = $articleRepository->findBy([], ['createdAt' => 'DESC']);
        $articles = $paginator->paginate(
            $articlesData,
            $request->query->getInt('page', 1),
            10
        );
        $searchEntity = new SearchSingleEntity();
        $form = $this->createForm(EntitySearchType::class, $searchEntity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $searchProvider->createSearchForArticles($searchEntity);
            $articles = $searchEntity->getResults();
        }
        return $this->render('admin/article/show_article.html.twig', [
            'articles' => $articles,
            'form' => $form->createView()
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

    /**
     * @Route("/external/show", name="external_show")
     */
    public function externalShow(
        ExternalArticleRepository $externalRepository,
        Request $request,
        SearchSingleEntityProvider $searchProvider
    ): Response {
        $externals = $externalRepository->findBy([], ['id' => 'DESC']);
        $searchEntity = new SearchSingleEntity();
        $form = $this->createForm(EntitySearchType::class, $searchEntity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $externals = $searchEntity->getResults();
        }
        return $this->render('admin/external/show_external.html.twig', [
            'externals' => $externals,
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/external/new", name="external_new")
     */
    public function externalNew(Request $request, EntityManagerInterface $entityManager): Response
    {
        $external = new ExternalArticle();
        $form = $this->createForm(ExternalType::class, $external);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($external);
            $entityManager->flush();
            return $this->redirectToRoute('admin_external_show');
        }
        return $this->render('admin/external/new_external.html.twig', [
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/external/edit/{id}", name="external_edit")
     */
    public function externalEdit(Request $request, EntityManagerInterface $entityManager, ExternalArticle $external): Response
    {
        $form = $this->createForm(ExternalType::class, $external);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('admin_external_show');
        }
        return $this->render('admin/external/edit_external.html.twig', [
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/external/delete/{id}", name="external_delete", methods={"POST"})
     */
    public function externalDelete(
        ExternalArticle $external,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $external->getId(), $request->request->get('_token'))) {
            $entityManager->remove($external);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_external_show');
    }

    /**
     * @Route("/podium/show", name="show_podium")
     */
    public function podiumShow(UserRepository $userRepository): Response
    {
        $users = $userRepository->findWithPosition();
        return $this->render('admin/podium_artist/show.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/podium/edit/{position}", name="edit_podium", requirements={"position"="\d+"})
     */
    public function changePodium(
        int $position,
        UserRepository $userRepository,
        Request $request,
        SearchSingleEntityProvider $SearchProvider
    ): Response {
        $users = $userRepository->findAll();
        $searchEntity = new SearchSingleEntity();
        $searchBarForm = $this->createForm(EntitySearchType::class, $searchEntity);
        $searchBarForm->handleRequest($request);
        if ($searchBarForm->isSubmitted() && $searchBarForm->isValid()) {
            $SearchProvider->createSearchForUsers($searchEntity);
            $users = $searchEntity->getResults();
        }
        return $this->render('admin/podium_artist/edit.html.twig', [
            'users' => $users,
            'searchBarForm' => $searchBarForm->createView(),
            'position' => $position,
        ]);
    }

    /**
     * @Route("/setPodium/{position}/{id}", name="set_podium", requirements={"position"="\d+"})
     */
    public function setPodium(
        int $position,
        User $user,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $podiumOwner = $userRepository->findOneBy(['podium' => $position]);
        $statusPodium = ($podiumOwner != null);
        if ($statusPodium) {
            if ($podiumOwner->getPodium()) {
                $podiumOwner->setPodium(null);
            }
        }
        $user->setPodium($position);
        $entityManager->flush();
        return $this->redirectToRoute('admin_show_podium');
    }

    /**
     * @Route("/deletePodium{position}", name="delete_podium", requirements={"position"="\d+"})
     */
    public function deletePodium(
        int $position,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $userWithPosition = $userRepository->findOneBy(['podium' => $position ]);
        $userWithPosition->setPodium(null);
        $entityManager->flush();
        return $this->redirectToRoute('admin_show_podium');
    }
}

