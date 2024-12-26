<?php

namespace App\Entity;

use App\Repository\MatieresRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatieresRepository::class)]
class Matieres
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_matiere = null;

    #[ORM\Column]
    private ?int $duree_minute = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomMatiere(): ?string
    {
        return $this->nom_matiere;
    }

    public function setNomMatiere(string $nom_matiere): static
    {
        $this->nom_matiere = $nom_matiere;

        return $this;
    }

    public function getDureeMinute(): ?int
    {
        return $this->duree_minute;
    }

    public function setDureeMinute(int $duree_minute): static
    {
        $this->duree_minute = $duree_minute;

        return $this;
    }


}
