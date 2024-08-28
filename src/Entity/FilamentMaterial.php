<?php

namespace App\Entity;

use App\Repository\FilamentMaterialRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FilamentMaterialRepository::class)]
class FilamentMaterial
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $material_name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $material_description = null;

    /**
     * @var Collection<int, Filament>
     */
    #[ORM\OneToMany(targetEntity: Filament::class, mappedBy: 'material')]
    private Collection $filaments;

    public function __construct()
    {
        $this->filaments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMaterialName(): ?string
    {
        return $this->material_name;
    }

    public function setMaterialName(string $material_name): static
    {
        $this->material_name = $material_name;

        return $this;
    }

    public function getMaterialDescription(): ?string
    {
        return $this->material_description;
    }

    public function setMaterialDescription(?string $material_description): static
    {
        $this->material_description = $material_description;

        return $this;
    }

    /**
     * @return Collection<int, Filament>
     */
    public function getFilaments(): Collection
    {
        return $this->filaments;
    }

    public function addFilament(Filament $filament): static
    {
        if (!$this->filaments->contains($filament)) {
            $this->filaments->add($filament);
            $filament->setMaterial($this);
        }

        return $this;
    }

    public function removeFilament(Filament $filament): static
    {
        if ($this->filaments->removeElement($filament)) {
            // set the owning side to null (unless already changed)
            if ($filament->getMaterial() === $this) {
                $filament->setMaterial(null);
            }
        }

        return $this;
    }
}
