<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RedirectionController extends AbstractController
{
    /**
     * @Route("/redirection", name="redirection")
     */
    public function index(): Response
    {

        $user = $this->getUser();
        $route = $this->redirectToRoute('artist_edit', ['user_id'=> $this->getUser()->getId()]);
        if($user->getAvatar()->getImage() || in_array("ROLE_SUPER_ADMIN",$this->getUser()->getRoles()) || in_array("ROLE_ADMIN",$this->getUser()->getRoles())){
            $route = $this->redirectToRoute('home_page');
        }
      return $route;
    }
}
