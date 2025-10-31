<?php

namespace App\Repository;

use App\Entity\Location;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class LocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Location::class);
    }

    /**
     * Recherche une ville par nom ou code postal.
     */
    public function searchByCityOrZipcode(string $search): array
    {
        return $this->createQueryBuilder('l')
            ->where('l.city LIKE :search')
            ->orWhere('l.zipcode LIKE :search')
            ->setParameter('search', '%' . $search . '%')
            ->getQuery()
            ->getResult();
    }

    /**
     * Géocode automatiquement une ville et renvoie ses coordonnées GPS (latitude, longitude)
     * via l'API gratuite OpenStreetMap Nominatim.
     */
    public function geocodeLocation(string $city, string $zipcode): ?array
    {
        // Construire la requête vers l’API OpenStreetMap
        $query = urlencode($city . ' ' . $zipcode . ', France');
        $url = "https://nominatim.openstreetmap.org/search?q={$query}&format=json&limit=1";

        // Nécessaire pour que l’API accepte la requête (user agent obligatoire)
        $context = stream_context_create([
            'http' => [
                'header' => "User-Agent: TriskellHair/1.0\r\n"
            ]
        ]);

        // Appel de l’API
        $response = @file_get_contents($url, false, $context);
        if (!$response) {
            return null; // en cas d’échec réseau
        }

        $data = json_decode($response, true);

        // Si l’API renvoie des coordonnées valides
        if (!empty($data) && isset($data[0]['lat'], $data[0]['lon'])) {
            return [
                'lat' => (float) $data[0]['lat'],
                'lon' => (float) $data[0]['lon'],
            ];
        }

        return null;
    }
}
