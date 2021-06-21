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
}
