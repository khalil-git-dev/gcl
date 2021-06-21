<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ActiviteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ActiviteRepository::class)
 */
class Activite
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
    private $libelleAct;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $natureAct;

    /**
     * @ORM\Column(type="string", length=75)
     */
    private $typeAct;

    /**
     * @ORM\ManyToMany(targetEntity=Inscription::class, mappedBy="activite")
     */
    private $inscriptions;

    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleAct(): ?string
    {
        return $this->libelleAct;
    }

    public function setLibelleAct(string $libelleAct): self
    {
        $this->libelleAct = $libelleAct;

        return $this;
    }

    public function getNatureAct(): ?string
    {
        return $this->natureAct;
    }

    public function setNatureAct(string $natureAct): self
    {
        $this->natureAct = $natureAct;

        return $this;
    }

    public function getTypeAct(): ?string
    {
        return $this->typeAct;
    }

    public function setTypeAct(string $typeAct): self
    {
        $this->typeAct = $typeAct;

        return $this;
    }

    /**
     * @return Collection|Inscription[]
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addInscription(Inscription $inscription): self
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions[] = $inscription;
            $inscription->addActivite($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): self
    {
        if ($this->inscriptions->removeElement($inscription)) {
            $inscription->removeActivite($this);
        }

        return $this;
    }
}
