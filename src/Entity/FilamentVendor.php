<?php

namespace App\Entity;

use App\Repository\FilamentVendorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FilamentVendorRepository::class)]
class FilamentVendor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $link = null;

    /**
     * @var Collection<int, Filament>
     */
    #[ORM\OneToMany(targetEntity: Filament::class, mappedBy: 'vendor')]
    private Collection $filaments;

    public function __construct()
    {
        $this->filaments = new ArrayCollection();
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
            $filament->setVendor($this);
        }

        return $this;
    }

    public function removeFilament(Filament $filament): static
    {
        if ($this->filaments->removeElement($filament)) {
            // set the owning side to null (unless already changed)
            if ($filament->getVendor() === $this) {
                $filament->setVendor(null);
            }
        }

        return $this;
    }
}
