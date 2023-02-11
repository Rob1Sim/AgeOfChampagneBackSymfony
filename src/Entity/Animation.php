<?php

namespace App\Entity;

use App\Repository\AnimationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimationRepository::class)]
class Animation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $horaireDeb = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $horaireFin = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\ManyToMany(targetEntity: Vigneron::class, mappedBy: 'animation')]
    private Collection $vigneronsAnim;

    #[ORM\OneToMany(mappedBy: 'animation', targetEntity: Partenaire::class)]
    private Collection $partenaires;

    #[ORM\Column(length: 255)]
    private ?string $contenuImage = null;

    public function __construct()
    {
        $this->vigneronsAnim = new ArrayCollection();
        $this->partenaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getHoraireDeb(): ?\DateTimeInterface
    {
        return $this->horaireDeb;
    }

    public function setHoraireDeb(\DateTimeInterface $horaireDeb): self
    {
        $this->horaireDeb = $horaireDeb;

        return $this;
    }

    public function getHoraireFin(): ?\DateTimeInterface
    {
        return $this->horaireFin;
    }

    public function setHoraireFin(\DateTimeInterface $horaireFin): self
    {
        $this->horaireFin = $horaireFin;

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
    public function getVigneronsAnim(): Collection
    {
        return $this->vigneronsAnim;
    }

    public function addVigneronsAnim(Vigneron $vigneronsAnim): self
    {
        if (!$this->vigneronsAnim->contains($vigneronsAnim)) {
            $this->vigneronsAnim->add($vigneronsAnim);
            $vigneronsAnim->addAnimation($this);
        }

        return $this;
    }

    public function removeVigneronsAnim(Vigneron $vigneronsAnim): self
    {
        if ($this->vigneronsAnim->removeElement($vigneronsAnim)) {
            $vigneronsAnim->removeAnimation($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Partenaire>
     */
    public function getPartenaires(): Collection
    {
        return $this->partenaires;
    }

    public function addPartenaire(Partenaire $partenaire): self
    {
        if (!$this->partenaires->contains($partenaire)) {
            $this->partenaires->add($partenaire);
            $partenaire->setAnimation($this);
        }

        return $this;
    }

    public function removePartenaire(Partenaire $partenaire): self
    {
        if ($this->partenaires->removeElement($partenaire)) {
            // set the owning side to null (unless already changed)
            if ($partenaire->getAnimation() === $this) {
                $partenaire->setAnimation(null);
            }
        }

        return $this;
    }

    public function getContenuImage(): ?string
    {
        return $this->contenuImage;
    }

    public function setContenuImage(string $contenuImage): self
    {
        $this->contenuImage = $contenuImage;

        return $this;
    }
}
