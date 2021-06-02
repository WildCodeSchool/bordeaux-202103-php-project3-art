<?php

namespace App\DataFixtures;

use _HumbugBoxec8571fe8659\Nette\Utils\DateTime;
use App\Entity\Artwork;
use App\Entity\Discipline;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\DisciplineFixtures;

class ArtworkFixtures extends Fixture implements DependentFixtureInterface
{
    const MEDIA_LINKS = [
        'https://www.youtube.com/watch?v=eIBCd4zmPDA',
        'https://www.youtube.com/watch?v=W25W2jOmKUM',
        'https://www.youtube.com/watch?v=XNhfV_53W7A',
        'https://www.youtube.com/watch?v=SXfgixkt4-Q',
        'https://www.youtube.com/watch?v=9tG-xwv0kw0',
        'https://www.youtube.com/watch?v=-kT0HJhm5ck',
        'https://images-na.ssl-images-amazon.com/images/I/71k3hhdlc+L.jpg',
        'https://images-na.ssl-images-amazon.com/images/I/711O-AZOBQL.jpg',
        'https://images-na.ssl-images-amazon.com/images/I/61vcmNNnZaL.jpg',
        'https://images-na.ssl-images-amazon.com/images/I/81C+n9HH63L.jpg',
        'https://images-na.ssl-images-amazon.com/images/I/61uJXHwZuPL.jpg',
        'https://images-na.ssl-images-amazon.com/images/I/91dVpTCx1vL.jpg',
        'https://www.youtube.com/watch?v=1jCh5XLGWEs',
        'https://www.youtube.com/watch?v=IXkG7SRtJJs',
        'https://www.youtube.com/watch?v=J78NMdKN5UQ',
        'https://www.youtube.com/watch?v=T19d8I4v1Gw',
    ];
    const USER_REPARTITION = [
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

    const DISCIPLINE_REPARTITION = [
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
        for ($i = 0; $i < 16; $i++) {
            $artwork = new Artwork();
            $artwork->setName('oeuvre ' . ($i + 1));
            $artwork->setDescription('descr' . ($i + 1) . 'Cuius acerbitati uxor grave accesserat incentivum, germanitate Augusti turgida supra modum,');
            $artwork->setMedia(self::MEDIA_LINKS[$i]);
            $artwork->setCreatedAt(new DateTime());
            $artwork->setUpdatedAt(new DateTime());
            $artwork->setDiscipline($this->getReference(self::DISCIPLINE_REPARTITION[$i]));
            $artwork->setUser($this->getReference(self::USER_REPARTITION[$i]));
            $manager->persist($artwork);
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
