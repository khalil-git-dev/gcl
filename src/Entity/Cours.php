<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CoursRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *  collectionOperations={
 *    "get"},
 *   normalizationContext={"groups"={"cours"}},)
 * @ORM\Entity(repositoryClass=CoursRepository::class)
 */
class Cours
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
    private $libelleCr;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $detailCr;

    /**
     * @ORM\ManyToOne(targetEntity=Discipline::class, inversedBy="cours")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"discipline"})
     */
    private $discipline;

    /**
     * @ORM\ManyToOne(targetEntity=Salle::class, inversedBy="cours")
     * @ORM\JoinColumn(nullable=false)
     */
    private $salle;

    /**
     * @ORM\ManyToOne(targetEntity=Formateur::class, inversedBy="cours")
     * @ORM\JoinColumn(nullable=false)
     */
    private $formateur;

    /**
     * @ORM\ManyToMany(targetEntity=Classe::class, inversedBy="cours")
     */
    private $classe;

    /**
     * @ORM\Column(type="float")
     * @Groups({"cours"})
     */
    private $dureeCr;

    /**
     * @ORM\ManyToMany(targetEntity=Eleve::class, inversedBy="absences")
     */
    private $absences;

    public function __construct()
    {
        $this->classe = new ArrayCollection();
        $this->retards = new ArrayCollection();
        $this->absences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleCr(): ?string
    {
        return $this->libelleCr;
    }

    public function setLibelleCr(string $libelleCr): self
    {
        $this->libelleCr = $libelleCr;

        return $this;
    }

    public function getDetailCr(): ?string
    {
        return $this->detailCr;
    }

    public function setDetailCr(?string $detailCr): self
    {
        $this->detailCr = $detailCr;

        return $this;
    }

    public function getDiscipline(): ?Discipline
    {
        return $this->discipline;
    }

    public function setDiscipline(?Discipline $discipline): self
    {
        $this->discipline = $discipline;

        return $this;
    }

    public function getSalle(): ?Salle
    {
        return $this->salle;
    }

    public function setSalle(?Salle $salle): self
    {
        $this->salle = $salle;

        return $this;
    }

    public function getFormateur(): ?Formateur
    {
        return $this->formateur;
    }

    public function setFormateur(?Formateur $formateur): self
    {
        $this->formateur = $formateur;

        return $this;
    }

    /**
     * @return Collection|Classe[]
     */
    public function getClasse(): Collection
    {
        return $this->classe;
    }

    public function addClasse(Classe $classe): self
    {
        if (!$this->classe->contains($classe)) {
            $this->classe[] = $classe;
        }

        return $this;
    }

    public function removeClasse(Classe $classe): self
    {
        $this->classe->removeElement($classe);

        return $this;
    }

    public function getDureeCr(): ?float
    {
        return $this->dureeCr;
    }

    public function setDureeCr(float $dureeCr): self
    {
        $this->dureeCr = $dureeCr;

        return $this;
    }

    /**
     * @return Collection|Eleve[]
     */
    public function getAbsences(): Collection
    {
        return $this->absences;
    }

    public function addAbsence(Eleve $absence): self
    {
        if (!$this->absences->contains($absence)) {
            $this->absences[] = $absence;
        }

        return $this;
    }

    public function removeAbsence(Eleve $absence): self
    {
        $this->absences->removeElement($absence);

        return $this;
    }

}
