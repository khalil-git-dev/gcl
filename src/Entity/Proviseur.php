<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProviseurRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ProviseurRepository::class)
 */
class Proviseur
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
    private $prenomPro;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $nomPro;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $telephonePro;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $emailPro;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="proviseurs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrenomPro(): ?string
    {
        return $this->prenomPro;
    }

    public function setPrenomPro(string $prenomPro): self
    {
        $this->prenomPro = $prenomPro;

        return $this;
    }

    public function getNomPro(): ?string
    {
        return $this->nomPro;
    }

    public function setNomPro(string $nomPro): self
    {
        $this->nomPro = $nomPro;

        return $this;
    }

    public function getTelephonePro(): ?string
    {
        return $this->telephonePro;
    }

    public function setTelephonePro(string $telephonePro): self
    {
        $this->telephonePro = $telephonePro;

        return $this;
    }

    public function getEmailPro(): ?string
    {
        return $this->emailPro;
    }

    public function setEmailPro(string $emailPro): self
    {
        $this->emailPro = $emailPro;

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
