<?php

namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ApiResource()
 * @ORM\Entity
 */
class Apport
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $typeApp;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $descriptionApp;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $montantApp;

    /**
     * @ORM\ManyToOne(targetEntity=Date::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Partenaire::class, inversedBy="apport")
     * @ORM\JoinColumn(nullable=false)
     */
    private $partenaire;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeApp(): ?string
    {
        return $this->typeApp;
    }

    public function setTypeApp(string $typeApp): self
    {
        $this->typeApp = $typeApp;

        return $this;
    }

    public function getDescriptionApp(): ?string
    {
        return $this->descriptionApp;
    }

    public function setDescriptionApp(?string $descriptionApp): self
    {
        $this->descriptionApp = $descriptionApp;

        return $this;
    }

    public function getMontantApp(): ?string
    {
        return $this->montantApp;
    }

    public function setMontantApp(string $montantApp): self
    {
        $this->montantApp = $montantApp;

        return $this;
    }

    public function getDate(): ?Date
    {
        return $this->date;
    }

    public function setDate(?Date $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPartenaire(): ?Partenaire
    {
        return $this->partenaire;
    }

    public function setPartenaire(?Partenaire $partenaire): self
    {
        $this->partenaire = $partenaire;

        return $this;
    }
}
