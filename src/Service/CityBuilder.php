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
}