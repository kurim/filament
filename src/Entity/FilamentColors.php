<?php

namespace App\Entity;

use App\Repository\FilamentColorsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FilamentColorsRepository::class)]
class FilamentColors
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 7)]
    private ?string $color_hex = null;

    #[ORM\Column(length: 100)]
    private ?string $color_name = null;

    #[ORM\ManyToOne(inversedBy: 'filamentColors')]
    private ?User $created_by = null;

    #[ORM\ManyToOne(inversedBy: 'filamentColors')]
    private ?User $updated_by = null;

    /**
     * @var Collection<int, Filaments>
     */
    #[ORM\OneToMany(targetEntity: Filaments::class, mappedBy: 'color_id')]
    private Collection $filaments;

    public function __construct()
    {
        $this->filaments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getColorHex(): ?string
    {
        return $this->color_hex;
    }

    public function setColorHex(string $color_hex): static
    {
        $this->color_hex = $color_hex;

        return $this;
    }

    public function getColorName(): ?string
    {
        return $this->color_name;
    }

    public function setColorName(string $color_name): static
    {
        $this->color_name = $color_name;

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

    public function getUpdatedBy(): ?User
    {
        return $this->updated_by;
    }

    public function setUpdatedBy(?User $updated_by): static
    {
        $this->updated_by = $updated_by;

        return $this;
    }

    /**
     * @return Collection<int, Filaments>
     */
    public function getFilaments(): Collection
    {
        return $this->filaments;
    }

    public function addFilament(Filaments $filament): static
    {
        if (!$this->filaments->contains($filament)) {
            $this->filaments->add($filament);
            $filament->setColorId($this);
        }

        return $this;
    }

    public function removeFilament(Filaments $filament): static
    {
        if ($this->filaments->removeElement($filament)) {
            // set the owning side to null (unless already changed)
            if ($filament->getColorId() === $this) {
                $filament->setColorId(null);
            }
        }

        return $this;
    }

}
