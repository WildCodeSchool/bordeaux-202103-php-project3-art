<?php

namespace App\DataFixtures;

use App\Entity\Avatar;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProdFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setCreatedAt(new DateTime());
        $admin->setUpdatedAt(new DateTime());
        $admin->setEmail('artdekos@protonmail.com');
        $admin->setPassword($this->encoder->encodePassword($admin, 'w@zM5~Y3Q*z4'));
        $admin->setRoles(["ROLE_SUPER_ADMIN"]);
        $avatar = new Avatar();
        $admin->setAvatar($avatar);
        $manager->persist($admin);
        $this->addReference('admin', $admin);

        $manager->flush();

    }
}
