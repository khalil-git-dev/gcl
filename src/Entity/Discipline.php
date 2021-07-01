<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\DisciplineRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *  collectionOperations={
 *    "get"},
 *   normalizationContext={"groups"={"discipline"}},)
 * @ORM\Entity(repositoryClass=DisciplineRepository::class)
 */
class Discipline
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     * @Groups({"discipline"})
     */
    private $libelleDis;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"discipline"})
     */
    private $coefDis;

    /**
     * @ORM\OneToMany(targetEntity=Cours::class, mappedBy="discipline")
     * @Groups({"cours"})
     */
    private $cours;

    /**
     * @ORM\OneToMany(targetEntity=Evaluation::class, mappedBy="discipline")
     */
    private $evaluations;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantumHoraire;

    public function __construct()
    {
        $this->cours = new ArrayCollection();
        $this->evaluations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleDis(): ?string
    {
        return $this->libelleDis;
    }

    public function setLibelleDis(string $libelleDis): self
    {
        $this->libelleDis = $libelleDis;

        return $this;
    }

    public function getCoefDis(): ?int
    {
        return $this->coefDis;
    }

    public function setCoefDis(int $coefDis): self
    {
        $this->coefDis = $coefDis;

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
            $cour->setDiscipline($this);
        }

        return $this;
    }

    public function removeCour(Cours $cour): self
    {
        if ($this->cours->removeElement($cour)) {
            // set the owning side to null (unless already changed)
            if ($cour->getDiscipline() === $this) {
                $cour->setDiscipline(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Evaluation[]
     */
    public function getEvaluations(): Collection
    {
        return $this->evaluations;
    }

    public function addEvaluation(Evaluation $evaluation): self
    {
        if (!$this->evaluations->contains($evaluation)) {
            $this->evaluations[] = $evaluation;
            $evaluation->setDiscipline($this);
        }

        return $this;
    }

    public function removeEvaluation(Evaluation $evaluation): self
    {
        if ($this->evaluations->removeElement($evaluation)) {
            // set the owning side to null (unless already changed)
            if ($evaluation->getDiscipline() === $this) {
                $evaluation->setDiscipline(null);
            }
        }

        return $this;
    }

    public function getQuantumHoraire(): ?int
    {
        return $this->quantumHoraire;
    }

    public function setQuantumHoraire(int $quantumHoraire): self
    {
        $this->quantumHoraire = $quantumHoraire;

        return $this;
    }
}
