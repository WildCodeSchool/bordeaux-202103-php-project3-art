<?php

namespace App\Controller;

use App\Entity\Avatar;
use App\Form\AvatarType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AvatarController extends AbstractController
{
    /**
     * @Route("/avatar", name="avatar")
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $avatar = new Avatar();
        $form = $this->createForm(AvatarType::class, $avatar);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $avatar->setUser($user);
            $avatar->setUrl("url ok");
            $entityManager->persist($avatar);
            $entityManager->flush();
            return $this->redirect('home_page');

        }

        return $this->render('avatar/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
