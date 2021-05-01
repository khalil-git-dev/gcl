<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\NiveauRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=NiveauRepository::class)
 */
class Niveau
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
    private $libelleNiv;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $detailNiv;

    /**
     * @ORM\OneToMany(targetEntity=Eleve::class, mappedBy="niveau", orphanRemoval=true)
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

    public function getLibelleNiv(): ?string
    {
        return $this->libelleNiv;
    }

    public function setLibelleNiv(string $libelleNiv): self
    {
        $this->libelleNiv = $libelleNiv;

        return $this;
    }

    public function getDetailNiv(): ?string
    {
        return $this->detailNiv;
    }

    public function setDetailNiv(?string $detailNiv): self
    {
        $this->detailNiv = $detailNiv;

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
            $elefe->setNiveau($this);
        }

        return $this;
    }

    public function removeElefe(Eleve $elefe): self
    {
        if ($this->eleves->removeElement($elefe)) {
            // set the owning side to null (unless already changed)
            if ($elefe->getNiveau() === $this) {
                $elefe->setNiveau(null);
            }
        }

        return $this;
    }
}
