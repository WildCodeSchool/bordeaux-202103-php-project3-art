<?php


namespace App\Service;


use Symfony\Component\HttpClient\HttpClient;

class CityBuilder
{
    const URLREQUESTCITYNAME = 'https://geo.api.gouv.fr/communes?fields=nom,centre&format=json&geometry=centre';
    public function searchName(string $zipCode): array
    {
        $client = HttpClient::create();
        $response = $client->request('GET',self::URLREQUESTCITYNAME . '&codePostal=' . $zipCode);
        $content = $response->toArray();
        return $content[0];
    }
}