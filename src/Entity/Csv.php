<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CsvRepository")
 */
class Csv
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     *
     * 
     * @Assert\File(mimeTypes={"text/plain"})
     */
    private $file;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Promotion", inversedBy="csvs")
     */
    private $promotion;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeCsv", inversedBy="csvs")
     */
    private $typeCsv;


    public function __construct()
    {
        
    }

    public function setFile($file)
    {
        $this->file = $file;
        return $file;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPromotion(): ?Promotion
    {
        return $this->promotion;
    }

    public function setPromotion(?Promotion $promotion): self
    {
        $this->promotion = $promotion;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
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