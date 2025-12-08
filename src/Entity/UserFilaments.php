<?php

namespace App\Entity;

use App\Repository\UserFilamentsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserFilamentsRepository::class)]
class UserFilaments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userFilaments')]
    private ?User $user_id = null;

    #[ORM\ManyToOne(inversedBy: 'userFilaments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Filaments $filament_id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 0, nullable: true)]
    private ?string $amount = null;

    #[ORM\Column(nullable: true)]
    private ?int $storage_number = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $storage_type = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getFilamentId(): ?Filaments
    {
        return $this->filament_id;
    }

    public function setFilamentId(?Filaments $filament_id): static
    {
        $this->filament_id = $filament_id;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(?string $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getStorageNumber(): ?int
    {
        return $this->storage_number;
    }

    public function setStorageNumber(?int $storage_number): static
    {
        $this->storage_number = $storage_number;

        return $this;
    }

    public function getStorageType(): ?string
    {
        return $this->storage_type;
    }

    public function setStorageType(?string $storage_type): static
    {
        $this->storage_type = $storage_type;

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
}
