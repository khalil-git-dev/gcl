<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SurveillantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=SurveillantRepository::class)
 */
class Surveillant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $type_sur;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nomSur;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $prenomSur;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $emailSur;

    /**
     * @ORM\ManyToMany(targetEntity=Classe::class, inversedBy="surveillants")
     */
    private $classe;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="surveillants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct()
    {
        $this->classe = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeSur(): ?string
    {
        return $this->type_sur;
    }

    public function setTypeSur(string $type_sur): self
    {
        $this->type_sur = $type_sur;

        return $this;
    }

    public function getNomSur(): ?string
    {
        return $this->nomSur;
    }

    public function setNomSur(string $nomSur): self
    {
        $this->nomSur = $nomSur;

        return $this;
    }

    public function getPrenomSur(): ?string
    {
        return $this->prenomSur;
    }

    public function setPrenomSur(string $prenomSur): self
    {
        $this->prenomSur = $prenomSur;

        return $this;
    }

    public function getEmailSur(): ?string
    {
        return $this->emailSur;
    }

    public function setEmailSur(string $emailSur): self
    {
        $this->emailSur = $emailSur;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
