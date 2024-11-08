<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $image = null;

    /**
     * @var Collection<int, user>
     */
    #[ORM\ManyToMany(targetEntity: user::class, inversedBy: 'purchase')]
    private Collection $achat;

    public function __construct()
    {
        $this->achat = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

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

    /**
     * @return Collection<int, user>
     */
    public function getAchat(): Collection
    {
        return $this->achat;
    }

    public function addAchat(user $achat): static
    {
        if (!$this->achat->contains($achat)) {
            $this->achat->add($achat);
        }

        return $this;
    }

    public function removeAchat(user $achat): static
    {
        $this->achat->removeElement($achat);

        return $this;
    }
}
