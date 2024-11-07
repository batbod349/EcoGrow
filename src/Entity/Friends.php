<?php

namespace App\Entity;

use App\Repository\FriendsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FriendsRepository::class)]
class Friends
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $user1 = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $user2 = null;

    #[ORM\Column]
    private ?bool $accepted = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $friend;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser1(): ?user
    {
        return $this->user1;
    }

    public function setUser1(?user $user1): static
    {
        $this->user1 = $user1;

        return $this;
    }

    public function getUser2(): ?user
    {
        return $this->user2;
    }

    public function setUser2(?user $user2): static
    {
        $this->user2 = $user2;

        return $this;
    }

    public function isAccepted(): ?bool
    {
        return $this->accepted;
    }

    public function setAccepted(bool $accepted): static
    {
        $this->accepted = $accepted;

        return $this;
    }

    public function getFriend(): ?User
    {
        return $this->friend;
    }

    public function setFriend(?User $friend): self
    {
        $this->friend = $friend;

        return $this;
    }

}
