<?php

namespace App\Entity;

use App\Repository\EleveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EleveRepository::class)
 */
class Eleve
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
    private $nomEle;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $prenomEle;

    /**
     * @ORM\Column(type="date")
     */
    private $dateNaissEle;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $lieuNaissEle;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $sexeEle;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $telEle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresseEle;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $religionEle;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nationaliteElev;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $etatEle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $detailEle;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nomCompletPere;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nomCompletMere;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $nomCompletTuteurLeg;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $telPere;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $telMere;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $telTuteurLeg;

    /**
     * @ORM\ManyToOne(targetEntity=Niveau::class, inversedBy="eleves")
     * @ORM\JoinColumn(nullable=false)
     */
    private $niveau;

    /**
     * @ORM\ManyToOne(targetEntity=Classe::class, inversedBy="eleve")
     * @ORM\JoinColumn(nullable=false)
     */
    private $classe;

    /**
     * @ORM\ManyToMany(targetEntity=Evaluation::class, mappedBy="eleve")
     */
    private $evaluations;

    /**
     * @ORM\OneToMany(targetEntity=Recu::class, mappedBy="eleve")
     */
    private $recus;

    /**
     * @ORM\OneToMany(targetEntity=Bulletin::class, mappedBy="eleve")
     */
    private $bulletins;

    /**
     * @ORM\ManyToMany(targetEntity=Document::class, inversedBy="eleves")
     */
    private $document;

    /**
     * @ORM\OneToMany(targetEntity=Dossier::class, mappedBy="eleve")
     */
    private $dossiers;

    public function __construct()
    {
        $this->evaluations = new ArrayCollection();
        $this->recus = new ArrayCollection();
        $this->bulletins = new ArrayCollection();
        $this->document = new ArrayCollection();
        $this->dossiers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEle(): ?string
    {
        return $this->nomEle;
    }

    public function setNomEle(string $nomEle): self
    {
        $this->nomEle = $nomEle;

        return $this;
    }

    public function getPrenomEle(): ?string
    {
        return $this->prenomEle;
    }

    public function setPrenomEle(string $prenomEle): self
    {
        $this->prenomEle = $prenomEle;

        return $this;
    }

    public function getDateNaissEle(): ?\DateTimeInterface
    {
        return $this->dateNaissEle;
    }

    public function setDateNaissEle(\DateTimeInterface $dateNaissEle): self
    {
        $this->dateNaissEle = $dateNaissEle;

        return $this;
    }

    public function getLieuNaissEle(): ?string
    {
        return $this->lieuNaissEle;
    }

    public function setLieuNaissEle(string $lieuNaissEle): self
    {
        $this->lieuNaissEle = $lieuNaissEle;

        return $this;
    }

    public function getSexeEle(): ?string
    {
        return $this->sexeEle;
    }

    public function setSexeEle(string $sexeEle): self
    {
        $this->sexeEle = $sexeEle;

        return $this;
    }

    public function getTelEle(): ?string
    {
        return $this->telEle;
    }

    public function setTelEle(?string $telEle): self
    {
        $this->telEle = $telEle;

        return $this;
    }

    public function getAdresseEle(): ?string
    {
        return $this->adresseEle;
    }

    public function setAdresseEle(string $adresseEle): self
    {
        $this->adresseEle = $adresseEle;

        return $this;
    }

    public function getReligionEle(): ?string
    {
        return $this->religionEle;
    }

    public function setReligionEle(?string $religionEle): self
    {
        $this->religionEle = $religionEle;

        return $this;
    }

    public function getNationaliteElev(): ?string
    {
        return $this->nationaliteElev;
    }

    public function setNationaliteElev(string $nationaliteElev): self
    {
        $this->nationaliteElev = $nationaliteElev;

        return $this;
    }

    public function getEtatEle(): ?string
    {
        return $this->etatEle;
    }

    public function setEtatEle(string $etatEle): self
    {
        $this->etatEle = $etatEle;

        return $this;
    }

    public function getDetailEle(): ?string
    {
        return $this->detailEle;
    }

    public function setDetailEle(?string $detailEle): self
    {
        $this->detailEle = $detailEle;

        return $this;
    }

    public function getNomCompletPere(): ?string
    {
        return $this->nomCompletPere;
    }

    public function setNomCompletPere(string $nomCompletPere): self
    {
        $this->nomCompletPere = $nomCompletPere;

        return $this;
    }

    public function getNomCompletMere(): ?string
    {
        return $this->nomCompletMere;
    }

    public function setNomCompletMere(string $nomCompletMere): self
    {
        $this->nomCompletMere = $nomCompletMere;

        return $this;
    }

    public function getNomCompletTuteurLeg(): ?string
    {
        return $this->nomCompletTuteurLeg;
    }

    public function setNomCompletTuteurLeg(?string $nomCompletTuteurLeg): self
    {
        $this->nomCompletTuteurLeg = $nomCompletTuteurLeg;

        return $this;
    }

    public function getTelPere(): ?string
    {
        return $this->telPere;
    }

    public function setTelPere(string $telPere): self
    {
        $this->telPere = $telPere;

        return $this;
    }

    public function getTelMere(): ?string
    {
        return $this->telMere;
    }

    public function setTelMere(?string $telMere): self
    {
        $this->telMere = $telMere;

        return $this;
    }

    public function getTelTuteurLeg(): ?string
    {
        return $this->telTuteurLeg;
    }

    public function setTelTuteurLeg(?string $telTuteurLeg): self
    {
        $this->telTuteurLeg = $telTuteurLeg;

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

    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): self
    {
        $this->classe = $classe;

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
            $evaluation->addEleve($this);
        }

        return $this;
    }

    public function removeEvaluation(Evaluation $evaluation): self
    {
        if ($this->evaluations->removeElement($evaluation)) {
            $evaluation->removeEleve($this);
        }

        return $this;
    }

    /**
     * @return Collection|Recu[]
     */
    public function getRecus(): Collection
    {
        return $this->recus;
    }

    public function addRecu(Recu $recu): self
    {
        if (!$this->recus->contains($recu)) {
            $this->recus[] = $recu;
            $recu->setEleve($this);
        }

        return $this;
    }

    public function removeRecu(Recu $recu): self
    {
        if ($this->recus->removeElement($recu)) {
            // set the owning side to null (unless already changed)
            if ($recu->getEleve() === $this) {
                $recu->setEleve(null);
            }
        }

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
            $bulletin->setEleve($this);
        }

        return $this;
    }

    public function removeBulletin(Bulletin $bulletin): self
    {
        if ($this->bulletins->removeElement($bulletin)) {
            // set the owning side to null (unless already changed)
            if ($bulletin->getEleve() === $this) {
                $bulletin->setEleve(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Document[]
     */
    public function getDocument(): Collection
    {
        return $this->document;
    }

    public function addDocument(Document $document): self
    {
        if (!$this->document->contains($document)) {
            $this->document[] = $document;
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        $this->document->removeElement($document);

        return $this;
    }

    /**
     * @return Collection|Dossier[]
     */
    public function getDossiers(): Collection
    {
        return $this->dossiers;
    }

    public function addDossier(Dossier $dossier): self
    {
        if (!$this->dossiers->contains($dossier)) {
            $this->dossiers[] = $dossier;
            $dossier->setEleve($this);
        }

        return $this;
    }

    public function removeDossier(Dossier $dossier): self
    {
        if ($this->dossiers->removeElement($dossier)) {
            // set the owning side to null (unless already changed)
            if ($dossier->getEleve() === $this) {
                $dossier->setEleve(null);
            }
        }

        return $this;
    }
}
