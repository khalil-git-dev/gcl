<?php

namespace App\Entity;

use App\Repository\MaterielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MaterielRepository::class)
 */
class Materiel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $typeMat;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $libelleMat;

    /**
     * @ORM\ManyToMany(targetEntity=Salle::class, inversedBy="materiels")
     */
    private $salle;

    public function __construct()
    {
        $this->salle = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeMat(): ?string
    {
        return $this->typeMat;
    }

    public function setTypeMat(string $typeMat): self
    {
        $this->typeMat = $typeMat;

        return $this;
    }

    public function getLibelleMat(): ?string
    {
        return $this->libelleMat;
    }

    public function setLibelleMat(string $libelleMat): self
    {
        $this->libelleMat = $libelleMat;

        return $this;
    }

    /**
     * @return Collection|Salle[]
     */
    public function getSalle(): Collection
    {
        return $this->salle;
    }

    public function addSalle(Salle $salle): self
    {
        if (!$this->salle->contains($salle)) {
            $this->salle[] = $salle;
        }

        return $this;
    }

    public function removeSalle(Salle $salle): self
    {
        $this->salle->removeElement($salle);

        return $this;
    }
}
