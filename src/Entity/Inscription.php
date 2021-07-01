<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\InscriptionRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=InscriptionRepository::class)
 */
class Inscription
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
    private $libelleIns;

    /**
     * @ORM\Column(type="float")
     */
    private $redevanceIns;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $categorieIns;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $typeIns;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $detailIns;

    /**
     * @ORM\ManyToOne(targetEntity=Date::class, inversedBy="inscriptions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $date;

    /**
     * @ORM\ManyToMany(targetEntity=Activite::class, inversedBy="inscriptions")
     */
    private $activite;

    /**
     * @ORM\ManyToOne(targetEntity=Dossier::class, inversedBy="inscriptions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dossier;

    /**
     * @ORM\OneToMany(targetEntity=Facture::class, mappedBy="inscription")
     */
    private $factures;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $statusIns;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $numeroIns;

    public function __construct()
    {
        $this->activite = new ArrayCollection();
        $this->factures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleIns(): ?string
    {
        return $this->libelleIns;
    }

    public function setLibelleIns(string $libelleIns): self
    {
        $this->libelleIns = $libelleIns;

        return $this;
    }

    public function getRedevanceIns(): ?float
    {
        return $this->redevanceIns;
    }

    public function setRedevanceIns(float $redevanceIns): self
    {
        $this->redevanceIns = $redevanceIns;

        return $this;
    }

    public function getCategorieIns(): ?string
    {
        return $this->categorieIns;
    }

    public function setCategorieIns(string $categorieIns): self
    {
        $this->categorieIns = $categorieIns;

        return $this;
    }

    public function getTypeIns(): ?string
    {
        return $this->typeIns;
    }

    public function setTypeIns(string $typeIns): self
    {
        $this->typeIns = $typeIns;

        return $this;
    }

    public function getDetailIns(): ?string
    {
        return $this->detailIns;
    }

    public function setDetailIns(?string $detailIns): self
    {
        $this->detailIns = $detailIns;

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

    /**
     * @return Collection|Activite[]
     */
    public function getActivite(): Collection
    {
        return $this->activite;
    }

    public function addActivite(Activite $activite): self
    {
        if (!$this->activite->contains($activite)) {
            $this->activite[] = $activite;
        }

        return $this;
    }

    public function removeActivite(Activite $activite): self
    {
        $this->activite->removeElement($activite);

        return $this;
    }

    public function getDossier(): ?Dossier
    {
        return $this->dossier;
    }

    public function setDossier(?Dossier $dossier): self
    {
        $this->dossier = $dossier;

        return $this;
    }

    /**
     * @return Collection|Facture[]
     */
    public function getFactures(): Collection
    {
        return $this->factures;
    }

    public function addFacture(Facture $facture): self
    {
        if (!$this->factures->contains($facture)) {
            $this->factures[] = $facture;
            $facture->setInscription($this);
        }

        return $this;
    }

    public function removeFacture(Facture $facture): self
    {
        if ($this->factures->removeElement($facture)) {
            // set the owning side to null (unless already changed)
            if ($facture->getInscription() === $this) {
                $facture->setInscription(null);
            }
        }

        return $this;
    }

    public function getStatusIns(): ?string
    {
        return $this->statusIns;
    }

    public function setStatusIns(string $statusIns): self
    {
        $this->statusIns = $statusIns;

        return $this;
    }

    public function getNumeroIns(): ?string
    {
        return $this->numeroIns;
    }

    public function setNumeroIns(string $numeroIns): self
    {
        $this->numeroIns = $numeroIns;

        return $this;
    }
}
