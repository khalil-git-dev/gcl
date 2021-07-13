<?php

namespace App\Entity;

use App\Repository\FormateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FormateurRepository::class)
 */
class Formateur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $nomFor;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $prenomFor;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $emailFor;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $matieres;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $typeFor;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $telFor;

    /**
     * @ORM\OneToMany(targetEntity=Cours::class, mappedBy="formateur")
     */
    private $cours;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="formateurs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Note::class, mappedBy="formateur")
     */
    private $notes;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $heurSupplementaire;

    public function __construct()
    {
        $this->cours = new ArrayCollection();
        $this->notes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomFor(): ?string
    {
        return $this->nomFor;
    }

    public function setNomFor(string $nomFor): self
    {
        $this->nomFor = $nomFor;

        return $this;
    }

    public function getPrenomFor(): ?string
    {
        return $this->prenomFor;
    }

    public function setPrenomFor(string $prenomFor): self
    {
        $this->prenomFor = $prenomFor;

        return $this;
    }

    public function getEmailFor(): ?string
    {
        return $this->emailFor;
    }

    public function setEmailFor(string $emailFor): self
    {
        $this->emailFor = $emailFor;

        return $this;
    }

    public function getMatieres(): ?string
    {
        return $this->matieres;
    }

    public function setMatieres(?string $matieres): self
    {
        $this->matieres = $matieres;

        return $this;
    }

    public function getTypeFor(): ?string
    {
        return $this->typeFor;
    }

    public function setTypeFor(string $typeFor): self
    {
        $this->typeFor = $typeFor;

        return $this;
    }

    public function getTelFor(): ?string
    {
        return $this->telFor;
    }

    public function setTelFor(string $telFor): self
    {
        $this->telFor = $telFor;

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
            $cour->setFormateur($this);
        }

        return $this;
    }

    public function removeCour(Cours $cour): self
    {
        if ($this->cours->removeElement($cour)) {
            // set the owning side to null (unless already changed)
            if ($cour->getFormateur() === $this) {
                $cour->setFormateur(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Note[]
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->setFormateur($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getFormateur() === $this) {
                $note->setFormateur(null);
            }
        }

        return $this;
    }

    public function getHeurSupplementaire(): ?float
    {
        return $this->heurSupplementaire;
    }

    public function setHeurSupplementaire(?float $heurSupplementaire): self
    {
        $this->heurSupplementaire = $heurSupplementaire;

        return $this;
    }
}
