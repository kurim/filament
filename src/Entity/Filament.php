<?php

namespace App\Entity;

use App\Repository\FilamentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FilamentRepository::class)]
class Filament
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $qrcode = null;

    #[ORM\Column(length: 255)]
    private ?string $color = null;

    #[ORM\Column(length: 6)]
    private ?string $colorhex = null;

    #[ORM\Column]
    private array $specs = [];

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $link = null;

    #[ORM\ManyToOne(inversedBy: 'filaments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FilamentVendor $vendor = null;

    #[ORM\ManyToOne(inversedBy: 'filaments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FilamentMaterial $material = null;

    #[ORM\ManyToOne(inversedBy: 'filaments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FilamentBasecolor $basecolor = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQrcode(): ?string
    {
        return $this->qrcode;
    }

    public function setQrcode(string $qrcode): static
    {
        $this->qrcode = $qrcode;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getColorhex(): ?string
    {
        return $this->colorhex;
    }

    public function setColorhex(string $colorhex): static
    {
        $this->colorhex = $colorhex;

        return $this;
    }

    public function getSpecs(): array
    {
        return $this->specs;
    }

    public function setSpecs(array $specs): static
    {
        $this->specs = $specs;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): static
    {
        $this->link = $link;

        return $this;
    }

    public function getVendor(): ?FilamentVendor
    {
        return $this->vendor;
    }

    public function setVendor(?FilamentVendor $vendor): static
    {
        $this->vendor = $vendor;

        return $this;
    }

    public function getMaterial(): ?FilamentMaterial
    {
        return $this->material;
    }

    public function setMaterial(?FilamentMaterial $material): static
    {
        $this->material = $material;

        return $this;
    }

    public function getBasecolor(): ?FilamentBasecolor
    {
        return $this->basecolor;
    }

    public function setBasecolor(?FilamentBasecolor $basecolor): static
    {
        $this->basecolor = $basecolor;

        return $this;
    }
}
