<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
class Menu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $icon = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $route = null;

    #[ORM\Column(length: 255)]
    private ?string $menutype = null;

    #[ORM\Column(length: 255)]
    private ?string $menugroup = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?int $menuorder = null;

    #[ORM\Column(type: 'boolean')]
    private bool $publicAccess = false;

    #[ORM\Column(type: 'boolean')]
    private bool $hiddenMenu = false;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'menuchildren')]
    private ?self $menuparent = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'menuparent')]
    private Collection $menuchildren;

    public function __construct()
    {
        $this->menuchildren = new ArrayCollection();
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

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function getRoute(): ?string
    {
        return $this->route;
    }

    public function setRoute(?string $route): static
    {
        $this->route = $route;

        return $this;
    }

    public function getMenutype(): ?string
    {
        return $this->menutype;
    }

    public function setMenutype(string $menutype): static
    {
        $this->menutype = $menutype;

        return $this;
    }

    public function getMenugroup(): ?string
    {
        return $this->menugroup;
    }

    public function setMenugroup(string $menugroup): static
    {
        $this->menugroup = $menugroup;

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getMenuorder(): ?int
    {
        return $this->menuorder;
    }

    public function setMenuorder(int $menuorder): static
    {
        $this->menuorder = $menuorder;

        return $this;
    }

    public function getMenuparent(): ?self
    {
        return $this->menuparent;
    }

    public function setMenuparent(?self $menuparent): static
    {
        $this->menuparent = $menuparent;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getChildren(): Collection
    {
        return $this->menuchildren;
    }

    public function addChild(self $child): static
    {
        if (!$this->menuchildren->contains($child)) {
            $this->menuchildren->add($child);
            $child->setMenuparent($this);
        }

        return $this;
    }

    public function removeChild(self $child): static
    {
        if ($this->menuchildren->removeElement($child)) {
            // set the owning side to null (unless already changed)
            if ($child->getMenuparent() === $this) {
                $child->setMenuparent(null);
            }
        }

        return $this;
    }

    public function getPublicAccess(): bool
    {
        return $this->publicAccess;
    }

    public function setPublicAccess(bool $publicAccess): self
    {
        $this->publicAccess = $publicAccess;
        return $this;
    }

    public function getHiddenMenu(): bool
    {
        return $this->hiddenMenu;
    }

    public function setHiddenMenu(bool $hiddenMenu): self
    {
        $this->hiddenMenu = $hiddenMenu;
        return $this;
    }
}
