<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeCsvRepository")
 */
class TypeCsv
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Csv", mappedBy="typeCsv")
     */
    private $csvs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AssociationBddCsv", mappedBy="typeCsv", cascade={"persist", "remove"})
     */
    private $champs;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $intitule;

    public function __construct()
    {
        $this->csvs = new ArrayCollection();
        $this->champs = new ArrayCollection();
    }

    public function __toString(): ?string
    {
        return $this->intitule;
    }

    public function getId()
    {
        return $this->id;
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
            $csv->setTypeCsv($this);
        }

        return $this;
    }

    public function removeCsv(Csv $csv): self
    {
        if ($this->csvs->contains($csv)) {
            $this->csvs->removeElement($csv);
            // set the owning side to null (unless already changed)
            if ($csv->getTypeCsv() === $this) {
                $csv->setTypeCsv(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AssociationBddCsv[]
     */
    public function getChamps(): Collection
    {
        return $this->champs;
    }

    public function addChamp(AssociationBddCsv $champ): self
    {
        if (!$this->champs->contains($champ)) {
            $this->champs[] = $champ;
            $champ->setTypeCsv($this);
        }

        return $this;
    }

    public function removeChamp(AssociationBddCsv $champ): self
    {
        if ($this->champs->contains($champ)) {
            $this->champs->removeElement($champ);
            // set the owning side to null (unless already changed)
            if ($champ->getTypeCsv() === $this) {
                $champ->setTypeCsv(null);
            }
        }

        return $this;
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
}
