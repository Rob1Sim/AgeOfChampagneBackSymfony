<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\CruRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CruRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            normalizationContext: ['groups' => ['get_Cru']]
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['get_Cru']]
        ),
    ]
)]
#[ApiFilter(OrderFilter::class, properties: ['libelle' => 'ASC'], arguments: ['orderParameterName' => 'order'])]
#[ApiFilter(SearchFilter::class, properties: ['libelle' => 'partial', 'infos' => 'partial'])]
class Cru
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column(length: 255)]
    #[Groups('get_Cru')]
    private ?string $horaire = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    #[Groups('get_Cru')]
    private $image = null;

    #[ORM\Column(length: 255)]
    #[Groups('get_Cru')]
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
