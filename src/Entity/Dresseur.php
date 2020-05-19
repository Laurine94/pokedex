<?php

namespace App\Entity;

use App\Repository\DresseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=DresseurRepository::class)
 */
class Dresseur implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $pieces;

    /**
     * @ORM\OneToMany(targetEntity=PokemonExistant::class, mappedBy="dresseur")
     */
    private $pokemonExistants;

    /**
     * @ORM\ManyToOne(targetEntity=PokemonType::class, inversedBy="dresseurs")
     */
    private $starter;

    public function __construct()
    {
        $this->pokemonExistants = new ArrayCollection();
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
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getPieces(): ?int
    {
        return $this->pieces;
    }

    public function setPieces(?int $pieces): self
    {
        $this->pieces = $pieces;

        return $this;
    }

    /**
     * @return Collection|PokemonExistant[]
     */
    public function getPokemonExistants(): Collection
    {
        return $this->pokemonExistants;
    }

    public function addPokemonExistant(PokemonExistant $pokemonExistant): self
    {
        if (!$this->pokemonExistants->contains($pokemonExistant)) {
            $this->pokemonExistants[] = $pokemonExistant;
            $pokemonExistant->setDresseur($this);
        }

        return $this;
    }

    public function removePokemonExistant(PokemonExistant $pokemonExistant): self
    {
        if ($this->pokemonExistants->contains($pokemonExistant)) {
            $this->pokemonExistants->removeElement($pokemonExistant);
            // set the owning side to null (unless already changed)
            if ($pokemonExistant->getDresseur() === $this) {
                $pokemonExistant->setDresseur(null);
            }
        }

        return $this;
    }

    public function getStarter(): ?PokemonType
    {
        return $this->starter;
    }

    public function setStarter(?PokemonType $starter): self
    {
        $this->starter = $starter;

        return $this;
    }
}
