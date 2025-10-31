<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $zipcode = null;

    #[ORM\Column(nullable: true)]
    private ?float $latitude = null;

    #[ORM\Column(nullable: true)]
    private ?float $longitude = null;

    // === Remplit automatiquement latitude/longitude avant sauvegarde ===
    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function updateCoordinates(): void
    {
        if (!$this->city || !$this->zipcode) {
            return;
        }

        $url = sprintf(
            'https://nominatim.openstreetmap.org/search?city=%s&postalcode=%s&format=json&limit=1',
            urlencode($this->city),
            urlencode($this->zipcode)
        );

        try {
            $context = stream_context_create([
                'http' => [
                    'header' => "User-Agent: TriskellHair/1.0\r\n"
                ]
            ]);
            $response = file_get_contents($url, false, $context);
            $data = json_decode($response, true);

            if (!empty($data[0])) {
                $this->latitude = (float) $data[0]['lat'];
                $this->longitude = (float) $data[0]['lon'];
            }
        } catch (\Throwable $e) {
            // on ignore les erreurs API
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;
        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(?string $zipcode): static
    {
        $this->zipcode = $zipcode;
        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): static
    {
        $this->latitude = $latitude;
        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): static
    {
        $this->longitude = $longitude;
        return $this;
    }
}

