<?php

namespace App\Entity;

use App\Repository\AgentSoinsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AgentSoinsRepository::class)
 */
class AgentSoins
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
    private $nomCompletAgent;

    /**
     * @ORM\ManyToOne(targetEntity=ServiceMedicale::class, inversedBy="agentSoins")
     * @ORM\JoinColumn(nullable=false)
     */
    private $serviceMed;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $typeAgt;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $telephoneAgt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCompletAgent(): ?string
    {
        return $this->nomCompletAgent;
    }

    public function setNomCompletAgent(string $nomCompletAgent): self
    {
        $this->nomCompletAgent = $nomCompletAgent;

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

    public function getTypeAgt(): ?string
    {
        return $this->typeAgt;
    }

    public function setTypeAgt(string $typeAgt): self
    {
        $this->typeAgt = $typeAgt;

        return $this;
    }

    public function getTelephoneAgt(): ?string
    {
        return $this->telephoneAgt;
    }

    public function setTelephoneAgt(string $telephoneAgt): self
    {
        $this->telephoneAgt = $telephoneAgt;

        return $this;
    }
}
