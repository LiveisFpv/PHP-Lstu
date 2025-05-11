<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['userEmail'], message: 'There is already an account with this userEmail')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $userName = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Email]
    private ?string $userEmail = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 6, minMessage: "Password should be at least {{ limit }} characters")]
    private ?string $userPassword = null;

    #[ORM\Column]
    private array $userRole = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): static
    {
        $this->userName = $userName;

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

    public function getUserPassword(): ?string
    {
        return $this->userPassword;
    }

    public function setUserPassword(string $userPassword): static
    {
        $this->userPassword = $userPassword;

        return $this;
    }

    public function getUserRole(): array
    {
        return $this->userRole;
    }

    public function setUserRole(array $userRole): static
    {
        $this->userRole = $userRole;

        return $this;
    }

    // --- Symfony Security methods below ---

    public function getRoles(): array
    {
        $roles = $this->userRole;
        $roles[] = 'ROLE_USER';
        $roles[] = 'ROLE_ADMIN';
        return array_unique($roles);
    }

    public function getPassword(): string
    {
        return $this->userPassword;
    }

    public function getUserIdentifier(): string
    {
        return $this->userEmail;
    }

    public function eraseCredentials(): void
    {
        // если есть временные данные — очищаем
    }
}
