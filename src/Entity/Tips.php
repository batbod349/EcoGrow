<?php

namespace App\Entity;

use App\Repository\TipsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TipsRepository::class)]
class Tips
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::BLOB)]
    private $image;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tips1_title = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $tips1_image = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tips2_title = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $tips2_image = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tips3_title = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $tips3_image = null;

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

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

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

    public function getCreateDate(): ?\DateTimeInterface
    {
        return $this->createDate;
    }

    public function setCreateDate(\DateTimeInterface $createDate): static
    {
        $this->createDate = $createDate;

        return $this;
    }

    public function getTips1Title(): ?string
    {
        return $this->tips1_title;
    }

    public function setTips1Title(?string $tips1_title): static
    {
        $this->tips1_title = $tips1_title;

        return $this;
    }

    public function getTips1Image()
    {
        return $this->tips1_image;
    }

    public function setTips1Image($tips1_image): static
    {
        $this->tips1_image = $tips1_image;

        return $this;
    }

    public function getTips2Title(): ?string
    {
        return $this->tips2_title;
    }

    public function setTips2Title(?string $tips2_title): static
    {
        $this->tips2_title = $tips2_title;

        return $this;
    }

    public function getTips2Image()
    {
        return $this->tips2_image;
    }

    public function setTips2Image($tips2_image): static
    {
        $this->tips2_image = $tips2_image;

        return $this;
    }

    public function getTips3Title(): ?string
    {
        return $this->tips3_title;
    }

    public function setTips3Title(?string $tips3_title): static
    {
        $this->tips3_title = $tips3_title;

        return $this;
    }

    public function getTips3Image()
    {
        return $this->tips3_image;
    }

    public function setTips3Image($tips3_image): static
    {
        $this->tips3_image = $tips3_image;

        return $this;
    }
}
