<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USERNAME', fields: ['username'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 180)]
    private ?string $username = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 500)]
    private ?string $email = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $avatar = null;

    #[ORM\Column(length: 2)]
    private ?string $language = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    /**
     * @var Collection<int, FilamentColors>
     */
    #[ORM\OneToMany(targetEntity: FilamentColors::class, mappedBy: 'created_by')]
    private Collection $filamentColors;

    /**
     * @var Collection<int, FilamentType>
     */
    #[ORM\OneToMany(targetEntity: FilamentType::class, mappedBy: 'created_by')]
    private Collection $filamentTypes;

    /**
     * @var Collection<int, Filaments>
     */
    #[ORM\OneToMany(targetEntity: Filaments::class, mappedBy: 'created_by')]
    private Collection $filaments;

    public function __construct()
    {
        $this->filamentColors = new ArrayCollection();
        $this->filamentTypes = new ArrayCollection();
        $this->filaments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Ensure the session doesn't contain actual password hashes by CRC32C-hashing them, as supported since Symfony 7.3.
     */
    public function __serialize(): array
    {
        $data = (array) $this;
        $data["\0".self::class."\0password"] = hash('crc32c', $this->password);

        return $data;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): static
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): static
    {
        $this->language = $language;

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

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection<int, FilamentColors>
     */
    public function getFilamentColors(): Collection
    {
        return $this->filamentColors;
    }

    public function addFilamentColor(FilamentColors $filamentColor): static
    {
        if (!$this->filamentColors->contains($filamentColor)) {
            $this->filamentColors->add($filamentColor);
            $filamentColor->setCreatedBy($this);
        }

        return $this;
    }

    public function removeFilamentColor(FilamentColors $filamentColor): static
    {
        if ($this->filamentColors->removeElement($filamentColor)) {
            // set the owning side to null (unless already changed)
            if ($filamentColor->getCreatedBy() === $this) {
                $filamentColor->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FilamentType>
     */
    public function getFilamentTypes(): Collection
    {
        return $this->filamentTypes;
    }

    public function addFilamentType(FilamentType $filamentType): static
    {
        if (!$this->filamentTypes->contains($filamentType)) {
            $this->filamentTypes->add($filamentType);
            $filamentType->setCreatedBy($this);
        }

        return $this;
    }

    public function removeFilamentType(FilamentType $filamentType): static
    {
        if ($this->filamentTypes->removeElement($filamentType)) {
            // set the owning side to null (unless already changed)
            if ($filamentType->getCreatedBy() === $this) {
                $filamentType->setCreatedBy(null);
            }
        }

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
            $filament->setCreatedBy($this);
        }

        return $this;
    }

    public function removeFilament(Filaments $filament): static
    {
        if ($this->filaments->removeElement($filament)) {
            // set the owning side to null (unless already changed)
            if ($filament->getCreatedBy() === $this) {
                $filament->setCreatedBy(null);
            }
        }

        return $this;
    }

}
