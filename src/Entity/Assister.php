<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AssisterRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=AssisterRepository::class)
 */
class Assister
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Cours::class, inversedBy="assisters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cours;

    /**
     * @ORM\ManyToOne(targetEntity=Eleve::class, inversedBy="assisters")
     */
    private $eleve;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $minutesRetard;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCours(): ?Cours
    {
        return $this->cours;
    }

    public function setCours(?Cours $cours): self
    {
        $this->cours = $cours;

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

    public function getMinutesRetard(): ?float
    {
        return $this->minutesRetard;
    }

    public function setMinutesRetard(?float $minutesRetard): self
    {
        $this->minutesRetard = $minutesRetard;

        return $this;
    }
}
