<?php

namespace App\Entity;

use App\Repository\AchievementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AchievementRepository::class)]
class Achievement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $imageBefore = null;

    #[ORM\Column(length: 255)]
    private ?string $imageAfter = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageBefore(): ?string
    {
        return $this->imageBefore;
    }

    public function setImageBefore(string $imageBefore): static
    {
        $this->imageBefore = $imageBefore;

        return $this;
    }

    public function getImageAfter(): ?string
    {
        return $this->imageAfter;
    }

    public function setImageAfter(string $imageAfter): static
    {
        $this->imageAfter = $imageAfter;

        return $this;
    }
}
