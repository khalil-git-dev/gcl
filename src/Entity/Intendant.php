<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\IntendantRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=IntendantRepository::class)
 */
class Intendant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $prenomInt;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $nomInt;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $emailInt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="intendants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $adresseInt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrenomInt(): ?string
    {
        return $this->prenomInt;
    }

    public function setPrenomInt(string $prenomInt): self
    {
        $this->prenomInt = $prenomInt;

        return $this;
    }

    public function getNomInt(): ?string
    {
        return $this->nomInt;
    }

    public function setNomInt(string $nomInt): self
    {
        $this->nomInt = $nomInt;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmailInt(): ?string
    {
        return $this->emailInt;
    }

    public function setEmailInt(string $emailInt): self
    {
        $this->emailInt = $emailInt;

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

    public function getAdresseInt(): ?string
    {
        return $this->adresseInt;
    }

    public function setAdresseInt(?string $adresseInt): self
    {
        $this->adresseInt = $adresseInt;

        return $this;
    }
}
