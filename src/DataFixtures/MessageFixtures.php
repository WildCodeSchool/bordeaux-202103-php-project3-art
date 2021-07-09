<?php


namespace App\DataFixtures;


use App\Entity\Message;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MessageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for($i=0; $i<10; $i++){
            $message = new Message();
            $message->setUser($this->getReference('user_1'));
            $message->setMail('artist2@gmail.com');
            $message->setObject('Test' .$i);
            $message->setContent('Test' .$i . 'paginator');
            $message->setIsRead(false);
            $message->setSendAt(new \DateTime());
            $manager->persist($message);
            $manager->flush();
        }
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class
        ];
    }
}
