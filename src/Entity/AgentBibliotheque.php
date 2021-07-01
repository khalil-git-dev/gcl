<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AgentBibliothequeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=AgentBibliothequeRepository::class)
 */
class AgentBibliotheque
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
    private $nomAgentBib;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $telAgentBib;

    /**
     * @ORM\ManyToOne(targetEntity=Bibliotheque::class, inversedBy="agentBibliotheques")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bibliotheque;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomAgentBib(): ?string
    {
        return $this->nomAgentBib;
    }

    public function setNomAgentBib(string $nomAgentBib): self
    {
        $this->nomAgentBib = $nomAgentBib;

        return $this;
    }

    public function getTelAgentBib(): ?string
    {
        return $this->telAgentBib;
    }

    public function setTelAgentBib(string $telAgentBib): self
    {
        $this->telAgentBib = $telAgentBib;

        return $this;
    }

    public function getBibliotheque(): ?Bibliotheque
    {
        return $this->bibliotheque;
    }

    public function setBibliotheque(?Bibliotheque $bibliotheque): self
    {
        $this->bibliotheque = $bibliotheque;

        return $this;
    }
}
