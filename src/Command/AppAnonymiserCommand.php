<?php

namespace App\Command;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AppAnonymiserCommand extends Command
{
    protected static $defaultName = 'app-anonymiser';
    protected static $defaultDescription = 'Anonymise inactives users';
    private UserRepository $userRepository;
    private EntityManagerInterface $entityManager;
    private LoggerInterface $logger;

    public function __construct(
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        LoggerInterface $logger,
        string $name = null

    ) {
        parent::__construct($name);
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->logger = $logger;

    }

    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $usersInactive = $this->userRepository->findBy(['isActive' => false, 'isAnonymised' => false]);
        $numberUsersInactives = count($usersInactive);
        foreach ($usersInactive as $userInactive) {
            $userInactive->setEmail(uniqid('uniq-mail'));
            $userInactive->setFirstname(uniqid('uniq-firstname'));
            $userInactive->setLastname(uniqid('uniq-lastname'));
            $userInactive->setPseudo(uniqid('uniq-pseudo'));
            $userInactive->setDescription(uniqid('uniq-description'));
            $userInactive->setZipCode(null);
            $avatar = $userInactive->getAvatar();
            $this->entityManager->remove($avatar);
            $userInactive->setFacebookUrl(uniqid('uniq-facebook'));
            $userInactive->setInstagramUrl(uniqid('uniq-instagram'));
            $userInactive->setIsAnonymised(true);
        }
        if ($input->getOption('option1')) {
            // ...
        }

        $this->entityManager->flush();
        $this->logger->info('Succes : ' . $numberUsersInactives . ' users has been anonymised.');
        $io->success('Succes : ' . $numberUsersInactives . ' users has been anonymised.');

        return Command::SUCCESS;
    }
}
