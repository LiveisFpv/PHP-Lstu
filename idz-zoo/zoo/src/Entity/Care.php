<?php

namespace App\Entity;

use App\Repository\CareRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CareRepository::class)]
class Care
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $careType = null;

    #[ORM\Column(length: 255)]
    private ?string $animalName = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCareType(): ?string
    {
        return $this->careType;
    }

    public function setCareType(string $careType): static
    {
        $this->careType = $careType;

        return $this;
    }

    public function getAnimalName(): ?string
    {
        return $this->animalName;
    }

    public function setAnimalName(string $animalName): static
    {
        $this->animalName = $animalName;

        return $this;
    }
}
