<?php

namespace App\Controller;

use App\Entity\Message;
use App\Repository\MessageRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
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
    public function index(
        UserRepository $userRepository,
        MessageRepository $messageRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $admin = $userRepository->findOneBy(['email' => Message::ADMIN_MAIL]);
        $adminMessagesData = $messageRepository->findBy(
            ['user' => $admin->getId()],
            ['sendAt' => 'DESC']
        );
        $adminMessages = $paginator->paginate(
            $adminMessagesData,
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('admin/message.html.twig', [
            'messages' => $adminMessages,
        ]);
    }

    public function countUnreadMessage(UserRepository $userRepository, MessageRepository $messageRepository): Response
    {
        $message = new Message();
        $admin = $userRepository->findOneBy(['email' => Message::ADMIN_MAIL]);
        $totalUnreadAdminMessage = $messageRepository->countUnreadMessage($admin);
        return $this->render('admin/_unread_admin.html.twig', [
            'totalUnreadAdminMessage' => $totalUnreadAdminMessage,
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
        return $this->redirectToRoute('admin_message_index');
    }

    /**
     * @Route("/{id}", name="delete", methods={"POST"})
     */
    public function delete(Message $message, EntityManagerInterface $entityManager, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete' . $message->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($message);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_message_index');
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
