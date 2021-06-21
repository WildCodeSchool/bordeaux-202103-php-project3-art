<?php


namespace App\Service;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpClient\HttpClient;
use App\Entity\City;

class CityBuilder
{
    const DEFAULT_ZIPCODE = '33000';
//    const DEFAULT_COORDINATES = [' 	-0.57918','44.837789'];
    const DEFAULT_COORDINATES = ['44.837789','-0.57918'];
    public function fetchCity(string $zipCode): array
    {
        $client = HttpClient::create();
        $response = $client->request('GET','https://geo.api.gouv.fr/communes?fields=nom,centre&format=json&geometry=centre&codePostal=' . $zipCode);
        $content = $response->toArray();
        if(empty($content)) {
            return $this->fetchCity(self::DEFAULT_ZIPCODE);
        }
        return $content[0];
    }
    public function fetchCityByCoordinates(string $latitude, string $longitude ): array
    {
        $client = HttpClient::create();
        $response = $client->request('GET','https://geo.api.gouv.fr/communes?lat=' . $latitude . '&lon=' . $longitude . '&fields=nom,code,codesPostaux,codeDepartement,codeRegion,population&format=json&geometry=centre');
        $content = $response->toArray();
        if(empty($content)) {
            return $this->fetchCityByCoordinates(self::DEFAULT_COORDINATES[0],self::DEFAULT_COORDINATES[1]);
        }
        return $content[0];
    }
}