<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\PartenaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PartenaireRepository::class)]
#[ApiResource(operations: [
    new Get(
        normalizationContext: ['groups' => 'get_partenaire']
        // security: "is_granted('ROLE_USER')"
    ),
    new GetCollection(
        normalizationContext: ['groups' => 'get_partenaire']
        // security: "is_granted('ROLE_USER')"
    ),
])]
#[ApiFilter(OrderFilter::class, properties: ['nom' => 'ASC',  'prenom' => 'ASC'], arguments: ['orderParameterName' => 'order'])]
#[ApiFilter(SearchFilter::class, properties: ['nom' => 'partial'])]
class Partenaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('get_partenaire')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('get_partenaire')]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Groups('get_partenaire')]
    private ?string $prenom = null;

    #[ORM\ManyToMany(targetEntity: Vigneron::class, mappedBy: 'partenaire')]
    private Collection $vigneronsPart;

    #[ORM\ManyToOne(inversedBy: 'partenaires')]
    private ?Animation $animation = null;

    public function __construct()
    {
        $this->vigneronsPart = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * @return Collection<int, Vigneron>
     */
    public function getVigneronsPart(): Collection
    {
        return $this->vigneronsPart;
    }

    public function addVigneronsPart(Vigneron $vigneronsPart): self
    {
        if (!$this->vigneronsPart->contains($vigneronsPart)) {
            $this->vigneronsPart->add($vigneronsPart);
            $vigneronsPart->addPartenaire($this);
        }

        return $this;
    }

    public function removeVigneronsPart(Vigneron $vigneronsPart): self
    {
        if ($this->vigneronsPart->removeElement($vigneronsPart)) {
            $vigneronsPart->removePartenaire($this);
        }

        return $this;
    }

    public function getAnimation(): ?Animation
    {
        return $this->animation;
    }

    public function setAnimation(?Animation $animation): self
    {
        $this->animation = $animation;

        return $this;
    }

    #[Groups('get_partenaire')]
    public function getAnimationID(): int
    {
        return $this->animation->getId();
    }
}
