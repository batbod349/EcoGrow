<?php

namespace App\Entity;

use App\Repository\BadgesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BadgesRepository::class)]
class Badges
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, user>
     */
    #[ORM\ManyToMany(targetEntity: user::class, inversedBy: 'badges')]
    private Collection $user_medals;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $image = null;

    public function __construct()
    {
        $this->user_medals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, user>
     */
    public function getUserMedals(): Collection
    {
        return $this->user_medals;
    }

    public function addUserMedal(user $userMedal): static
    {
        if (!$this->user_medals->contains($userMedal)) {
            $this->user_medals->add($userMedal);
        }

        return $this;
    }

    public function removeUserMedal(user $userMedal): static
    {
        $this->user_medals->removeElement($userMedal);

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getImage()
    {

        if ($this->image === null) {
            return null;
        }

        rewind($this->image);
        $stream = stream_get_contents($this->image);
        if ($stream === false) {
            return null;
        }

        return base64_encode($stream);
    }

    public function setImage($image): static
    {
        $this->image = $image;

        return $this;
    }
}
