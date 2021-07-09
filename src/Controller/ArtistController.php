<?php

namespace App\Controller;

use App\Entity\Announcement;
use App\Entity\Artwork;
use App\Entity\City;
use App\Entity\Discipline;
use App\Entity\Message;
use App\Entity\User;
use App\Form\AnnouncementType;
use App\Form\ArtworkType;
use App\Form\LocalisationType;
use App\Form\MessageType;
use App\Repository\AnnouncementRepository;
use App\Repository\MessageRepository;
use App\Form\UserType;
use App\Repository\ResponseRepository;
use App\Repository\UserRepository;
use App\Service\CityBuilder;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\User\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Knp\Component\Pager\PaginatorInterface;

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
     * @IsGranted("ROLE_USER")
     */
    public function edit(User $user, Request $request, EntityManagerInterface $manager): Response
    {
        $formLocalisation = $this->createForm(LocalisationType::class);
        $formLocalisation->handleRequest($request);
        if ($formLocalisation->isSubmitted() && $formLocalisation->isValid()) {
            $coordinates = $formLocalisation->getData();
            $this->getUser()->getCity()->setLatitude($coordinates['latitude']);
            $this->getUser()->getCity()->setLongitude($coordinates['longitude']);
            $city = $this->cityBuilder->fetchCityByCoordinates($coordinates['latitude'], $coordinates['longitude']);
            $this->getUser()->getCity()->setZipcode($city['codesPostaux'][0]);
            $this->getUser()->getCity()->setName($city['nom']);
            $manager->flush();
            return $this->redirectToRoute('artist_edit', ['user_id' => $this->getUser()->getId()]);
        }
        $formUpdate = $this->createForm(UserType::class, $user);
        $formUpdate->handleRequest($request);
        if ($formUpdate->isSubmitted() && $formUpdate->isValid()) {
            $zipCode = $formUpdate->getData()->getCity()->getZipCode();
            $city = $this->cityBuilder->fetchCity($zipCode);
            $this->getUser()->getCity()->setName($city['nom']);
            $this->getUser()->getCity()->setLongitude($city['centre']['coordinates'][0]);
            $this->getUser()->getCity()->setLatitude($city['centre']['coordinates'][1]);
            $manager->flush();
            return $this->redirectToRoute('artist_profil');
        };
        return $this->render('artist/edit.html.twig', [
            'formUpdate' => $formUpdate->createView(),
            'artist' => $user,
            'form_localisation' => $formLocalisation->createView(),
        ]);
    }

    /**
     * @Route("/profil", name="profil",methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function profile(
        MessageRepository $messageRepository,
        Request $request,
        EntityManagerInterface $entityManager,
        SessionInterface $session,
        PaginatorInterface $paginator
    ): Response {
        $user = $this->getUser();
        $announcement = new Announcement();
        $newForm = $this->createForm(AnnouncementType::class, $announcement);
        $newForm->handleRequest($request);
        if ($newForm->isSubmitted() && $newForm->isValid()) {
            $announcement->setUser($this->getUser());
            $entityManager->persist($announcement);
            $entityManager->flush();
            return $this->redirectToRoute('artist_profil', [
                '_fragment' => 'myAnnouncements',
            ]);
        }
        $totalUnreadMessage = $messageRepository->countUnreadMessage($user);
        $messagesData = $messageRepository->findBy(['user' => $user]);
        $messages = $paginator->paginate(
            $messagesData,
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('artist/profil.html.twig', [
            'messages' => $messages,
            'totalUnreadMessage' => $totalUnreadMessage,
            'announcementForm' => $newForm->createView(),
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
        $artists = $repository->findByRoleUser($order = 'DESC');
        foreach ($artists as $artist) {
            $artist->getDisciplines()->get(0);
            return $this->render('artist/artist_show_all.html.twig', [
                'artists' => $artists,
            ]);
        }
    }

    /**
     * @Route("/{friend_id}/add_friends", name="add_friends", methods={"GET", "POST"})
     * @ParamConverter("friend", class="App\Entity\User", options={"mapping": {"friend_id" : "id"}})
     * @IsGranted("ROLE_USER")
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

    /**
     * @Route("/profil/isRead/{id}", name="message_is_read", methods={"GET", "POST"})
     * @IsGranted("ROLE_USER")
     */
    public function mailIsRead(
        Message $mail,
        EntityManagerInterface $entityManager
    ): Response {
        $mail->setIsRead(true);
        $entityManager->flush();
        return $this->redirectToRoute('artist_profil', ["_fragment" => "mailbox"]);
    }
    /**
     * @Route("/toggleMailBox", name="toggle", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function toggle(SessionInterface $session)
    {
        $session->set('isMailBoxOpen', !$session->get('isMailBoxOpen'));
        $this->json(['isMailBoxOpen' => $session->get('isMailBoxOpen')]);
    }
}
