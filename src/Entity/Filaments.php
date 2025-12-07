<?php

namespace App\Entity;

use App\Repository\FilamentsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FilamentsRepository::class)]
class Filaments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $filament_name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $filament_descriptio = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $filament_url = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $image_url = null;

    #[ORM\ManyToOne(inversedBy: 'filaments')]
    private ?FilamentColors $color_id = null;

    #[ORM\ManyToOne(inversedBy: 'filaments')]
    private ?FilamentType $type_id = null;

    #[ORM\ManyToOne(inversedBy: 'filaments')]
    private ?FilamentVendors $vendor_id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\ManyToOne(inversedBy: 'filaments')]
    private ?User $created_by = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\ManyToOne(inversedBy: 'filaments')]
    private ?User $updated_by = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilamentName(): ?string
    {
        return $this->filament_name;
    }

    public function setFilamentName(string $filament_name): static
    {
        $this->filament_name = $filament_name;

        return $this;
    }

    public function getFilamentDescriptio(): ?string
    {
        return $this->filament_descriptio;
    }

    public function setFilamentDescriptio(?string $filament_descriptio): static
    {
        $this->filament_descriptio = $filament_descriptio;

        return $this;
    }

    public function getFilamentUrl(): ?string
    {
        return $this->filament_url;
    }

    public function setFilamentUrl(?string $filament_url): static
    {
        $this->filament_url = $filament_url;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->image_url;
    }

    public function setImageUrl(?string $image_url): static
    {
        $this->image_url = $image_url;

        return $this;
    }

    public function getColorId(): ?FilamentColors
    {
        return $this->color_id;
    }

    public function setColorId(?FilamentColors $color_id): static
    {
        $this->color_id = $color_id;

        return $this;
    }

    public function getTypeId(): ?FilamentType
    {
        return $this->type_id;
    }

    public function setTypeId(?FilamentType $type_id): static
    {
        $this->type_id = $type_id;

        return $this;
    }

    public function getVendorId(): ?FilamentVendors
    {
        return $this->vendor_id;
    }

    public function setVendorId(?FilamentVendors $vendor_id): static
    {
        $this->vendor_id = $vendor_id;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->created_by;
    }

    public function setCreatedBy(?User $created_by): static
    {
        $this->created_by = $created_by;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getUpdatedBy(): ?User
    {
        return $this->updated_by;
    }

    public function setUpdatedBy(?User $updated_by): static
    {
        $this->updated_by = $updated_by;

        return $this;
    }
}
