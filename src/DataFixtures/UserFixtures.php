<?php

namespace App\DataFixtures;

use _HumbugBoxec8571fe8659\Nette\Utils\DateTime;
use App\Entity\Avatar;
use App\Entity\Discipline;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

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
      'discipline_2',
      'discipline_2',
      'discipline_3',
      'discipline_3',
      'discipline_4',
      'discipline_4',

    ];
    public const NB_USERS = 6;

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= self::NB_USERS; $i++) {
            $avatar = new Avatar();
            $avatar->setUrl('artist_' . $i . '.jpg');
            $manager->persist($avatar);


            $user = new User();
            $user->setFirstname('Artiste');
            $user->setLastname($i);
            $user->setDescription(
                'Je m\'appelle artiste ' . $i .
                ', Contrairement à une opinion répandue, le Lorem Ipsum n\'est pas simplement du texte aléatoire.'
            );
            $user->setPseudo('Artist' . $i);
            $user->setZipCode(self::ZIP_CODES[$i - 1]);
            $user->setCreatedAt(new DateTime());
            $user->setUpdatedAt(new DateTime());
            $user->setEmail('artiste' . $i . '@gmail.com');
            $user->setPassword("1234");
            $user->setRoles(['ARTIST']);
            $user->setAvatar($avatar);
            $user->setExpertise(self::EXPERTISES[$i - 1]);
            $user->addDiscipline($this->getReference(self::DISCIPLINES[$i - 1]));
            $manager->persist($user);
            $this->addReference('user_' . $i, $user);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            DisciplineFixtures::class,
        ];
    }
}
