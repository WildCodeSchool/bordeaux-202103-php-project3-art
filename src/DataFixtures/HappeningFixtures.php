<?php

namespace App\DataFixtures;

use App\Entity\Avatar;
use App\Entity\Discipline;
use App\Entity\Happening;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class HappeningFixtures extends Fixture implements DependentFixtureInterface

{
    public function load(ObjectManager $manager)
    {
        $happening1 = new Happening();
        $happening1->setTitle('Pool Party');
        $happening1->setMedia('https://venngage-wordpress.s3.amazonaws.com/uploads/2018/10/Creative-Pool-Party-Event-Poster-Template.jpg');
        $happening1->setContent('Nullam nulla risus, pulvinar congue tellus dapibus, elementum gravida quam. Integer et leo eu nulla vestibulum laoreet sed tincidunt nulla. Suspendisse eget lectus quis odio aliquam iaculis.');
        $happening1->setDateStart(new \DateTime());
        $happening1->setDateEnd(new \DateTime());
        $happening1->setCreatedAt(new \DateTime());
        $happening1->setUpdatedAt(new \DateTime());
        $happening1->setUser($this->getReference('user_1'));
        $manager->persist($happening1);

        $happening2 = new Happening();
        $happening2->setTitle('Jazz Festival');
        $happening2->setMedia('https://www.crushpixel.com/big-static12/preview4/vector-illustration-poster-flyer-design-1004277.jpg');
        $happening2->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. In non metus a urna elementum bibendum sed vitae arcu. Integer nibh erat, vestibulum quis euismod sed, finibus quis ipsum.');
        $happening2->setDateStart(new \DateTime());
        $happening2->setDateEnd(new \DateTime());
        $happening2->setCreatedAt(new \DateTime());
        $happening2->setUpdatedAt(new \DateTime());
        $happening2->setUser($this->getReference('user_2'));
        $manager->persist($happening2);

        $happening3 = new Happening();
        $happening3->setTitle('Community PicNic');
        $happening3->setMedia('https://s3.amazonaws.com/thumbnails.venngage.com/template/112a39f4-2d97-44aa-ae3a-0e95a60abbce.png');
        $happening3->setContent('Duis eu ex bibendum mauris fringilla venenatis nec ac elit. Ut efficitur, libero et tempor consequat, sapien elit pulvinar nisl, et viverra arcu urna non tortor.');
        $happening3->setDateStart(new \DateTime());
        $happening3->setDateEnd(new \DateTime());
        $happening3->setCreatedAt(new \DateTime());
        $happening3->setUpdatedAt(new \DateTime());
        $happening3->setUser($this->getReference('user_3'));
        $manager->persist($happening3);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class
        ];
    }
}
