<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CenseurRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=CenseurRepository::class)
 */
class Censeur
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
    private $prenomCen;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $nomCen;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $telephone;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="censeurs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrenomCen(): ?string
    {
        return $this->prenomCen;
    }

    public function setPrenomCen(string $prenomCen): self
    {
        $this->prenomCen = $prenomCen;

        return $this;
    }

    public function getNomCen(): ?string
    {
        return $this->nomCen;
    }

    public function setNomCen(string $nomCen): self
    {
        $this->nomCen = $nomCen;

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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

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
