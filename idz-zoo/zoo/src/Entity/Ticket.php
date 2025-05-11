<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank]
    private ?DateTime $ticketDate = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank]
    private ?DateTime $ticketTime = null;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Assert\NotBlank]
    private ?float $ticketCost = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank]
    private ?string $userEmail = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTicketDate(): ?string
    {
        return $this->ticketDate ? $this->ticketDate->format('Y-m-d') : null;
    }

    public function setTicketDate(DateTime $ticketDate): static
    {
        $this->ticketDate = $ticketDate;

        return $this;
    }

    public function getTicketTime(): ?string
    {
        return $this->ticketTime ? $this->ticketTime->format('H:i:s') : null;
    }

    public function setTicketTime(DateTime $ticketTime): static
    {
        $this->ticketTime = $ticketTime;

        return $this;
    }

    public function getTicketCost(): ?float
    {
        return $this->ticketCost;
    }

    public function setTicketCost(float $ticketCost): static
    {
        $this->ticketCost = $ticketCost;

        return $this;
    }

    public function getUserEmail(): ?string
    {
        return $this->userEmail;
    }

    public function setUserEmail(string $userEmail): static
    {
        $this->userEmail = $userEmail;

        return $this;
    }
}
