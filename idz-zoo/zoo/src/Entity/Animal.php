<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $animalGender = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?int $animalAge = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?int $animalCage = null;

    #[ORM\ManyToOne(targetEntity: Care::class, inversedBy: 'animals')]
    #[ORM\JoinColumn(name: 'care_id', referencedColumnName: 'id', nullable: true)]
    private ?Care $care = null;

    public function getCare(): ?Care
    {
        return $this->care;
    }

    public function setCare(?Care $care): void
    {
        $this->care = $care;
    }

    public function getId(): ?int
    {
        return $this->id;
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
