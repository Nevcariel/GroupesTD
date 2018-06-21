<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MatiereRepository")
 */
class Matiere
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $intitule;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Enseignant", inversedBy="matieres")
     */
    private $enseignants;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Etudiant", mappedBy="voeuPrincipal")
     */
    private $etudiantsPrincipal;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Etudiant", mappedBy="voeuSecondaire")
     */
    private $etudiantsSecondaire;

    public function __construct()
    {
        $this->enseignants = new ArrayCollection();
        $this->etudiantPrincipal = new ArrayCollection();
        $this->etudiantSecondaire = new ArrayCollection();
    }

    public function __toString(): ?string
    {
        return $this->intitule;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): self
    {
        $this->intitule = $intitule;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Enseignant[]
     */
    public function getEnseignants(): Collection
    {
        return $this->enseignants;
    }

    public function addEnseignant(Enseignant $enseignant): self
    {
        if (!$this->enseignants->contains($enseignant)) {
            $this->enseignants[] = $enseignant;
        }

        return $this;
    }

    public function removeEnseignant(Enseignant $enseignant): self
    {
        if ($this->enseignants->contains($enseignant)) {
            $this->enseignants->removeElement($enseignant);
        }

        return $this;
    }

    /**
     * @return Collection|Etudiant[]
     */
    public function getEtudiantsPrincipal(): Collection
    {
        return $this->etudiantsPrincipal;
    }

    public function addEtudiantPrincipal(Etudiant $etudiant): self
    {
        if (!$this->etudiantsPrincipal->contains($etudiant)) {
            $this->etudiantsPrincipal[] = $etudiant;
            $etudiant->setVoeuPrincipal($this);
        }

        return $this;
    }

    public function removeEtudiantsPrincipal(Etudiant $etudiant): self
    {
        if ($this->etudiantsPrincipal->contains($etudiant)) {
            $this->etudiantsPrincipal->removeElement($etudiant);
            // set the owning side to null (unless already changed)
            if ($etudiant->getVoeuPrincipal() === $this) {
                $etudiant->setVoeuPrincipal(null);
            }
        }

        return $this;
    }

    public function getEtudiantsSecondaire(): Collection
    {
        return $this->etudiantsSecondaire;
    }

    public function addEtudiantsSecondaire(Etudiant $etudiant): self
    {
        if (!$this->etudiantsSecondaire->contains($etudiant)) {
            $this->etudiantsSecondaire[] = $etudiant;
            $etudiant->setVoeuSecondaire($this);
        }

        return $this;
    }

    public function removeEtudiantsSecondaire(Etudiant $etudiant): self
    {
        if ($this->etudiantsSecondaire->contains($etudiant)) {
            $this->etudiantsSecondaire->removeElement($etudiant);
            // set the owning side to null (unless already changed)
            if ($etudiant->getVoeuSecondaire() === $this) {
                $etudiant->setVoeuSecondaire(null);
            }
        }

        return $this;
    }
}
