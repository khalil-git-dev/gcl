<?php

namespace App\Entity;

use App\Repository\SalleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=SalleRepository::class)
 */
class Salle
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
    private $codeSal;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $libelleSal;

    /**
     * @ORM\ManyToMany(targetEntity=Materiel::class, mappedBy="salle")
     */
    private $materiels;

    /**
     * @ORM\ManyToMany(targetEntity=Maintenancier::class, mappedBy="entretenir")
     */
    private $maintenanciers;

    /**
     * @ORM\OneToMany(targetEntity=Cours::class, mappedBy="salle")
     */
    private $cours;

    public function __construct()
    {
        $this->materiels = new ArrayCollection();
        $this->maintenanciers = new ArrayCollection();
        $this->cours = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeSal(): ?string
    {
        return $this->codeSal;
    }

    public function setCodeSal(string $codeSal): self
    {
        $this->codeSal = $codeSal;

        return $this;
    }

    public function getLibelleSal(): ?string
    {
        return $this->libelleSal;
    }

    public function setLibelleSal(string $libelleSal): self
    {
        $this->libelleSal = $libelleSal;

        return $this;
    }

    /**
     * @return Collection|Materiel[]
     */
    public function getMateriels(): Collection
    {
        return $this->materiels;
    }

    public function addMateriel(Materiel $materiel): self
    {
        if (!$this->materiels->contains($materiel)) {
            $this->materiels[] = $materiel;
            $materiel->addSalle($this);
        }

        return $this;
    }

    public function removeMateriel(Materiel $materiel): self
    {
        if ($this->materiels->removeElement($materiel)) {
            $materiel->removeSalle($this);
        }

        return $this;
    }

    /**
     * @return Collection|Maintenancier[]
     */
    public function getMaintenanciers(): Collection
    {
        return $this->maintenanciers;
    }

    public function addMaintenancier(Maintenancier $maintenancier): self
    {
        if (!$this->maintenanciers->contains($maintenancier)) {
            $this->maintenanciers[] = $maintenancier;
            $maintenancier->addEntretenir($this);
        }

        return $this;
    }

    public function removeMaintenancier(Maintenancier $maintenancier): self
    {
        if ($this->maintenanciers->removeElement($maintenancier)) {
            $maintenancier->removeEntretenir($this);
        }

        return $this;
    }

    /**
     * @return Collection|Cours[]
     */
    public function getCours(): Collection
    {
        return $this->cours;
    }

    public function addCour(Cours $cour): self
    {
        if (!$this->cours->contains($cour)) {
            $this->cours[] = $cour;
            $cour->setSalle($this);
        }

        return $this;
    }

    public function removeCour(Cours $cour): self
    {
        if ($this->cours->removeElement($cour)) {
            // set the owning side to null (unless already changed)
            if ($cour->getSalle() === $this) {
                $cour->setSalle(null);
            }
        }

        return $this;
    }
}
