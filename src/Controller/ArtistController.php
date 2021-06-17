<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Message;
use App\Entity\User;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\CityBuilder;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route ("/artist", name="artist_")
 */
class ArtistController extends AbstractController
{
    private $cityBuilder;

    public function __construct(CityBuilder $cityBuilder)
    {
        $this->cityBuilder = $cityBuilder;
    }

    /**
     * @Route("/show/{id}", name="show")
     */
    public function show(User $user): Response
    {
        return $this->render('artist/show.html.twig', [
            'artist' => $user,
        ]);
    }

    /**
     * @Route("/edit/{user_id}", name="edit")
     * @ParamConverter("user", class="App\Entity\User", options={"mapping": {"user_id" : "id"}})
     */
    public function edit(User $user, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $zipCode = $form->getData()->getCity()->getZipCode();
            $this->cityBuilder->buildCityForUser($this->getUser(), $zipCode);
            $manager-> flush();
            return $this->redirectToRoute('artist_profil');

        };
        return $this->render('artist/edit.html.twig', [
            'form' => $form->createView(),
            'artist' => $user,
        ]);
    }

    /**
     * @Route("/profil", name="profil",methods={"GET"})
     */
    public function profile(MessageRepository $messageRepository): Response
    {   
        $userId = $this->getUser()->getId();
        return $this->render('artist/profil.html.twig', [
            'messages' => $messageRepository->findBy(["user" => $userId]),
        ]);
    }

    /**
     * @Route("/contact/{user_id}", name="contact")
     * @ParamConverter("user", class="App\Entity\User", options={"mapping": {"user_id" : "id"}})
     */
    public function contactArtist(User $user, Request $request, EntityManagerInterface $entityManager): Response
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $message->setIsRead(false);
            $message->setUser($user);
            $entityManager->persist($message);
            $entityManager->flush();
            $this->addFlash('success', 'Message envoyé !');
            return $this->redirectToRoute('home_page');
        }
        return $this->render('artist/artist_contact.html.twig', [
            'form' => $form->createView(),
            'artist' => $user,
        ]);
    }

    /**
     * @Route("/show_all", name="show_all")
     */
    public function showAll(UserRepository $repository)
    {
        $artists = $repository->findAll();
        foreach ($artists as $artist) {
            $dicipline = $artist->getDisciplines()->get(0);

        }
        return $this->render('artist/artist_show_all.html.twig', [
            'artists' => $artists,
        ]);
    }


    /**
     * @Route("/{friend_id}/add_friends", name="add_friends", methods={"GET", "POST"})
     * @ParamConverter("friend", class="App\Entity\User", options={"mapping": {"friend_id" : "id"}})
     */
    public function addToFriends(User $friend, EntityManagerInterface $entityManager): Response
    {
        $connectedUser = $this->getUser();
        if ($connectedUser->getFriends()->contains($friend)) {
            $connectedUser->removeFriend($friend);
        } else {
            $connectedUser->addFriend($friend);
        }

        $entityManager->flush();

        return $this->json([
            'isFriend' => $connectedUser->isFriend($friend),

        ]);
    }
}
