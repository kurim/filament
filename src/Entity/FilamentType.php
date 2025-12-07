<?php

namespace App\Entity;

use App\Repository\FilamentTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FilamentTypeRepository::class)]
class FilamentType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $type_name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $type_description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\ManyToOne(inversedBy: 'filamentTypes')]
    private ?User $created_by = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\ManyToOne(inversedBy: 'filamentTypes')]
    private ?User $updated_by = null;

    /**
     * @var Collection<int, Filaments>
     */
    #[ORM\OneToMany(targetEntity: Filaments::class, mappedBy: 'type_id')]
    private Collection $filaments;

    public function __construct()
    {
        $this->filaments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeName(): ?string
    {
        return $this->type_name;
    }

    public function setTypeName(string $type_name): static
    {
        $this->type_name = $type_name;

        return $this;
    }

    public function getTypeDescription(): ?string
    {
        return $this->type_description;
    }

    public function setTypeDescription(?string $type_description): static
    {
        $this->type_description = $type_description;

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

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): static
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
            $filament->setTypeId($this);
        }

        return $this;
    }

    public function removeFilament(Filaments $filament): static
    {
        if ($this->filaments->removeElement($filament)) {
            // set the owning side to null (unless already changed)
            if ($filament->getTypeId() === $this) {
                $filament->setTypeId(null);
            }
        }

        return $this;
    }
}
