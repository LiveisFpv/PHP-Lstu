<?php

namespace App\Entity;

use App\Repository\CareRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CareRepository::class)]
class Care
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255,)]
    #[Assert\NotBlank]
    private ?string $careType = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank]
    private ?string $animalName = null;

    #[ORM\OneToMany(mappedBy: 'care', targetEntity: Animal::class)]
    private Collection $animals;

    public function getAnimals(): Collection
    {
        return $this->animals;
    }


    public function __construct()
    {
        $this->animals = new ArrayCollection();
    }

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
