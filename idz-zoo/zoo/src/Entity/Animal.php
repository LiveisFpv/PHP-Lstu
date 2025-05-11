<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $animalName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $animalGender = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?int $animalAge = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?int $animalCage = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAnimalGender(): ?string
    {
        return $this->animalGender;
    }

    public function setAnimalGender(string $animalGender): static
    {
        $this->animalGender = $animalGender;

        return $this;
    }

    public function getAnimalAge(): ?int
    {
        return $this->animalAge;
    }

    public function setAnimalAge(int $animalAge): static
    {
        $this->animalAge = $animalAge;

        return $this;
    }

    public function getAnimalCage(): ?int
    {
        return $this->animalCage;
    }

    public function setAnimalCage(int $animalCage): static
    {
        $this->animalCage = $animalCage;

        return $this;
    }
}
