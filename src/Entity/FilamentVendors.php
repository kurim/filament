<?php

namespace App\Entity;

use App\Repository\FilamentVendorsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FilamentVendorsRepository::class)]
class FilamentVendors
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $vendor_name = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $vendor_url = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $vendor_logo = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    /**
     * @var Collection<int, Filaments>
     */
    #[ORM\OneToMany(targetEntity: Filaments::class, mappedBy: 'vendor_id')]
    private Collection $filaments;

    public function __construct()
    {
        $this->filaments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVendorName(): ?string
    {
        return $this->vendor_name;
    }

    public function setVendorName(string $vendor_name): static
    {
        $this->vendor_name = $vendor_name;

        return $this;
    }

    public function getVendorUrl(): ?string
    {
        return $this->vendor_url;
    }

    public function setVendorUrl(?string $vendor_url): static
    {
        $this->vendor_url = $vendor_url;

        return $this;
    }

    public function getVendorLogo(): ?string
    {
        return $this->vendor_logo;
    }

    public function setVendorLogo(?string $vendor_logo): static
    {
        $this->vendor_logo = $vendor_logo;

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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

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
            $filament->setVendorId($this);
        }

        return $this;
    }

    public function removeFilament(Filaments $filament): static
    {
        if ($this->filaments->removeElement($filament)) {
            // set the owning side to null (unless already changed)
            if ($filament->getVendorId() === $this) {
                $filament->setVendorId(null);
            }
        }

        return $this;
    }
}
