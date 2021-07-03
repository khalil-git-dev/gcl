<?php

namespace App\Entity;

use App\Repository\BulletinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BulletinRepository::class)
 */
class Bulletin
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
    private $libelleBul;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $typeBul;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $categorieBul;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $detailBul;

    /**
     * @ORM\ManyToOne(targetEntity=Dossier::class, inversedBy="bulletins")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dossier;

    /**
     * @ORM\OneToMany(targetEntity=Note::class, mappedBy="bulletin")
     * @ORM\JoinColumn(nullable=true)
     */
    private $notes;

    /**
     * @ORM\ManyToOne(targetEntity=ServiceMedicale::class, inversedBy="bulletins")
     * @ORM\JoinColumn(nullable=true)
     */
    private $serviceMed;

    /**
     * @ORM\ManyToOne(targetEntity=Eleve::class, inversedBy="bulletins")
     * @ORM\JoinColumn(nullable=false)
     */
    private $eleve;

    public function __construct()
    {
        $this->notes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleBul(): ?string
    {
        return $this->libelleBul;
    }

    public function setLibelleBul(string $libelleBul): self
    {
        $this->libelleBul = $libelleBul;

        return $this;
    }

    public function getTypeBul(): ?string
    {
        return $this->typeBul;
    }

    public function setTypeBul(string $typeBul): self
    {
        $this->typeBul = $typeBul;

        return $this;
    }

    public function getCategorieBul(): ?string
    {
        return $this->categorieBul;
    }

    public function setCategorieBul(string $categorieBul): self
    {
        $this->categorieBul = $categorieBul;

        return $this;
    }

    public function getDetailBul(): ?string
    {
        return $this->detailBul;
    }

    public function setDetailBul(?string $detailBul): self
    {
        $this->detailBul = $detailBul;

        return $this;
    }

    public function getDossier(): ?Dossier
    {
        return $this->dossier;
    }

    public function setDossier(?Dossier $dossier): self
    {
        $this->dossier = $dossier;

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
            $note->setBulletin($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getBulletin() === $this) {
                $note->setBulletin(null);
            }
        }

        return $this;
    }

    public function getServiceMed(): ?ServiceMedicale
    {
        return $this->serviceMed;
    }

    public function setServiceMed(?ServiceMedicale $serviceMed): self
    {
        $this->serviceMed = $serviceMed;

        return $this;
    }

    public function getEleve(): ?Eleve
    {
        return $this->eleve;
    }

    public function setEleve(?Eleve $eleve): self
    {
        $this->eleve = $eleve;

        return $this;
    }
}
