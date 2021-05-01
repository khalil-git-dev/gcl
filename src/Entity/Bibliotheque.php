<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BibliothequeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=BibliothequeRepository::class)
 */
class Bibliotheque
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
    private $nomBiblio;

    /**
     * @ORM\OneToMany(targetEntity=AgentBibliotheque::class, mappedBy="bibliotheque", orphanRemoval=true)
     */
    private $agentBibliotheques;

    /**
     * @ORM\OneToMany(targetEntity=Rayon::class, mappedBy="bibliotheque", orphanRemoval=true)
     */
    private $rayons;

    public function __construct()
    {
        $this->agentBibliotheques = new ArrayCollection();
        $this->rayons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomBiblio(): ?string
    {
        return $this->nomBiblio;
    }

    public function setNomBiblio(string $nomBiblio): self
    {
        $this->nomBiblio = $nomBiblio;

        return $this;
    }

    /**
     * @return Collection|AgentBibliotheque[]
     */
    public function getAgentBibliotheques(): Collection
    {
        return $this->agentBibliotheques;
    }

    public function addAgentBibliotheque(AgentBibliotheque $agentBibliotheque): self
    {
        if (!$this->agentBibliotheques->contains($agentBibliotheque)) {
            $this->agentBibliotheques[] = $agentBibliotheque;
            $agentBibliotheque->setBibliotheque($this);
        }

        return $this;
    }

    public function removeAgentBibliotheque(AgentBibliotheque $agentBibliotheque): self
    {
        if ($this->agentBibliotheques->removeElement($agentBibliotheque)) {
            // set the owning side to null (unless already changed)
            if ($agentBibliotheque->getBibliotheque() === $this) {
                $agentBibliotheque->setBibliotheque(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Rayon[]
     */
    public function getRayons(): Collection
    {
        return $this->rayons;
    }

    public function addRayon(Rayon $rayon): self
    {
        if (!$this->rayons->contains($rayon)) {
            $this->rayons[] = $rayon;
            $rayon->setBibliotheque($this);
        }

        return $this;
    }

    public function removeRayon(Rayon $rayon): self
    {
        if ($this->rayons->removeElement($rayon)) {
            // set the owning side to null (unless already changed)
            if ($rayon->getBibliotheque() === $this) {
                $rayon->setBibliotheque(null);
            }
        }

        return $this;
    }
}
