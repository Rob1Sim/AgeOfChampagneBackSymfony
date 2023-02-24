<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Controller\GetCarteImageController;
use App\Repository\CarteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CarteRepository::class)]
#[ApiResource(operations: [
    new Get(
        normalizationContext: ['groups' => 'get_carte']
        // security: "is_granted('ROLE_USER')"
    ),
    new GetCollection(
        normalizationContext: ['groups' => 'get_carte']
        // security: "is_granted('ROLE_USER')"
    ),
    new Get(
        uriTemplate: 'cartes/{id}/image',
        controller: GetCarteImageController::class,
        // security: "is_granted('ROLE_USER')"
    ),
])]
#[ApiFilter(SearchFilter::class, properties: ['nom' => 'partial'])]
#[ApiFilter(OrderFilter::class, properties: ['nom' => 'ASC',  'type' => 'ASC'], arguments: ['orderParameterName' => 'order'])]
class Carte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('get_carte')]
    private ?int $id = null;

    #[Groups('get_carte')]
    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[Groups('get_carte')]
    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[Groups('get_carte')]
    #[ORM\Column(length: 255)]
    private ?string $region = null;
    #[Groups('get_carte')]
    #[ORM\Column]
    private ?float $latitude = null;
    #[Groups('get_carte')]
    #[ORM\Column]
    private ?float $longitude = null;
    #[Groups('get_carte')]
    #[ORM\Column]
    private ?float $superficie = null;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cru = null;
    #[Groups('get_carte')]
    #[ORM\Column(length: 255)]
    private ?string $contenuImage = null;

    #[ORM\ManyToOne(inversedBy: 'cartes')]
    private ?Vigneron $vignerons = null;

    #[ORM\ManyToMany(targetEntity: Compte::class, inversedBy: 'cartes')]
    private Collection $compte;

    public function __construct()
    {
        $this->compte = new ArrayCollection();
    }
    #[ORM\ManyToOne(inversedBy: 'Cartes')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Category $category = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('get_carte')]
    private ?Cru $cru_r = null;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCru(): ?string
    {
        return $this->cru;
    }

    public function setCru(string $cru): self
    {
        $this->cru = $cru;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getSuperficie(): ?float
    {
        return $this->superficie;
    }

    public function setSuperficie(float $superficie): self
    {
        $this->superficie = $superficie;

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

    public function getVignerons(): ?Vigneron
    {
        return $this->vignerons;
    }

    public function setVignerons(?Vigneron $vignerons): self
    {
        $this->vignerons = $vignerons;

        return $this;
    }

    /**
     * @return Collection<int, Compte>
     */
    public function getCompte(): Collection
    {
        return $this->compte;
    }

    public function addCompte(Compte $compte): self
    {
        if (!$this->compte->contains($compte)) {
            $this->compte->add($compte);
        }

        return $this;
    }

    public function removeCompte(Compte $compte): self
    {
        $this->compte->removeElement($compte);
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getCruR(): ?Cru
    {
        return $this->cru_r;
    }

    public function setCruR(?Cru $cru_r): self
    {
        $this->cru_r = $cru_r;

        return $this;
    }

    #[Groups('get_carte')]
    public function getVigneronID(): int
    {
        return $this->vignerons->getId();
    }
}
