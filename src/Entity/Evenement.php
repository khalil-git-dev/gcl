<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EvenementRepository::class)
 */
class Evenement
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
    private $typeEven;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $libelleEven;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descriptionEven;

    /**
     * @ORM\ManyToOne(targetEntity=Date::class, inversedBy="evenements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeEven(): ?string
    {
        return $this->typeEven;
    }

    public function setTypeEven(string $typeEven): self
    {
        $this->typeEven = $typeEven;

        return $this;
    }

    public function getLibelleEven(): ?string
    {
        return $this->libelleEven;
    }

    public function setLibelleEven(string $libelleEven): self
    {
        $this->libelleEven = $libelleEven;

        return $this;
    }

    public function getDescriptionEven(): ?string
    {
        return $this->descriptionEven;
    }

    public function setDescriptionEven(?string $descriptionEven): self
    {
        $this->descriptionEven = $descriptionEven;

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
}
