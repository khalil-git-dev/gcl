<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MaintenancierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=MaintenancierRepository::class)
 */
class Maintenancier
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
    private $nomMaint;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $typeMain;

    /**
     * @ORM\ManyToMany(targetEntity=Salle::class, inversedBy="maintenanciers")
     */
    private $entretenir;

    public function __construct()
    {
        $this->entretenir = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomMaint(): ?string
    {
        return $this->nomMaint;
    }

    public function setNomMaint(string $nomMaint): self
    {
        $this->nomMaint = $nomMaint;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTypeMain(): ?string
    {
        return $this->typeMain;
    }

    public function setTypeMain(string $typeMain): self
    {
        $this->typeMain = $typeMain;

        return $this;
    }

    /**
     * @return Collection|Salle[]
     */
    public function getEntretenir(): Collection
    {
        return $this->entretenir;
    }

    public function addEntretenir(Salle $entretenir): self
    {
        if (!$this->entretenir->contains($entretenir)) {
            $this->entretenir[] = $entretenir;
        }

        return $this;
    }

    public function removeEntretenir(Salle $entretenir): self
    {
        $this->entretenir->removeElement($entretenir);

        return $this;
    }
}
