<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Put;
use App\Controller\GetMeController;
use App\Repository\CompteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CompteRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[ApiResource(
    operations: [
        new Get(),
        new Put(
            normalizationContext: ['groups' => ['get_User']],
            denormalizationContext: ['groups' => ['set_User']],
            security: "is_granted('ROLE_USER') and object == user",
        ),
        new Patch(
            normalizationContext: ['groups' => ['get_User']],
            denormalizationContext: ['groups' => ['set_User']],
            security: "is_granted('ROLE_USER') and object == user",
        ),
        new GetCollection(
            uriTemplate: '/me',
            controller: GetMeController::class,
            openapiContext: [
                'summary' => "Renvoie les données de l'utlisateur courrant",
                'description' => "Renvoie les données de l'utilisateur courrant",
                'responses' => [
                    '200' => ['description' => 'Utilisateur connecté'],
                    '401' => ['description' => 'Utilisateur non connecté'],
                    ],
            ],
            paginationEnabled: false,
            normalizationContext: ['groups' => ['get_Me', 'get_User']],
            security: "is_granted('ROLE_USER')",
            securityMessage: "Vous n'êtes pas connecté"
        ),
    ],
    normalizationContext: ['groups' => ['get_User']],
)]
class Compte implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['get_User', 'get_Me'])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Email]
    #[Groups(['set_User', 'get_Me'])]
    private ?string $email = null;

    #[ORM\Column]
    #[Groups(['get_Me', 'get_User'])]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Groups('set_User')]
    private ?string $password = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank]
    #[Groups(['get_Me'])]
    private ?\DateTimeInterface $dateNaiss = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    #[Groups(['set_User', 'get_User'])]
    #[Assert\Regex(
        pattern: '/[<>&"]/',
        message: 'Your login cannot use this character : <>&"',
        match: false
    )]
    private ?string $login = null;

    #[ORM\Column(type: 'boolean')]
    private bool $is_verified = false;

    #[ORM\ManyToMany(targetEntity: Carte::class, mappedBy: 'compte')]
    #[Groups(['get_Me'])]
    private Collection $cartes;

    public function __construct()
    {
        $this->cartes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
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

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getDateNaiss(): ?\DateTimeInterface
    {
        return $this->dateNaiss;
    }

    public function setDateNaiss(\DateTimeInterface $dateNaiss): self
    {
        $this->dateNaiss = $dateNaiss;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Renvoie vrai si l'utilsiateur a plus de 18 ans.
     *
     * @throws \Exception
     */
    public function estMajeur(): bool
    {
        // TODO : Tester la fonction
        $now = new \DateTime();
        $ecart = $now->diff($this->dateNaiss);

        return $ecart->y >= 18;
    }

    public function isVerified(): bool
    {
        return $this->is_verified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->is_verified = $isVerified;

        return $this;
    }

    /**
     * @return Collection<int, Carte>
     */
    public function getCartes(): Collection
    {
        return $this->cartes;
    }

    public function addCarte(Carte $carte): self
    {
        if (!$this->cartes->contains($carte)) {
            $this->cartes->add($carte);
            $carte->addCompte($this);
        }

        return $this;
    }

    public function removeCarte(Carte $carte): self
    {
        if ($this->cartes->removeElement($carte)) {
            $carte->removeCompte($this);
        }

        return $this;
    }
}
