<?php

namespace App\Entity;

use App\Repository\RecuRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RecuRepository::class)
 */
class Recu
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $libelleRec;

    /**
     * @ORM\Column(type="float")
     */
    private $montantRec;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $detailRec;

    /**
     * @ORM\ManyToOne(targetEntity=Reglement::class, inversedBy="recus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $reglement;

    /**
     * @ORM\ManyToOne(targetEntity=Eleve::class, inversedBy="recus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $eleve;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleRec(): ?string
    {
        return $this->libelleRec;
    }

    public function setLibelleRec(string $libelleRec): self
    {
        $this->libelleRec = $libelleRec;

        return $this;
    }

    public function getMontantRec(): ?float
    {
        return $this->montantRec;
    }

    public function setMontantRec(float $montantRec): self
    {
        $this->montantRec = $montantRec;

        return $this;
    }

    public function getDetailRec(): ?string
    {
        return $this->detailRec;
    }

    public function setDetailRec(?string $detailRec): self
    {
        $this->detailRec = $detailRec;

        return $this;
    }

    public function getReglement(): ?Reglement
    {
        return $this->reglement;
    }

    public function setReglement(?Reglement $reglement): self
    {
        $this->reglement = $reglement;

        return $this;
    }

    public function getEleve(): ?Eleve
    {
        return $this->eleve;
    }

    public function setEleve(?Eleve $eleve): self
    {
        $this->eleve = $eleve;

        return $this;
    }
}
