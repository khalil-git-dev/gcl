<?php

namespace App\Entity;

use App\Repository\FactureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FactureRepository::class)
 */
class Facture
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
    private $libelleFac;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $articleFac;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $quantiteFac;

    /**
     * @ORM\Column(type="float")
     */
    private $puFac;

    /**
     * @ORM\Column(type="float")
     */
    private $montantFac;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $typeFac;

    /**
     * @ORM\ManyToOne(targetEntity=Date::class, inversedBy="factures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Inscription::class, inversedBy="factures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $inscription;

    /**
     * @ORM\OneToMany(targetEntity=Reglement::class, mappedBy="facture")
     */
    private $reglements;

    public function __construct()
    {
        $this->reglements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleFac(): ?string
    {
        return $this->libelleFac;
    }

    public function setLibelleFac(string $libelleFac): self
    {
        $this->libelleFac = $libelleFac;

        return $this;
    }

    public function getArticleFac(): ?string
    {
        return $this->articleFac;
    }

    public function setArticleFac(string $articleFac): self
    {
        $this->articleFac = $articleFac;

        return $this;
    }

    public function getQuantiteFac(): ?float
    {
        return $this->quantiteFac;
    }

    public function setQuantiteFac(?float $quantiteFac): self
    {
        $this->quantiteFac = $quantiteFac;

        return $this;
    }

    public function getPuFac(): ?float
    {
        return $this->puFac;
    }

    public function setPuFac(float $puFac): self
    {
        $this->puFac = $puFac;

        return $this;
    }

    public function getMontantFac(): ?float
    {
        return $this->montantFac;
    }

    public function setMontantFac(float $montantFac): self
    {
        $this->montantFac = $montantFac;

        return $this;
    }

    public function getTypeFac(): ?string
    {
        return $this->typeFac;
    }

    public function setTypeFac(string $typeFac): self
    {
        $this->typeFac = $typeFac;

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

    public function getInscription(): ?Inscription
    {
        return $this->inscription;
    }

    public function setInscription(?Inscription $inscription): self
    {
        $this->inscription = $inscription;

        return $this;
    }

    /**
     * @return Collection|Reglement[]
     */
    public function getReglements(): Collection
    {
        return $this->reglements;
    }

    public function addReglement(Reglement $reglement): self
    {
        if (!$this->reglements->contains($reglement)) {
            $this->reglements[] = $reglement;
            $reglement->setFacture($this);
        }

        return $this;
    }

    public function removeReglement(Reglement $reglement): self
    {
        if ($this->reglements->removeElement($reglement)) {
            // set the owning side to null (unless already changed)
            if ($reglement->getFacture() === $this) {
                $reglement->setFacture(null);
            }
        }

        return $this;
    }
}
