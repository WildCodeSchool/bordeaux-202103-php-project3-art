<?php

namespace App\DataFixtures;

use App\Entity\Discipline;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DisciplineFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 4; $i++) {
            $discipline = new Discipline();
            $discipline->setName(Discipline::DISCIPLINES[$i]);
            $discipline->setColor(Discipline::COLORS[$i]);
            $manager->persist($discipline);
            $this->addReference('discipline_' . ($i + 1), $discipline);
            $manager->flush();
        }
    }
}
