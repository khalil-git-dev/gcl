<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ServiceMedicaleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ServiceMedicaleRepository::class)
 */
class ServiceMedicale
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelleSerMed;

    /**
     * @ORM\OneToMany(targetEntity=Bulletin::class, mappedBy="serviceMed")
     */
    private $bulletins;

    /**
     * @ORM\OneToMany(targetEntity=AgentSoins::class, mappedBy="serviceMed")
     */
    private $agentSoins;

    public function __construct()
    {
        $this->bulletins = new ArrayCollection();
        $this->agentSoins = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleSerMed(): ?string
    {
        return $this->libelleSerMed;
    }

    public function setLibelleSerMed(string $libelleSerMed): self
    {
        $this->libelleSerMed = $libelleSerMed;

        return $this;
    }

    /**
     * @return Collection|Bulletin[]
     */
    public function getBulletins(): Collection
    {
        return $this->bulletins;
    }

    public function addBulletin(Bulletin $bulletin): self
    {
        if (!$this->bulletins->contains($bulletin)) {
            $this->bulletins[] = $bulletin;
            $bulletin->setServiceMed($this);
        }

        return $this;
    }

    public function removeBulletin(Bulletin $bulletin): self
    {
        if ($this->bulletins->removeElement($bulletin)) {
            // set the owning side to null (unless already changed)
            if ($bulletin->getServiceMed() === $this) {
                $bulletin->setServiceMed(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AgentSoins[]
     */
    public function getAgentSoins(): Collection
    {
        return $this->agentSoins;
    }

    public function addAgentSoin(AgentSoins $agentSoin): self
    {
        if (!$this->agentSoins->contains($agentSoin)) {
            $this->agentSoins[] = $agentSoin;
            $agentSoin->setServiceMed($this);
        }

        return $this;
    }

    public function removeAgentSoin(AgentSoins $agentSoin): self
    {
        if ($this->agentSoins->removeElement($agentSoin)) {
            // set the owning side to null (unless already changed)
            if ($agentSoin->getServiceMed() === $this) {
                $agentSoin->setServiceMed(null);
            }
        }

        return $this;
    }
}
