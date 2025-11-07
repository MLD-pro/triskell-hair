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

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $altBefore = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $altAfter = null;

    #[ORM\Column(type: 'integer')]
    private ?int $position = 0; // 0 par défaut (affiché après les >0)

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

    public function getAltBefore(): ?string
    {
        return $this->altBefore;
    }

    public function setAltBefore(?string $altBefore): static
    {
        $this->altBefore = $altBefore;
        return $this;
    }

    public function getAltAfter(): ?string
    {
        return $this->altAfter;
    }

    public function setAltAfter(?string $altAfter): static
    {
        $this->altAfter = $altAfter;
        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;
        return $this;
    }
}


