<?php

namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity
 */
class Partenaire
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
    private $typePart;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nomPar;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $prenomPar;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $categoriePar;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $adressePar;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $telPar;

    /**
     * @ORM\OneToMany(targetEntity=Apport::class, mappedBy="partenaire", orphanRemoval=true, cascade={"persist"})
     * @ApiSubresource
     */
    private $apport;

    public function __construct()
    {
        $this->apport = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypePart(): ?string
    {
        return $this->typePart;
    }

    public function setTypePart(string $typePart): self
    {
        $this->typePart = $typePart;

        return $this;
    }

    public function getNomPar(): ?string
    {
        return $this->nomPar;
    }

    public function setNomPar(string $nomPar): self
    {
        $this->nomPar = $nomPar;

        return $this;
    }

    public function getPrenomPar(): ?string
    {
        return $this->prenomPar;
    }

    public function setPrenomPar(string $prenomPar): self
    {
        $this->prenomPar = $prenomPar;

        return $this;
    }

    public function getCategoriePar(): ?string
    {
        return $this->categoriePar;
    }

    public function setCategoriePar(string $categoriePar): self
    {
        $this->categoriePar = $categoriePar;

        return $this;
    }

    public function getAdressePar(): ?string
    {
        return $this->adressePar;
    }

    public function setAdressePar(?string $adressePar): self
    {
        $this->adressePar = $adressePar;

        return $this;
    }

    public function getTelPar(): ?string
    {
        return $this->telPar;
    }

    public function setTelPar(string $telPar): self
    {
        $this->telPar = $telPar;

        return $this;
    }

    /**
     * @return Collection|Apport[]
     */
    public function getApport(): Collection
    {
        return $this->apport;
    }

    public function addApport(Apport $apport): self
    {
        if (!$this->apport->contains($apport)) {
            $this->apport[] = $apport;
            $apport->setPartenaire($this);
        }

        return $this;
    }

    public function removeApport(Apport $apport): self
    {
        if ($this->apport->removeElement($apport)) {
            // set the owning side to null (unless already changed)
            if ($apport->getPartenaire() === $this) {
                $apport->setPartenaire(null);
            }
        }

        return $this;
    }
}
