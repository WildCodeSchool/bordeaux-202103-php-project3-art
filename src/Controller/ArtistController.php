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
use App\Repository\ArtworkRepository;
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
     * @Route("/edit/{user_id}", name="edit", methods={"POST","GET"})
     * @ParamConverter("user", class="App\Entity\User", options={"mapping": {"user_id" : "id"}})
     * @IsGranted("ROLE_USER")
     */
    public function edit(User $user, Request $request, EntityManagerInterface $manager): Response
    {
        if ($user === $this->getUser()) {
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
        } else {
            return $this->redirectToRoute('artist_profil');
        }
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
        $messagesData = $messageRepository->findBy(
            ['user' => $user],
            ['sendAt' => 'DESC']
        );
        $messages = $paginator->paginate(
            $messagesData,
            $request->query->getInt('page', 1),
            10
        );
        $dateMin = new DateTime();
        return $this->render('artist/profil.html.twig', [
            'messages' => $messages,
            'totalUnreadMessage' => $totalUnreadMessage,
            'announcementForm' => $newForm->createView(),
            'date_min' => $dateMin,
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
            $this->addFlash('success', 'Message envoy?? !');
            return $this->redirectToRoute('home_page');
        }
        return $this->render('artist/artist_contact.html.twig', [
            'form' => $form->createView(),
            'artist' => $user,
        ]);
    }

    /**
     * @Route("/contact/{user_id}/{artwork_id}", name="contact_artwork")
     * @ParamConverter("user", class="App\Entity\User", options={"mapping": {"user_id" : "id"}})
     * @ParamConverter("artwork", class="App\Entity\Artwork", options={"mapping": {"artwork_id" : "id"}})
     */
    public function contactArtistBuy(
        User $user,
        Artwork $artwork,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $message = new Message();
        $artworkName = 'Demande d\'achat de ' . $artwork->getName();
        $isBuying = true;
        $form = $this->createForm(
            MessageType::class,
            $message,
            ['is_buying' => $isBuying, 'artwork_name' => $artworkName]
        );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $message->setIsRead(false);
            $message->setUser($user);
            $entityManager->persist($message);
            $entityManager->flush();
            $this->addFlash('success', 'Message envoy?? !');
            return $this->redirectToRoute('artist_show', ['id' => $artwork->getUser()->getId()]);
        }
        return $this->render('artist/artist_contact_artwork.html.twig', [
            'form' => $form->createView(),
            'artist' => $user,
            'artwork' => $artwork,
        ]);
    }
    /**
     * @Route("/show_all", name="show_all")
     */
    public function showAll(UserRepository $repository, Request $request, PaginatorInterface $paginator): Response
    {
        $artistsData = $repository->findAll('DESC');
        $artists = $paginator->paginate(
            $artistsData,
            $request->query->getInt('page', 1),
            9
        );
            return $this->render('artist/artist_show_all.html.twig', [
                'artists' => $artists,
            ]);
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

    /**
     * @Route("/reportProfile/{id}", name="report_profile", methods={"GET", "POST"})
     * @IsGranted("ROLE_USER")
     */

    public function reportProfile(EntityManagerInterface $entityManager, User $artist, UserRepository $userRepository): Response
    {
        $connectedUser = $this->getUser();

        $message = new Message();
        $adminContact = $userRepository->findOneBy(['email' => $message->getAdminMailMessenger()]);
        $message->setUser($adminContact);
        $message->setMail($connectedUser->getEmail());
        $message->setObject('Signalement du profil de l\'artiste #' . $artist->getId());
        $message->setContent($connectedUser->getFirstname() . $connectedUser->getLastname() .
            ' a signal?? le profil de ' . $artist->getFirstname() . $artist->getLastname() . ' pour non-conformit??');
        $message->setIsRead(false);
        $message->onPrePersist();
        $entityManager->persist($message);
        $entityManager->flush();
        $this->addFlash('success', 'Message envoy?? !');
        return $this->redirectToRoute('artist_show', ['id' => $artist->getId()]);

        return $this->render('artist/_show_artist.html.twig', [
            'artist' => $artist,
        ]);
    }
}
