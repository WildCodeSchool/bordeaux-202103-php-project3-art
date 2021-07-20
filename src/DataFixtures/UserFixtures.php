<?php

namespace App\DataFixtures;

use _HumbugBoxec8571fe8659\Nette\Utils\DateTime;
use App\Entity\Avatar;
use App\Entity\Discipline;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{

    public const ZIP_CODES = [
        '33000',
        '17000',
        '33400',
        '33240',
        '33100',
        '33300'
    ];
    public const EXPERTISES = [
        'danseuse',
        'danseuse',
        'écrivain',
        'écrivaine',
        'chanteur',
        'chanteur'
    ];
    public const DISCIPLINES = [
      'discipline_1',
      'discipline_2',
      'discipline_3',
      'discipline_3',
      'discipline_4',
      'discipline_4',

    ];
    public const FIRSTNAMES = [
        'Nath',
        'Camille',
        'Roger',
        'Catherine',
        'David',
        'Leonardo'

    ];
    public const LASTNAMES = [
        'Sanson',
        'Martin',
        'Philippe',
        'Philippe',
        'To One',
        'Donatello'

    ];
    public const NB_USERS = 6;
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= self::NB_USERS; $i++) {
            $avatar = new Avatar();
            $avatar->setImage('profile' . $i . '.jpg');
            $manager->persist($avatar);


            $user = new User();
            $user->setFirstname(self::FIRSTNAMES[$i - 1]);
            $user->setLastname(self::LASTNAMES[$i - 1]);
            $user->setDescription(
                'Je m\'appelle artiste ' . $i .
                ', Contrairement à une opinion répandue, le Lorem Ipsum n\'est pas simplement du texte aléatoire.'
            );
            $user->setPseudo(self::FIRSTNAMES[$i - 1], self::LASTNAMES[$i - 1]);
            $user->setZipCode(self::ZIP_CODES[$i - 1]);
            $user->setCreatedAt(new DateTime());
            $user->setUpdatedAt(new DateTime());
            $user->setEmail('artiste' . $i . '@gmail.com');
            $user->setPassword($this->encoder->encodePassword($user, '123456'));
            $user->setRoles(["ROLE_USER"]);
            $user->setAvatar($avatar);
            $user->setExpertise(self::EXPERTISES[$i - 1]);
            $user->addDiscipline($this->getReference(self::DISCIPLINES[$i - 1]));
            $user->setCity($this->getReference('city_' . $i));
            $user->setPodium($i);
            $manager->persist($user);
            $this->addReference('user_' . $i, $user);
        }

        $admin = new User();
        $admin->setCreatedAt(new DateTime());
        $admin->setUpdatedAt(new DateTime());
        $admin->setEmail('admin@gmail.com');
        $admin->setPassword($this->encoder->encodePassword($admin, '123456'));
        $admin->setRoles(["ROLE_ADMIN"]);
        $avatar = new Avatar();
        $admin->setAvatar($avatar);
        $manager->persist($admin);
        $this->addReference('admin', $admin);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            DisciplineFixtures::class,
            CityFixtures::class
        ];
    }
}
