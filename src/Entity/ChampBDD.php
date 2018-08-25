<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChampBDDRepository")
 */
class ChampBDD
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
     * @ORM\OneToMany(targetEntity="App\Entity\AssociationBddCsv", mappedBy="champBdd")
     */
    private $associationsBddCsv;

    public function __construct()
    {
        $this->associationsBddCsv = new ArrayCollection();
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

    /**
     * @return Collection|AssociationBddCsv[]
     */
    public function getAssociationsBddCsv(): Collection
    {
        return $this->associationsBddCsv;
    }

    public function addAssociationsBddCsv(AssociationBddCsv $associationsBddCsv): self
    {
        if (!$this->associationsBddCsv->contains($associationsBddCsv)) {
            $this->associationsBddCsv[] = $associationsBddCsv;
            $associationsBddCsv->setChampBdd($this);
        }

        return $this;
    }

    public function removeAssociationsBddCsv(AssociationBddCsv $associationsBddCsv): self
    {
        if ($this->associationsBddCsv->contains($associationsBddCsv)) {
            $this->associationsBddCsv->removeElement($associationsBddCsv);
            // set the owning side to null (unless already changed)
            if ($associationsBddCsv->getChampBdd() === $this) {
                $associationsBddCsv->setChampBdd(null);
            }
        }

        return $this;
    }
}
