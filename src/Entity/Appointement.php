<?php

namespace App\Entity;

use App\Repository\AppointementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Service;

#[ORM\Entity(repositoryClass: AppointementRepository::class)]
class Appointement
{
    public const STATUS_EN_ATTENTE = 'en_attente';
    public const STATUS_CONFIRME = 'confirme';
    public const STATUS_TERMINE = 'termine';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $civility = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[ORM\ManyToMany(targetEntity: Service::class)]
    private Collection $services;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date1 = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date2 = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date3 = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $moment1 = [];

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $moment2 = [];

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $moment3 = [];

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    private ?string $zipcode = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $message = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    // 🟢 Champ statut (par défaut "en_attente")
    #[ORM\Column(length: 20)]
    private ?string $status = 'en_attente';

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->services = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCivility(): ?string
    {
        return $this->civility;
    }

    public function setCivility(string $civility): static
    {
        $this->civility = $civility;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return Collection<int, Service>
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Service $service): static
    {
        if (!$this->services->contains($service)) {
            $this->services->add($service);
        }
        return $this;
    }

    public function removeService(Service $service): static
    {
        $this->services->removeElement($service);
        return $this;
    }

    public function getDate1(): ?\DateTimeInterface
    {
        return $this->date1;
    }

    public function setDate1(?\DateTimeInterface $date1): static
    {
        $this->date1 = $date1;
        return $this;
    }

    public function getDate2(): ?\DateTimeInterface
    {
        return $this->date2;
    }

    public function setDate2(?\DateTimeInterface $date2): static
    {
        $this->date2 = $date2;
        return $this;
    }

    public function getDate3(): ?\DateTimeInterface
    {
        return $this->date3;
    }

    public function setDate3(?\DateTimeInterface $date3): static
    {
        $this->date3 = $date3;
        return $this;
    }

    public function getMoment1(): ?array
    {
        return $this->moment1;
    }

    public function setMoment1(?array $moment1): static
    {
        $this->moment1 = $moment1;
        return $this;
    }

    public function getMoment2(): ?array
    {
        return $this->moment2;
    }

    public function setMoment2(?array $moment2): static
    {
        $this->moment2 = $moment2;
        return $this;
    }

    public function getMoment3(): ?array
    {
        return $this->moment3;
    }

    public function setMoment3(?array $moment3): static
    {
        $this->moment3 = $moment3;
        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;
        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(string $zipcode): static
    {
        $this->zipcode = $zipcode;
        return $this;
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

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): static
    {
        $this->message = $message;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;
        return $this;
    }
}

