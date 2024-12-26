<?php

namespace App\Entity;

use App\Repository\EnseignantsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnseignantsRepository::class)]
class Enseignants
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_enseigant = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom_enseignant = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEnseigant(): ?string
    {
        return $this->nom_enseigant;
    }

    public function setNomEnseigant(string $nom_enseigant): static
    {
        $this->nom_enseigant = $nom_enseigant;

        return $this;
    }

    public function getPrenomEnseignant(): ?string
    {
        return $this->prenom_enseignant;
    }

    public function setPrenomEnseignant(string $prenom_enseignant): static
    {
        $this->prenom_enseignant = $prenom_enseignant;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }
}
