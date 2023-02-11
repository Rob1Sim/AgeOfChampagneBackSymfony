<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: Vigneron::class)]
    private Collection $vigneronsProd;

    public function __construct()
    {
        $this->vigneronsProd = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * @return Collection<int, Vigneron>
     */
    public function getVigneronsProd(): Collection
    {
        return $this->vigneronsProd;
    }

    public function addVigneronsProd(Vigneron $vigneronsProd): self
    {
        if (!$this->vigneronsProd->contains($vigneronsProd)) {
            $this->vigneronsProd->add($vigneronsProd);
            $vigneronsProd->setProduit($this);
        }

        return $this;
    }

    public function removeVigneronsProd(Vigneron $vigneronsProd): self
    {
        if ($this->vigneronsProd->removeElement($vigneronsProd)) {
            // set the owning side to null (unless already changed)
            if ($vigneronsProd->getProduit() === $this) {
                $vigneronsProd->setProduit(null);
            }
        }

        return $this;
    }
}
