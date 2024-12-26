<?php

namespace App\Entity;

use App\Repository\PromotionsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PromotionsRepository::class)]
class Promotions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $niveau_promotion = null;

    #[ORM\Column(length: 255)]
    private ?string $intitule_formation = null;

    #[ORM\Column]
    private ?int $nb_etudiants = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNiveauPromotion(): ?string
    {
        return $this->niveau_promotion;
    }

    public function setNiveauPromotion(string $niveau_promotion): static
    {
        $this->niveau_promotion = $niveau_promotion;

        return $this;
    }

    public function getIntituleFormation(): ?string
    {
        return $this->intitule_formation;
    }

    public function setIntituleFormation(string $intitule_formation): static
    {
        $this->intitule_formation = $intitule_formation;

        return $this;
    }

    public function getNbEtudiants(): ?int
    {
        return $this->nb_etudiants;
    }

    public function setNbEtudiants(int $nb_etudiants): static
    {
        $this->nb_etudiants = $nb_etudiants;

        return $this;
    }
}
