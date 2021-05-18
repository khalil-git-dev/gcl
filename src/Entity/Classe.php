<?php

namespace App\Entity;

use App\Repository\ClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ClasseRepository::class)
 */
class Classe
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
    private $libelleCl;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descriptionCl;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbMaxEleve;

    /**
     * @ORM\ManyToOne(targetEntity=Serie::class, inversedBy="classes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $serie;

    /**
     * @ORM\ManyToMany(targetEntity=Surveillant::class, mappedBy="classe")
     */
    private $surveillants;

    /**
     * @ORM\OneToMany(targetEntity=Eleve::class, mappedBy="classe")
     */
    private $eleve;

    /**
     * @ORM\ManyToMany(targetEntity=Cours::class, mappedBy="classe")
     */
    private $cours;

    /**
     * @ORM\ManyToOne(targetEntity=Niveau::class, inversedBy="classe")
     * @ORM\JoinColumn(nullable=false)
     */
    private $niveau;

    public function __construct()
    {
        $this->surveillants = new ArrayCollection();
        $this->eleve = new ArrayCollection();
        $this->cours = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleCl(): ?string
    {
        return $this->libelleCl;
    }

    public function setLibelleCl(string $libelleCl): self
    {
        $this->libelleCl = $libelleCl;

        return $this;
    }

    public function getDescriptionCl(): ?string
    {
        return $this->descriptionCl;
    }

    public function setDescriptionCl(string $descriptionCl): self
    {
        $this->descriptionCl = $descriptionCl;

        return $this;
    }

    public function getNbMaxEleve(): ?int
    {
        return $this->nbMaxEleve;
    }

    public function setNbMaxEleve(int $nbMaxEleve): self
    {
        $this->nbMaxEleve = $nbMaxEleve;

        return $this;
    }

    public function getSerie(): ?Serie
    {
        return $this->serie;
    }

    public function setSerie(?Serie $serie): self
    {
        $this->serie = $serie;

        return $this;
    }

    /**
     * @return Collection|Surveillant[]
     */
    public function getSurveillants(): Collection
    {
        return $this->surveillants;
    }

    public function addSurveillant(Surveillant $surveillant): self
    {
        if (!$this->surveillants->contains($surveillant)) {
            $this->surveillants[] = $surveillant;
            $surveillant->addClasse($this);
        }

        return $this;
    }

    public function removeSurveillant(Surveillant $surveillant): self
    {
        if ($this->surveillants->removeElement($surveillant)) {
            $surveillant->removeClasse($this);
        }

        return $this;
    }

    /**
     * @return Collection|Eleve[]
     */
    public function getEleve(): Collection
    {
        return $this->eleve;
    }

    public function addEleve(Eleve $eleve): self
    {
        if (!$this->eleve->contains($eleve)) {
            $this->eleve[] = $eleve;
            $eleve->setClasse($this);
        }

        return $this;
    }

    public function removeEleve(Eleve $eleve): self
    {
        if ($this->eleve->removeElement($eleve)) {
            // set the owning side to null (unless already changed)
            if ($eleve->getClasse() === $this) {
                $eleve->setClasse(null);
            }
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
            $cour->addClasse($this);
        }

        return $this;
    }

    public function removeCour(Cours $cour): self
    {
        if ($this->cours->removeElement($cour)) {
            $cour->removeClasse($this);
        }

        return $this;
    }

    public function getNiveau(): ?Niveau
    {
        return $this->niveau;
    }

    public function setNiveau(?Niveau $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }
}
