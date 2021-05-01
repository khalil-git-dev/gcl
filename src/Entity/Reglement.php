<?php

namespace App\Entity;

use App\Repository\ReglementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReglementRepository::class)
 */
class Reglement
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
    private $libelleReg;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $detailReg;

    /**
     * @ORM\ManyToOne(targetEntity=Facture::class, inversedBy="reglements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $facture;

    /**
     * @ORM\OneToMany(targetEntity=Recu::class, mappedBy="reglement")
     */
    private $recus;

    public function __construct()
    {
        $this->recus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleReg(): ?string
    {
        return $this->libelleReg;
    }

    public function setLibelleReg(string $libelleReg): self
    {
        $this->libelleReg = $libelleReg;

        return $this;
    }

    public function getDetailReg(): ?string
    {
        return $this->detailReg;
    }

    public function setDetailReg(?string $detailReg): self
    {
        $this->detailReg = $detailReg;

        return $this;
    }

    public function getFacture(): ?Facture
    {
        return $this->facture;
    }

    public function setFacture(?Facture $facture): self
    {
        $this->facture = $facture;

        return $this;
    }

    /**
     * @return Collection|Recu[]
     */
    public function getRecus(): Collection
    {
        return $this->recus;
    }

    public function addRecu(Recu $recu): self
    {
        if (!$this->recus->contains($recu)) {
            $this->recus[] = $recu;
            $recu->setReglement($this);
        }

        return $this;
    }

    public function removeRecu(Recu $recu): self
    {
        if ($this->recus->removeElement($recu)) {
            // set the owning side to null (unless already changed)
            if ($recu->getReglement() === $this) {
                $recu->setReglement(null);
            }
        }

        return $this;
    }
}
