<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PromotionRepository")
 */
class Promotion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $anneeDebut;

    /**
     * @ORM\Column(type="integer")
     */
    private $anneeFin;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Groupe", mappedBy="promotion")
     */
    private $groupes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Etudiant", mappedBy="promotion")
     */
    private $etudiants;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Csv", mappedBy="promotion")
     */
    private $csvs;

    public function __construct()
    {
        $this->etudiants = new ArrayCollection();
        $this->groupes = new ArrayCollection();
        $this->csvs = new ArrayCollection();
    }

    public function __toString(): ?string
    {
        $res = $this->anneeDebut . " - " . $this->anneeFin();
        return $res;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAnneeDebut(): ?int
    {
        return $this->anneeDebut;
    }

    public function setAnneeDebut(int $anneeDebut): self
    {
        $this->anneeDebut = $anneeDebut;

        return $this;
    }

    /**
     * @return Collection|Groupe[]
     */
    public function getGroupes(): Collection
    {
        return $this->groupes;
    }

    public function addGroupe(Groupe $groupe): self
    {
        if (!$this->groupes->contains($groupe)) {
            $this->groupes[] = $groupe;
            $groupe->setPromotion($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->contains($groupe)) {
            $this->groupes->removeElement($groupe);
            // set the owning side to null (unless already changed)
            if ($groupe->getPromotion() === $this) {
                $groupe->setPromotion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Etudiant[]
     */
    public function getEtudiants(): Collection
    {
        return $this->etudiants;
    }

    public function addEtudiant(Etudiant $etudiant): self
    {
        if (!$this->etudiants->contains($etudiant)) {
            $this->etudiants[] = $etudiant;
            $etudiant->setPromotion($this);
        }

        return $this;
    }

    public function removeEtudiant(Etudiant $etudiant): self
    {
        if ($this->etudiants->contains($etudiant)) {
            $this->etudiants->removeElement($etudiant);
            // set the owning side to null (unless already changed)
            if ($etudiant->getPromotion() === $this) {
                $etudiant->setPromotion(null);
            }
        }

        return $this;
    }

    public function getAnneeFin(): ?int
    {
        return $this->anneeFin;
    }

    public function setAnneeFin(int $anneeFin): self
    {
        $this->anneeFin = $anneeFin;

        return $this;
    }

    /**
     * @return Collection|Csv[]
     */
    public function getCsvs(): Collection
    {
        return $this->csvs;
    }

    public function addCsv(Csv $csv): self
    {
        if (!$this->csvs->contains($csv)) {
            $this->csvs[] = $csv;
            $csv->setPromotion($this);
        }

        return $this;
    }

    public function removeCsv(Csv $csv): self
    {
        if ($this->csvs->contains($csv)) {
            $this->csvs->removeElement($csv);
            // set the owning side to null (unless already changed)
            if ($csv->getPromotion() === $this) {
                $csv->setPromotion(null);
            }
        }

        return $this;
    }
}
