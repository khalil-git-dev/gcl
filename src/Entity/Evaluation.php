<?php

namespace App\Entity;

use App\Repository\EvaluationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EvaluationRepository::class)
 */
class Evaluation
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
    private $libelleEval;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $detailEval;

    /**
     * @ORM\ManyToOne(targetEntity=Date::class, inversedBy="evaluations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Discipline::class, inversedBy="evaluations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $discipline;

    /**
     * @ORM\ManyToMany(targetEntity=Eleve::class, inversedBy="evaluations")
     */
    private $eleve;

    /**
     * @ORM\ManyToMany(targetEntity=Note::class, inversedBy="evaluations")
     */
    private $note;

    public function __construct()
    {
        $this->eleve = new ArrayCollection();
        $this->note = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleEval(): ?string
    {
        return $this->libelleEval;
    }

    public function setLibelleEval(string $libelleEval): self
    {
        $this->libelleEval = $libelleEval;

        return $this;
    }

    public function getDetailEval(): ?string
    {
        return $this->detailEval;
    }

    public function setDetailEval(?string $detailEval): self
    {
        $this->detailEval = $detailEval;

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

    public function getDiscipline(): ?Discipline
    {
        return $this->discipline;
    }

    public function setDiscipline(?Discipline $discipline): self
    {
        $this->discipline = $discipline;

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
        }

        return $this;
    }

    public function removeEleve(Eleve $eleve): self
    {
        $this->eleve->removeElement($eleve);

        return $this;
    }

    /**
     * @return Collection|Note[]
     */
    public function getNote(): Collection
    {
        return $this->note;
    }

    public function addNote(Note $note): self
    {
        if (!$this->note->contains($note)) {
            $this->note[] = $note;
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        $this->note->removeElement($note);

        return $this;
    }
}
