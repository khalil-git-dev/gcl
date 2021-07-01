<?php

namespace App\Entity;

use App\Repository\NoteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NoteRepository::class)
 */
class Note
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $valeurNot;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $appreciation;

    /**
     * @ORM\Column(type="integer")
     */
    private $proportionaliteNot;

    /**
     * @ORM\ManyToOne(targetEntity=Bulletin::class, inversedBy="notes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bulletin;

    /**
     * @ORM\ManyToMany(targetEntity=Evaluation::class, mappedBy="note")
     */
    private $evaluations;

    /**
     * @ORM\ManyToOne(targetEntity=Formateur::class, inversedBy="notes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $formateur;

    public function __construct()
    {
        $this->evaluations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValeurNot(): ?float
    {
        return $this->valeurNot;
    }

    public function setValeurNot(float $valeurNot): self
    {
        $this->valeurNot = $valeurNot;

        return $this;
    }

    public function getAppreciation(): ?string
    {
        return $this->appreciation;
    }

    public function setAppreciation(?string $appreciation): self
    {
        $this->appreciation = $appreciation;

        return $this;
    }

    public function getProportionaliteNot(): ?int
    {
        return $this->proportionaliteNot;
    }

    public function setProportionaliteNot(int $proportionaliteNot): self
    {
        $this->proportionaliteNot = $proportionaliteNot;

        return $this;
    }

    public function getBulletin(): ?Bulletin
    {
        return $this->bulletin;
    }

    public function setBulletin(?Bulletin $bulletin): self
    {
        $this->bulletin = $bulletin;

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
            $evaluation->addNote($this);
        }

        return $this;
    }

    public function removeEvaluation(Evaluation $evaluation): self
    {
        if ($this->evaluations->removeElement($evaluation)) {
            $evaluation->removeNote($this);
        }

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
}
