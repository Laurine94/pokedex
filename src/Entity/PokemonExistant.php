<?php

namespace App\Entity;

use App\Repository\PokemonExistantRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PokemonExistantRepository::class)
 */
class PokemonExistant 
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $sexe;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $xp;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $niveau;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity=PokemonType::class, inversedBy="pokemonExistants")
     */
    private $pokemonType;

    /**
     * @ORM\ManyToOne(targetEntity=Dresseur::class, inversedBy="pokemonExistants")
     */
    private $dresseur;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dernierEntrainement;

    public function __construct($pokemonType,$dresseur){
            $this->xp=1;
            $this->prix=0;
            $this->niveau=0;
            $this->sexe="Male";
            $this->pokemonType=$pokemonType;
            $this->dresseur=$dresseur;


    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(?string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getXp(): ?int
    {
        return $this->xp;
    }

    public function setXp(?int $xp): self
    {
        $this->xp = $xp;

        return $this;
    }

    public function getNiveau(): ?int
    {
        return $this->niveau;
    }

    public function setNiveau(?int $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(?int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getPokemonType(): ?PokemonType
    {
        return $this->pokemonType;
    }

    public function setPokemonType(?PokemonType $pokemonType): self
    {
        $this->pokemonType = $pokemonType;

        return $this;
    }

    public function getDresseur(): ?Dresseur
    {
        return $this->dresseur;
    }

    public function setDresseur(?Dresseur $dresseur): self
    {
        $this->dresseur = $dresseur;

        return $this;
    }

    public function getDernierEntrainement(): ?\DateTimeInterface
    {
        return $this->dernierEntrainement;
    }

    public function setDernierEntrainement(?\DateTimeInterface $dernierEntrainement): self
    {
        $this->dernierEntrainement = $dernierEntrainement;

        return $this;
    }
}
