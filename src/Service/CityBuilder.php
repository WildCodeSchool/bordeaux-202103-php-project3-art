<?php


namespace App\Service;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpClient\HttpClient;
use App\Entity\City;

class CityBuilder
{
    const URLREQUESTCITYNAME = 'https://geo.api.gouv.fr/communes?fields=nom,centre&format=json&geometry=centre';
    public function fetchCity(string $zipCode): array
    {
        $client = HttpClient::create();
        $response = $client->request('GET',self::URLREQUESTCITYNAME . '&codePostal=' . $zipCode);
        $content = $response->toArray();
        return $content[0];
    }
    public function buildCityForUser(User $user, string $zipCode)
    {
        $cityFound = $this->fetchCity($zipCode);
        $user->getCity()->setName($cityFound['nom']);
        $user->getCity()->setLongitude($cityFound['centre']['coordinates'][0]);
        $user->getCity()->setLatitude($cityFound['centre']['coordinates'][1]);
    }
    public function buildCityAlone(City $city)
    {
        $cityFound = $this->fetchCity($city->getZipCode());
        $city->setName($cityFound['nom']);
        $city->setLongitude($cityFound['centre']['coordinates'][0]);
        $city->setLatitude($cityFound['centre']['coordinates'][1]);
    }
}