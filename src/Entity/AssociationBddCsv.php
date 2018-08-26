<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AssociationBddCsvRepository")
 */
class AssociationBddCsv
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ChampBDD", inversedBy="associationsBddCsv", cascade={"persist"})
     */
    private $champBdd;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ChampCsv", inversedBy="associationsBddCsv", cascade={"persist"})
     */
    private $champCsv;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeCsv", inversedBy="champs")
     */
    private $typeCsv;

    public function __construct()
    {

    }

    public function getId()
    {
        return $this->id;
    }

    public function getChampBdd(): ?ChampBDD
    {
        return $this->champBdd;
    }

    public function setChampBdd(?ChampBDD $champBdd): self
    {
        $this->champBdd = $champBdd;

        return $this;
    }

    public function getChampCsv(): ?ChampCsv
    {
        return $this->champCsv;
    }

    public function setChampCsv(?ChampCsv $champCsv): self
    {
        $this->champCsv = $champCsv;

        return $this;
    }

    public function getTypeCsv(): ?TypeCsv
    {
        return $this->typeCsv;
    }

    public function setTypeCsv(?TypeCsv $typeCsv): self
    {
        $this->typeCsv = $typeCsv;

        return $this;
    }
}
