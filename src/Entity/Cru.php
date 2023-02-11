<?php

namespace App\Entity;

use App\Repository\CruRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CruRepository::class)]
class Cru
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column(length: 255)]
    private ?string $horaire = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $image = null;

    #[ORM\Column(length: 255)]
    private ?string $infos = null;

    #[ORM\OneToMany(mappedBy: 'cru', targetEntity: Vigneron::class)]
    private Collection $vigneronsCru;

    public function __construct()
    {
        $this->vigneronsCru = new ArrayCollection();
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

    public function getHoraire(): ?string
    {
        return $this->horaire;
    }

    public function setHoraire(string $horaire): self
    {
        $this->horaire = $horaire;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getInfos(): ?string
    {
        return $this->infos;
    }

    public function setInfos(string $infos): self
    {
        $this->infos = $infos;

        return $this;
    }

    /**
     * @return Collection<int, Vigneron>
     */
    public function getVigneronsCru(): Collection
    {
        return $this->vigneronsCru;
    }

    public function addVigneronsCru(Vigneron $vigneronsCru): self
    {
        if (!$this->vigneronsCru->contains($vigneronsCru)) {
            $this->vigneronsCru->add($vigneronsCru);
            $vigneronsCru->setCru($this);
        }

        return $this;
    }

    public function removeVigneronsCru(Vigneron $vigneronsCru): self
    {
        if ($this->vigneronsCru->removeElement($vigneronsCru)) {
            // set the owning side to null (unless already changed)
            if ($vigneronsCru->getCru() === $this) {
                $vigneronsCru->setCru(null);
            }
        }

        return $this;
    }
}
