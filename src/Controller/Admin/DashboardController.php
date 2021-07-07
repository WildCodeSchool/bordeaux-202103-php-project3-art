<?php

namespace App\Controller\Admin;

use App\Entity\Happening;
use App\Form\HappeningType;
use App\Repository\ArticleRepository;
use App\Repository\HappeningRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/admin", name="admin_")
 * @IsGranted("ROLE_ADMIN")
 */
class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/", name="dashboard")
     */
    public function index(): Response
    {
        return $this->render('easy_admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Arts d\'Éko Admin dashboard');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
    /**
     * @Route("/article/show", name="article_show")
     */
    public function articleShow(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();
        dd($articles);
    }
    /**
     * @Route("/happening/show", name="happening_show")
     */
    public function happeningShow(HappeningRepository $happeningRepository): Response
    {
        $happenings = $happeningRepository->findAll();
        return $this->render('easy_admin/show_happening.html.twig', [
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
        return $this->render('easy_admin/new_happening.html.twig', [
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
        return $this->render('easy_admin/edit_happening.html.twig', [
            'form' => $form->createView(),

        ]);
    }
    /**
     * @Route("happening/delete/{id}", name="happening_delete", methods={"POST"})
     */
    public function delete(Happening $happening, EntityManagerInterface $entityManager, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete' . $happening->getId(), $request->request->get('_token'))) {
            $entityManager->remove($happening);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_happening_show');

    }
}
