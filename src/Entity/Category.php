<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Carte::class)]
    private Collection $Cartes;

    public function __construct()
    {
        $this->Cartes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Carte>
     */
    public function getCartes(): Collection
    {
        return $this->Cartes;
    }

    public function addCarte(Carte $carte): self
    {
        if (!$this->Cartes->contains($carte)) {
            $this->Cartes->add($carte);
            $carte->setCategory($this);
        }

        return $this;
    }

    public function removeCarte(Carte $carte): self
    {
        if ($this->Cartes->removeElement($carte)) {
            // set the owning side to null (unless already changed)
            if ($carte->getCategory() === $this) {
                $carte->setCategory(null);
            }
        }

        return $this;
    }
}
