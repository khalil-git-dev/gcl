<?php

namespace App\Entity;

use App\Repository\DocumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DocumentRepository::class)
 */
class Document
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
    private $codeDoc;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $typeDoc;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelleDoc;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $categorieDoc;

    /**
     * @ORM\ManyToOne(targetEntity=Etagere::class, inversedBy="documents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $etagere;

    /**
     * @ORM\ManyToMany(targetEntity=Eleve::class, mappedBy="document")
     */
    private $eleves;

    public function __construct()
    {
        $this->eleves = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeDoc(): ?string
    {
        return $this->codeDoc;
    }

    public function setCodeDoc(string $codeDoc): self
    {
        $this->codeDoc = $codeDoc;

        return $this;
    }

    public function getTypeDoc(): ?string
    {
        return $this->typeDoc;
    }

    public function setTypeDoc(string $typeDoc): self
    {
        $this->typeDoc = $typeDoc;

        return $this;
    }

    public function getLibelleDoc(): ?string
    {
        return $this->libelleDoc;
    }

    public function setLibelleDoc(string $libelleDoc): self
    {
        $this->libelleDoc = $libelleDoc;

        return $this;
    }

    public function getCategorieDoc(): ?string
    {
        return $this->categorieDoc;
    }

    public function setCategorieDoc(string $categorieDoc): self
    {
        $this->categorieDoc = $categorieDoc;

        return $this;
    }

    public function getEtagere(): ?Etagere
    {
        return $this->etagere;
    }

    public function setEtagere(?Etagere $etagere): self
    {
        $this->etagere = $etagere;

        return $this;
    }

    /**
     * @return Collection|Eleve[]
     */
    public function getEleves(): Collection
    {
        return $this->eleves;
    }

    public function addElefe(Eleve $elefe): self
    {
        if (!$this->eleves->contains($elefe)) {
            $this->eleves[] = $elefe;
            $elefe->addDocument($this);
        }

        return $this;
    }

    public function removeElefe(Eleve $elefe): self
    {
        if ($this->eleves->removeElement($elefe)) {
            $elefe->removeDocument($this);
        }

        return $this;
    }
}
