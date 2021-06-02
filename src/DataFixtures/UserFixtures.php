<?php

namespace App\DataFixtures;

use _HumbugBoxec8571fe8659\Nette\Utils\DateTime;
use App\Entity\Avatar;
use App\Entity\Discipline;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    const zipCodes = [
        '33000',
        '17000',
        '33400',
        '33240',
        '33100',
        '33300'
    ];
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i = 1; $i <= 6; $i++) {
            $avatar = new Avatar();
            $avatar->setUrl('artist' . $i . 'jpg');
            $manager->persist($avatar);


            $user = new User();
            $user->setFirstname('Artiste');
            $user->setLastname($i);
            $user->setDescription('Je m\'appelle artiste ' . $i . ', Contrairement à une opinion répandue, le Lorem Ipsum n\'est pas simplement du texte aléatoire.');
            $user->setPseudo('Artist' . $i);
            $user->setZipCode(self::zipCodes[$i - 1]);
            $user->setCreatedAt(new DateTime());
            $user->setUpdatedAt(new DateTime());
            $user->setEmail('artiste' . $i . '@gmail.com');
            $user->setPassword("1234");
            $user->setRoles(['ARTIST']);
            $user->setAvatar($avatar);
            $manager->persist($user);
            $this->addReference('user_' . $i, $user);
        }
        $manager->flush();
    }
}
