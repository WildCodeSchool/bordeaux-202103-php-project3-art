<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\HappeningRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

    /**
     * @Route("/", name="home_")
     */
class HomeController extends AbstractController
{
    public const MAX_ARTICLES_CAROUSEL = 3;

    /**
     * @Route("/", name="page")
     */
    public function index(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository, HappeningRepository $happeningRepository): Response
    {

        $users = $userRepository->findAll();
        $happenings = $happeningRepository->findBy(
            [],
            ['id' => 'DESC'],
            self::MAX_ARTICLES_CAROUSEL,
        );

        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            // TODO remplacer l'adresse par un mail admin généré par fixtures
            $adminContact = $userRepository->findOneBy(['email' => 'artiste1@gmail.com']);
            $message->setUser($adminContact);
            $message->onPrePersist();
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
