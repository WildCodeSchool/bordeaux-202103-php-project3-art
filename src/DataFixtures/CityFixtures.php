<?php

namespace App\DataFixtures;

use App\Service\CityBuilder;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\City;

class CityFixtures extends Fixture
{
    private CityBuilder $cityBuilder;
    const ZIP_CODE_DISPATCH = ['17000', '33000', '16000', '33100', '33600', '33130'];
    public function __construct(CityBuilder $cityBuilder)
    {
        $this->cityBuilder = $cityBuilder;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 6; $i++) {
            $city = new City();
            $city->setZipCode(self::ZIP_CODE_DISPATCH[$i]);
            $this->cityBuilder->buildCityAlone($city);
            $manager->persist($city);
            $this->addReference('city_' . ($i + 1), $city);
            $manager->flush();

        }
    }
}
