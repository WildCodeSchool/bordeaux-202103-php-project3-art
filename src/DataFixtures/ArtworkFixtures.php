<?php

namespace App\DataFixtures;

use _HumbugBoxec8571fe8659\Nette\Utils\DateTime;
use App\Entity\Artwork;
use App\Entity\Discipline;
use App\Entity\Media;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\DisciplineFixtures;

class ArtworkFixtures extends Fixture implements DependentFixtureInterface
{

    public const USER_REPARTITION = [
        'user_1',
        'user_1',
        'user_1',
        'user_2',
        'user_2',
        'user_2',
        'user_3',
        'user_3',
        'user_3',
        'user_4',
        'user_4',
        'user_4',
        'user_5',
        'user_5',
        'user_6',
        'user_6'
    ];

    public const DISCIPLINE_REPARTITION = [
        'discipline_1',
        'discipline_1',
        'discipline_1',
        'discipline_2',
        'discipline_2',
        'discipline_2',
        'discipline_3',
        'discipline_3',
        'discipline_3',
        'discipline_3',
        'discipline_3',
        'discipline_3',
        'discipline_4',
        'discipline_4',
        'discipline_4',
        'discipline_4',
    ];


    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < count(self::USER_REPARTITION); $i++) {
            $artwork = new Artwork();
            $artwork->setName('oeuvre ' . ($i + 1));
            $artwork->setDescription(
                'descr' . ($i + 1) .
                'Cuius acerbitati uxor grave accesserat incentivum, germanitate Augusti turgida supra modum,'
            );

            $artwork->setMedia(MediaFixtures::MEDIA_LINKS[$i]);
            $artwork->setCreatedAt(new \DateTime());
            $artwork->setUpdatedAt(new \DateTime());
            $artwork->setDiscipline($this->getReference(self::DISCIPLINE_REPARTITION[$i]));
            $artwork->setUser($this->getReference(self::USER_REPARTITION[$i]));
            $manager->persist($artwork);
            $this->addReference('artwork_' . $i, $artwork);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            DisciplineFixtures::class,
            UserFixtures::class,
        ];
    }
}
