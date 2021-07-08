<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\User;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route ("/admin/message", name="admin_message_")
 * @IsGranted("ROLE_USER")
 */
class AdminMessageController extends AbstractController
{

    /**
     * @Route("/index", name="index")
     */
    public function index(UserRepository $userRepository, MessageRepository $messageRepository): Response
    {
        $message = new Message();
        $admin = $userRepository->findOneBy(['email' => $message->getAdminMailMessenger()]);
        $adminMessages = $messageRepository->findBy(['user' => $admin->getId()]);
        return $this->render('admin/message.html.twig', [
            'messages' => $adminMessages,
        ]);
    }

    /**
     * @Route("/", name="unread",methods={"GET","POST"})
     */
    public function unread(
        MessageRepository $messageRepository,
        User $user
    ): Response {
        $totalUnreadMessage = $messageRepository->countUnreadMessage($user);
        return $this->render('admin/messaging.html.twig', [
            'messages' => $messageRepository->findBy(["user" => $user]),
            'totalUnreadMessage' => $totalUnreadMessage,
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
     * @Route("/isRead/{id}", name="is_read", methods={"GET", "POST"})
     */
    public function mailIsRead(
        Message $mail,
        EntityManagerInterface $entityManager
    ): Response {
        $mail->setIsRead(true);
        $entityManager->flush();
        return $this->redirectToRoute('admin_message', ["_fragment" => "mailbox"]);
    }

    /**
     * @Route("/{id}", name="admin_delete", methods={"POST"})
     */
    public function delete(Message $message, EntityManagerInterface $entityManager, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete' . $message->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($message);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_message', ["_fragment" => "mailbox"]);
    }

    /**
     * @Route("/toggleMailBox", name="toggle", methods={"GET"})
     */
    public function toggle(SessionInterface $session)
    {
        $session->set('isMailBoxOpen', !$session->get('isMailBoxOpen'));
        $this->json(['isMailBoxOpen' => $session->get('isMailBoxOpen')]);
    }
}
