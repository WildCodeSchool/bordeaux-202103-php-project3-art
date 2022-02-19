<?php

namespace App\Controller;

use App\Entity\Presentation;
use App\Form\PresentationType;
use App\Repository\PresentationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

    /**
     * @Route("/admin/presentation", name="admin_presentation_")
     */
class AdminPresentationController extends AbstractController
{
    /**
     * @Route("/", name="detail")
     */
    public function detail(PresentationRepository $presentationRepository): Response
    {
        $presentation = $presentationRepository->findAll()[0];
        return $this->render('admin/presentation/detail.html.twig', [
            'presentation' => $presentation
        ]);
    }
    /**
     * @Route("/modification", name="update")
     */
    public function update(
        PresentationRepository $presentationRepository,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response
    {
        $presentation = $presentationRepository->findAll()[0];
        $form = $this->createForm(PresentationType::class,$presentation);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('admin_presentation_detail');
        }
        return $this->render('admin/presentation/update.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
