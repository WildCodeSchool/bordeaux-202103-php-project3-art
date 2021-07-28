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
        SearchSingleEntityProvider $searchProvider
    ): Response
    {
        $happenings = $happeningRepository->findBy([], ['createdAt' => 'ASC']);

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
        SearchSingleEntityProvider $searchProvider
    ): Response
    {
        $announcements = $announcementRepository->findBy([], ['createdAt' => 'DESC']);

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
    ): Response
    {
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
        SearchSingleEntityProvider $searchProvider
    ): Response
    {
        $users = $userRepository->findByRoleUser('DESC');

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
    ): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            if ($user->isActive()) {
                $user->setIsActive(false);
                if ($user->getPodium() != null) {
                    $user->setPodium(null);
                }
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
        SearchSingleEntityProvider $searchProvider
    ): Response
    {
        $articles = $articleRepository->findBy([], ['createdAt' => 'DESC']);

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
        ExternalArticleRepository $externalRepository
    ): Response
    {
        $externals = $externalRepository->findBy([], ['id' => 'DESC']);

        return $this->render('admin/external/show_external.html.twig', [
            'externals' => $externals,
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
    ): Response
    {
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
     * @Route("/setPodium/{position}/{id}", name="set_podium", methods={"POST"}, requirements={"position"="\d+"})
     */
    public function setPodium(
        int $position,
        User $user,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response {
        if ($this->isCsrfTokenValid('add_podium' . $user->getId(), $request->request->get('_token'))) {
            $podiumOwner = $userRepository->findOneBy(['podium' => $position]);
            $statusPodium = ($podiumOwner != null);
            if ($statusPodium) {
                if ($podiumOwner->getPodium()) {
                    $podiumOwner->setPodium(null);
                }
            }
            $user->setPodium($position);
            $entityManager->flush();
        }
        return $this->redirectToRoute('admin_show_podium');
    }

    /**
     * @Route("/deletePodium{position}", name="delete_podium", methods={"POST"}, requirements={"position"="\d+"})
     */
    public function deletePodium(
        int $position,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response {
        if ($this->isCsrfTokenValid('delete_podium' . $position, $request->request->get('_token'))) {
            $userWithPosition = $userRepository->findOneBy(['podium' => $position]);
            $userWithPosition->setPodium(null);
            $entityManager->flush();
        }
        return $this->redirectToRoute('admin_show_podium');
    }

    /**
     * @Route("/makeAdmin{id}", name="makeAdmin", methods={"POST"})
     */
    public function makeAdmin(
        Request $request,
        User $user,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('makeAdmin' . $user->getId(), $request->request->get('_token'))) {
            $role = $user->getRoles();
            if (in_array('ROLE_ADMIN', $role)) {
                $user->setRoles(['ROLE_USER']);
            } else {
                $user->setRoles(['ROLE_ADMIN']);
            }
            $entityManager->flush();
        }
        return $this->redirectToRoute('admin_show_artists');
    }

    /**
     * @Route("/showAdmin", name="show_admin")
     * @IsGranted("ROLE_SUPER_ADMIN")
     */
    public function showAdmin(
        UserRepository $userRepository,
        Request $request
    ): Response
    {
        $users = $userRepository->findByAdmin();

        return $this->render('admin/user/admin_show.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/articlePodium/show", name="podium_article")
     */
    public function articlePodiumShow(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findWithPosition();
        return $this->render('admin/podium_about_them/show.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/articlePodium/edit/{position}", name="edit_podium_article",  requirements={"position"="\d+"})
     */
    public function changePodiumArticle(
        int $position,
        ArticleRepository $articleRepository,
        Request $request,
        SearchSingleEntityProvider $searchProvider
    ): Response {
        $articles = $articleRepository->findAll();
        $searchEntity = new SearchSingleEntity();
        $searchBarForm = $this->createForm(EntitySearchType::class, $searchEntity);
        $searchBarForm->handleRequest($request);
        if ($searchBarForm->isSubmitted() && $searchBarForm->isValid()) {
            $searchProvider->createSearchForArticles($searchEntity);
            $articles = $searchEntity->getResults();
        }
        return $this->render('admin/podium_about_them/edit.html.twig', [
            'articles' => $articles,
            'searchBarForm' => $searchBarForm->createView(),
            'position' => $position,
        ]);
    }

    /**
     * @Route("/articlePodium/{position}/{id}", name="set_article_podium", methods={"POST"}, requirements={"position"="\d+"})
     */
    public function setPodiumArticle(
        int $position,
        Article $article,
        ArticleRepository $articleRepository,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response {
        if ($this->isCsrfTokenValid('add_podium_article' . $article->getId(), $request->request->get('_token'))) {
            $podiumOwner = $articleRepository->findOneBy(['podium' => $position]);
            $statusPodium = ($podiumOwner != null);
            if ($statusPodium) {
                if ($podiumOwner->getPodium()) {
                    $podiumOwner->setPodium(null);
                }
            }
            $article->setPodium($position);
            $entityManager->flush();
        }
        return $this->redirectToRoute('admin_podium_article');
    }

    /**
     * @Route("/deletePodiumArticle{position}", name="delete_article_podium", methods={"POST"},
     *      requirements={"position"="\d+"})
     */
    public function deletePodiumArticle(
        int $position,
        ArticleRepository $articleRepository,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response {
        if ($this->isCsrfTokenValid('delete_article_podium' . $position, $request->request->get('_token'))) {
            $articleWithPosition = $articleRepository->findOneBy(['podium' => $position]);
            $articleWithPosition->setPodium(null);
            $entityManager->flush();
        }
        return $this->redirectToRoute('admin_podium_article');
    }
}
