<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Role", inversedBy="user")
     * @ORM\JoinColumn(nullable=false)
     */
    private $role;

    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

     /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="date")
     * @ORM\JoinColumn(nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=Proviseur::class, mappedBy="user", orphanRemoval=true)
     */
    private $proviseurs;

    /**
     * @ORM\OneToMany(targetEntity=Censeur::class, mappedBy="user", orphanRemoval=true)
     */
    private $censeurs;

    /**
     * @ORM\OneToMany(targetEntity=Intendant::class, mappedBy="user", orphanRemoval=true)
     */
    private $intendants;

    /**
     * @ORM\OneToMany(targetEntity=Surveillant::class, mappedBy="user", orphanRemoval=true)
     */
    private $surveillants;

    /**
     * @ORM\OneToMany(targetEntity=Formateur::class, mappedBy="user", orphanRemoval=true)
     */
    private $formateurs;

    /**
     * @ORM\OneToMany(targetEntity=Eleve::class, mappedBy="user")
     */
    private $eleves;

    public function __construct()
    {
        $this->isActive = true;
        $this->createdAt = new \DateTime();
        $this->proviseurs = new ArrayCollection();
        $this->censeurs = new ArrayCollection();
        $this->intendants = new ArrayCollection();
        $this->surveillants = new ArrayCollection();
        $this->formateurs = new ArrayCollection();
        $this->eleves = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles()
    {
        // genere le role de l'utilsateur a partir de son role_id
        return $this->getRoles = [('ROLE_'.strtoupper($this->getRole()->getLibelle()))];

    }
    
    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|Proviseur[]
     */
    public function getProviseurs(): Collection
    {
        return $this->proviseurs;
    }

    public function addProviseur(Proviseur $proviseur): self
    {
        if (!$this->proviseurs->contains($proviseur)) {
            $this->proviseurs[] = $proviseur;
            $proviseur->setUser($this);
        }

        return $this;
    }

    public function removeProviseur(Proviseur $proviseur): self
    {
        if ($this->proviseurs->removeElement($proviseur)) {
            // set the owning side to null (unless already changed)
            if ($proviseur->getUser() === $this) {
                $proviseur->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Censeur[]
     */
    public function getCenseurs(): Collection
    {
        return $this->censeurs;
    }

    public function addCenseur(Censeur $censeur): self
    {
        if (!$this->censeurs->contains($censeur)) {
            $this->censeurs[] = $censeur;
            $censeur->setUser($this);
        }

        return $this;
    }

    public function removeCenseur(Censeur $censeur): self
    {
        if ($this->censeurs->removeElement($censeur)) {
            // set the owning side to null (unless already changed)
            if ($censeur->getUser() === $this) {
                $censeur->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Intendant[]
     */
    public function getIntendants(): Collection
    {
        return $this->intendants;
    }

    public function addIntendant(Intendant $intendant): self
    {
        if (!$this->intendants->contains($intendant)) {
            $this->intendants[] = $intendant;
            $intendant->setUser($this);
        }

        return $this;
    }

    public function removeIntendant(Intendant $intendant): self
    {
        if ($this->intendants->removeElement($intendant)) {
            // set the owning side to null (unless already changed)
            if ($intendant->getUser() === $this) {
                $intendant->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Surveillant[]
     */
    public function getSurveillants(): Collection
    {
        return $this->surveillants;
    }

    public function addSurveillant(Surveillant $surveillant): self
    {
        if (!$this->surveillants->contains($surveillant)) {
            $this->surveillants[] = $surveillant;
            $surveillant->setUser($this);
        }

        return $this;
    }

    public function removeSurveillant(Surveillant $surveillant): self
    {
        if ($this->surveillants->removeElement($surveillant)) {
            // set the owning side to null (unless already changed)
            if ($surveillant->getUser() === $this) {
                $surveillant->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Formateur[]
     */
    public function getFormateurs(): Collection
    {
        return $this->formateurs;
    }

    public function addFormateur(Formateur $formateur): self
    {
        if (!$this->formateurs->contains($formateur)) {
            $this->formateurs[] = $formateur;
            $formateur->setUser($this);
        }

        return $this;
    }

    public function removeFormateur(Formateur $formateur): self
    {
        if ($this->formateurs->removeElement($formateur)) {
            // set the owning side to null (unless already changed)
            if ($formateur->getUser() === $this) {
                $formateur->setUser(null);
            }
        }

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
            $elefe->setUser($this);
        }

        return $this;
    }

    public function removeElefe(Eleve $elefe): self
    {
        if ($this->eleves->removeElement($elefe)) {
            // set the owning side to null (unless already changed)
            if ($elefe->getUser() === $this) {
                $elefe->setUser(null);
            }
        }

        return $this;
    }
}

