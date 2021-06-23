<?php

namespace App\DataFixtures;

use App\Entity\Announcement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;


class AnnouncementFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $date1 = new \DateTime();
        $date1->setDate(2021,4,4);
        $date2 = new \DateTime();
        $date2->setDate(2021,5,4);
        $date3 = new \DateTime();
        $date3->setDate(2021,6,4);
        $date4 = new \DateTime();
        $date4->setDate(2021,6,4);
        $date5 = new \DateTime();
        $date5->setDate(2021,7,4);
        $date6 = new \DateTime();
        $date6->setDate(2021,8,4);
        $date7 = new \DateTime();
        $date7->setDate(2021,9,4);
        $date8 = new \DateTime();
        $date8->setDate(2021,10,4);
        $date9 = new \DateTime();
        $date8->setDate(2021,10,4);
        $date10 = new \DateTime();
        $date8->setDate(2021,10,4);

        $dateDispatch = [$date1, $date2, $date3, $date4, $date5, $date6, $date7, $date8, $date9, $date10];

        $time1 = new \DateTime();
        $time1->setTime(1,00);
        $time2 = new \DateTime();
        $time2->setTime(2,00);
        $time3 = new \DateTime();
        $time3->setTime(3,00);
        $time4 = new \DateTime();
        $time4->setTime(4,00);
        $time5 = new \DateTime();
        $time5->setTime(5,00);
        $time6 = new \DateTime();
        $time6->setTime(6,00);
        $time7 = new \DateTime();
        $time7->setTime(7,00);
        $time8 = new \DateTime();
        $time8->setTime(8,00);
        $time9 = new \DateTime();
        $time9->setTime(9,00);
        $time10 = new \DateTime();
        $time10->setTime(10,00);

        $timeDispatch = [$time1,$time2,$time3,$time4,$time5,$time6,$time7,$time8,$time9,$time10];

        $discplineDispatch =  [
            $this->getReference('discipline_1'),
            $this->getReference('discipline_2'),
            $this->getReference('discipline_3'),
            $this->getReference('discipline_4'),
            $this->getReference('discipline_1'),
            $this->getReference('discipline_2'),
            $this->getReference('discipline_2'),
            $this->getReference('discipline_3'),
            $this->getReference('discipline_3'),
            $this->getReference('discipline_4'),

        ];
        $userDispatch = [
            $this->getReference('user_1'),
            $this->getReference('user_2'),
            $this->getReference('user_3'),
            $this->getReference('user_4'),
            $this->getReference('user_5'),
            $this->getReference('user_6'),
            $this->getReference('user_1'),
            $this->getReference('user_1'),
            $this->getReference('user_1'),
            $this->getReference('user_4'),
        ];



        for ($i = 1; $i <=10 ;$i++) {
            $announcement = new Announcement();
            $announcement->setTitle("Titre annonce n°" . $i);
            $announcement->setContent('Contenu de l\'annonce n°' . $i . '<br/> Haec igitur lex in amicitia sanciatur, ut neque rogemus res turpes nec faciamus rogati. Turpis enim excusatio est et minime accipienda cum in ceteris peccatis, tum si quis contra rem publicam se amici causa fecisse fateatur. Etenim eo loco, Fanni et Scaevola, locati sumus ut nos longe prospicere oporteat futuros casus rei publicae. Deflexit iam aliquantum de spatio curriculoque consuetudo maiorum.');
            $announcement-> setDate($dateDispatch[($i-1)]);
            $announcement->setTime( $timeDispatch[($i-1)]);
            $announcement->setCreatedAt(new \DateTime());
            $announcement->setUpdatedAt(new \DateTime());
            $announcement->setUser($userDispatch[($i-1)]);
            $announcement->setDiscipline($discplineDispatch[($i-1)]);
            $manager->persist($announcement);
            $manager->flush();



        }


    }

    public function getDependencies()
    {
        return [
            DisciplineFixtures::class,
            UserFixtures::class
        ];
    }
}
