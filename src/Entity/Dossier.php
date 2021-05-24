<?php

namespace App\Entity;

use App\Repository\DossierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DossierRepository::class)
 */
class Dossier
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
    private $libelleDos;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $typeDos;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $detailDos;

    /**
     * @ORM\ManyToOne(targetEntity=Date::class, inversedBy="dossiers")
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity=Bulletin::class, mappedBy="dossier", orphanRemoval=true)
     */
    private $bulletins;
    
    /**
     * @ORM\OneToMany(targetEntity=Inscription::class, mappedBy="dossier")
     */
    private $inscriptions;

    /**
     * @ORM\ManyToOne(targetEntity=Eleve::class, inversedBy="dossiers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $eleve;

    public function __construct()
    {
        $this->bulletins = new ArrayCollection();
        $this->inscriptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleDos(): ?string
    {
        return $this->libelleDos;
    }

    public function setLibelleDos(string $libelleDos): self
    {
        $this->libelleDos = $libelleDos;

        return $this;
    }

    public function getTypeDos(): ?string
    {
        return $this->typeDos;
    }

    public function setTypeDos(string $typeDos): self
    {
        $this->typeDos = $typeDos;

        return $this;
    }

    public function getDetailDos(): ?string
    {
        return $this->detailDos;
    }

    public function setDetailDos(?string $detailDos): self
    {
        $this->detailDos = $detailDos;

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
     * @return Collection|Bulletin[]
     */
    public function getBulletins(): Collection
    {
        return $this->bulletins;
    }

    public function addBulletin(Bulletin $bulletin): self
    {
        if (!$this->bulletins->contains($bulletin)) {
            $this->bulletins[] = $bulletin;
            $bulletin->setDossier($this);
        }

        return $this;
    }

    public function removeBulletin(Bulletin $bulletin): self
    {
        if ($this->bulletins->removeElement($bulletin)) {
            // set the owning side to null (unless already changed)
            if ($bulletin->getDossier() === $this) {
                $bulletin->setDossier(null);
            }
        }

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
            $inscription->setDossier($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): self
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getDossier() === $this) {
                $inscription->setDossier(null);
            }
        }

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
