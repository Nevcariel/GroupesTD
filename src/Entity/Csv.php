<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @ORM\Entity
 * @Vich\Uploadable
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
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="upload_csv", fileNameProperty="csvName", size="csvSize")
     * 
     * @var File
     */
    private $csvFile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $csvName;

    /**
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    private $csvSize;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Promotion", inversedBy="csvs")
     */
    private $promotion;


    public function __construct()
    {
        $this->updateAt = new \DateTime('now');
    }
    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $csv
     */
    public function setCsvFile(?File $csv = null): void
    {
        $this->csvFile = $csv;

        if (null !== $csv) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getCsvFile(): ?File
    {
        return $this->csvFile;
    }

    public function setCsvName(?string $csvName): void
    {
        $this->csvName = $csvName;
    }

    public function getCsvName(): ?string
    {
        return $this->csvName;
    }
    
    public function setCsvSize(?int $csvSize): void
    {
        $this->csvSize = $csvSize;
    }

    public function getCsvSize(): ?int
    {
        return $this->csvSize;
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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}