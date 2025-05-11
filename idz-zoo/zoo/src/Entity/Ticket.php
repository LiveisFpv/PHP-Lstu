<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $ticketDate = null;

    #[ORM\Column(length: 255)]
    private ?string $ticketTime = null;

    #[ORM\Column]
    private ?float $ticketCost = null;

    #[ORM\Column(length: 255)]
    private ?string $userEmail = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTicketDate(): ?string
    {
        return $this->ticketDate;
    }

    public function setTicketDate(string $ticketDate): static
    {
        $this->ticketDate = $ticketDate;

        return $this;
    }

    public function getTicketTime(): ?string
    {
        return $this->ticketTime;
    }

    public function setTicketTime(string $ticketTime): static
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
