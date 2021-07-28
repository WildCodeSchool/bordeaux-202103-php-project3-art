<?php

namespace App\Controller;

use App\Entity\Avatar;
use App\Entity\User;
use App\Entity\City;
use App\Repository\DisciplineRepository;
use DateTimeInterface;
use App\Form\RegistrationFormType;
use App\Security\Authenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(
        Request $request,
        GuardAuthenticatorHandler $guardHandler,
        Authenticator $authenticator,
        UserPasswordEncoderInterface $passwordEncoder,
        DisciplineRepository $disciplineRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $avatar = new Avatar();
            $user->setRoles(['ROLE_USER']);
            $user->setAvatar($avatar);
            $defaultDiscipline = $disciplineRepository->findOneBy(['identifier' => 'artvisu']);
            $city = new City();
            $city->setZipCode('33000');
            $city->setName('Bordeaux');
            $city->setLongitude('-0.5874');
            $city->setLatitude('44.8572');

            $entityManager->persist($city);
            $user->setCity($city);
            $user->getCity()->setZipCode('33000');
            $user->addDiscipline($defaultDiscipline);
            $user->setCreatedAt(new \DateTime());
            $user->setUpdatedAt(new \DateTime());
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
