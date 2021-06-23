<?php

namespace App\DataFixtures;

use App\Entity\Response;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ResponseFixtures extends Fixture implements DependentFixtureInterface
{
    const RESPONDANT_DISPATCH = ['user_1','user_1','user_2','user_3','user_4','user_1','user_2'];
    const ANNOUNCEMENT_DISPATCH = ['announcement_1','announcement_2','announcement_3','announcement_4','announcement_5','announcement_6',];
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i <6; $i++) {
            $response = new Response();
            $response->setAnnouncement($this->getReference(self::ANNOUNCEMENT_DISPATCH[$i]));
            $response->setRespondant($this->getReference(self::RESPONDANT_DISPATCH[$i]));
        $manager->persist($response);
        $manager->flush();
        }
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            AnnouncementFixtures::class

        ];
    }
}
