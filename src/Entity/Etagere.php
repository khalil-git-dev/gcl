<?php

namespace App\Entity;

use App\Repository\EtagereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EtagereRepository::class)
 */
class Etagere
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
    private $libelleEtag;

    /**
     * @ORM\ManyToOne(targetEntity=Rayon::class, inversedBy="etageres")
     * @ORM\JoinColumn(nullable=false)
     */
    private $rayon;

    /**
     * @ORM\OneToMany(targetEntity=Document::class, mappedBy="etagere", orphanRemoval=true)
     */
    private $documents;

    public function __construct()
    {
        $this->documents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleEtag(): ?string
    {
        return $this->libelleEtag;
    }

    public function setLibelleEtag(string $libelleEtag): self
    {
        $this->libelleEtag = $libelleEtag;

        return $this;
    }

    public function getRayon(): ?Rayon
    {
        return $this->rayon;
    }

    public function setRayon(?Rayon $rayon): self
    {
        $this->rayon = $rayon;

        return $this;
    }

    /**
     * @return Collection|Document[]
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Document $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents[] = $document;
            $document->setEtagere($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getEtagere() === $this) {
                $document->setEtagere(null);
            }
        }

        return $this;
    }
}
