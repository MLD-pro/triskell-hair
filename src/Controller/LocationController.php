<?php

namespace App\Controller;

use App\Entity\Location;
use App\Form\LocationSearchType;
use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LocationController extends AbstractController
{
    #[Route('/location', name: 'app_location')]
    public function index(Request $request, LocationRepository $locationRepository): Response
    {
        $form = $this->createForm(LocationSearchType::class);
        $form->handleRequest($request);

        $locations = [];
        $message = null;
        $cityCoords = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->get('search')->getData();
            $locations = $locationRepository->searchByCityOrZipcode($search);

            if (!empty($locations)) {
                $message = [
                    'type' => 'success',
                    'text' => "Oui, je me déplace chez vous !"
                ];

                $firstLocation = $locations[0];
                if ($firstLocation->getLatitude() && $firstLocation->getLongitude()) {
                    $cityCoords = [
                        'lat' => $firstLocation->getLatitude(),
                        'lon' => $firstLocation->getLongitude(),
                    ];
                }
            } else {
                $message = [
                    'type' => 'error',
                    'text' => "Désolée, je ne me déplace pas encore chez vous. Contactez-moi pour vérifier."
                ];
            }

            // Si c’est une requête AJAX -> renvoi JSON
            if ($request->isXmlHttpRequest()) {
                return new JsonResponse([
                    'message' => $message,
                    'locations' => array_map(fn($loc) => [
                        'city' => $loc->getCity(),
                        'zipcode' => $loc->getZipcode(),
                        'lat' => $loc->getLatitude(),
                        'lon' => $loc->getLongitude(),
                    ], $locations),
                    'cityCoords' => $cityCoords,
                ]);
            }
        }

        return $this->render('location/index.html.twig', [
            'form' => $form->createView(),
            'locations' => $locations,
            'isSubmitted' => $form->isSubmitted(),
            'message' => $message,
            'cityCoords' => $cityCoords,
        ]);
    }

    // --- AJOUT AUTOMATIQUE DES COORDONNÉES QUAND L’ADMIN AJOUTE UNE VILLE ---
    #[Route('/admin/location/add', name: 'admin_location_add', methods: ['POST'])]
    public function addLocation(Request $request, EntityManagerInterface $em): Response
    {
        $city = $request->request->get('city');
        $zipcode = $request->request->get('zipcode');

        if (!$city || !$zipcode) {
            return new JsonResponse(['error' => 'Ville et code postal requis.'], 400);
        }

        $location = new Location();
        $location->setCity($city);
        $location->setZipcode($zipcode);

        // Appel automatique à l’API OpenStreetMap
        $query = urlencode("$city $zipcode France");
        $url = "https://nominatim.openstreetmap.org/search?q=$query&format=json&limit=1";

        $response = @file_get_contents($url);
        if ($response) {
            $data = json_decode($response, true);
            if (!empty($data)) {
                $location->setLatitude($data[0]['lat']);
                $location->setLongitude($data[0]['lon']);
            }
        }

        $em->persist($location);
        $em->flush();

        return new JsonResponse([
            'success' => true,
            'city' => $city,
            'zipcode' => $zipcode,
            'lat' => $location->getLatitude(),
            'lon' => $location->getLongitude(),
        ]);
    }
}


