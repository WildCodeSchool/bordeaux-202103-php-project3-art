<?php

namespace App\Controller;

use App\Entity\City;
use App\Form\CityType;
use App\Service\CityBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/city", name="city")
 */
class CityController extends AbstractController
{
    private $cityBuilder;

    public function __construct(CityBuilder $cityBuilder )
    {
        $this->cityBuilder = $cityBuilder;
    }

    /**
     * @Route("/test", name="test", methods={"GET","POST"})
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $city = new City();
        $form = $this->createForm(CityType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $zipCode = $request->request->get('city')['zipCode'];
            $cityFound = $this->cityBuilder->searchName($zipCode);
            $city->setName($cityFound['nom']);
            $city->setZipCode($zipCode);
            $city->setLongitude($cityFound['centre']['coordinates'][0]);
            $city->setLatitude($cityFound['centre']['coordinates'][1]);
            $city->addUser($this->getUser());
            $entityManager->persist($city);
            $entityManager->flush();
        }
        return $this->render('city/index.html.twig', [
            'city' => $city,
            'form' => $form->createView()
        ]);
    }
}
