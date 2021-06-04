<?php

namespace App\Controller;

use App\Entity\Happening;
use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\HappeningRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

    /**
     * @Route("/", name="home_")
     */
class HomeController extends AbstractController
{

    /**
     * @Route("/", name="page")
     */
    public function index(Request $request, UserRepository $userRepository, HappeningRepository $happeningRepository): Response
    {
        $users = $userRepository->findAll();
        $happenings = $happeningRepository->findAll();

        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $message->setSendAt(new \DateTime());
            $message->setIsRead(false);
            $entityManager->persist($message);
            $entityManager->flush();

            $this->addFlash('success', 'Message envoyé !');

            return $this->redirectToRoute('home_page');
        }
        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
            'artists' => $users,
            'happenings' => $happenings
        ]);
    }
}
