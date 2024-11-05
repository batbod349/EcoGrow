<?php

namespace App\Entity;

use App\Repository\NotificationsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotificationsRepository::class)]
class Notifications
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Type = null;

    #[ORM\ManyToOne(inversedBy: 'notifications')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $User = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $CreateDate = null;

    #[ORM\ManyToOne(inversedBy: 'notifications')]
    private ?Challenge $Challenges = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(string $Type): static
    {
        $this->Type = $Type;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): static
    {
        $this->User = $User;

        return $this;
    }

    public function getCreateDate(): ?\DateTimeInterface
    {
        return $this->CreateDate;
    }

    public function setCreateDate(\DateTimeInterface $CreateDate): static
    {
        $this->CreateDate = $CreateDate;

        return $this;
    }

    public function getChallenges(): ?Challenge
    {
        return $this->Challenges;
    }

    public function setChallenges(?Challenge $Challenges): static
    {
        $this->Challenges = $Challenges;

        return $this;
    }
}
