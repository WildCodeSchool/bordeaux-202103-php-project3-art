<?php

namespace App\DataFixtures;

use App\Entity\Avatar;
use App\Entity\Discipline;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProdFixtures extends Fixture
{
    private $encoder;


    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setCreatedAt(new \DateTime());
        $admin->setUpdatedAt(new \DateTime());
        $admin->setEmail('artdekos@protonmail.com');
        $admin->setPassword($this->encoder->encodePassword($admin, 'w@zM5~Y3Q*z4'));
        $admin->setRoles(["ROLE_SUPER_ADMIN"]);
        $avatar = new Avatar();
        $admin->setAvatar($avatar);
        $manager->persist($admin);
        $this->addReference('admin', $admin);


        $discipline = new Discipline();
        $discipline->setName('Arts Visuels')
                    ->setIdentifier('artvisu')
                    ->setColor('visu');
        $manager->persist($discipline);

        $discipline = new Discipline();
        $discipline->setName('Arts du mouvement')
                    ->setIdentifier('artmouv')
                    ->setColor('move');
        $manager->persist($discipline);

        $discipline = new Discipline();
        $discipline->setName('Arts Littéraires')
                    ->setIdentifier('artlitt')
                    ->setColor('letters');
        $manager->persist($discipline);

        $discipline = new Discipline();
        $discipline->setName('Arts Musicaux')
                    ->setIdentifier('artmusic')
                    ->setColor('music');
        $manager->persist($discipline);

        $manager->flush();

    }
}
