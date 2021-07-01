<?php

namespace App\Entity;

use App\Repository\RayonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RayonRepository::class)
 */
class Rayon
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
    private $titreRay;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $detailRay;

    /**
     * @ORM\ManyToOne(targetEntity=Bibliotheque::class, inversedBy="rayons")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bibliotheque;

    /**
     * @ORM\OneToMany(targetEntity=Etagere::class, mappedBy="rayon", orphanRemoval=true)
     */
    private $etageres;

    public function __construct()
    {
        $this->etageres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreRay(): ?string
    {
        return $this->titreRay;
    }

    public function setTitreRay(string $titreRay): self
    {
        $this->titreRay = $titreRay;

        return $this;
    }

    public function getDetailRay(): ?string
    {
        return $this->detailRay;
    }

    public function setDetailRay(?string $detailRay): self
    {
        $this->detailRay = $detailRay;

        return $this;
    }

    public function getBibliotheque(): ?Bibliotheque
    {
        return $this->bibliotheque;
    }

    public function setBibliotheque(?Bibliotheque $bibliotheque): self
    {
        $this->bibliotheque = $bibliotheque;

        return $this;
    }

    /**
     * @return Collection|Etagere[]
     */
    public function getEtageres(): Collection
    {
        return $this->etageres;
    }

    public function addEtagere(Etagere $etagere): self
    {
        if (!$this->etageres->contains($etagere)) {
            $this->etageres[] = $etagere;
            $etagere->setRayon($this);
        }

        return $this;
    }

    public function removeEtagere(Etagere $etagere): self
    {
        if ($this->etageres->removeElement($etagere)) {
            // set the owning side to null (unless already changed)
            if ($etagere->getRayon() === $this) {
                $etagere->setRayon(null);
            }
        }

        return $this;
    }
}
