<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EtudiantRepository")
 */
class Etudiant implements UserInterface
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
    private $codeNip;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $classement;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Promotion", inversedBy="etudiants")
     */
    private $promotion;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Bac", inversedBy="etudiants")
     */
    private $bac;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Groupe", inversedBy="etudiants")
     */
    private $groupe;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Matiere", inversedBy="etudiantsPrincipal")
     */
    private $voeuPrincipal;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Matiere", inversedBy="etudiantsSecondaire")
     */
    private $voeuSecondaire;


    public function __toString(): ?string
    {
        $res = $this->prenom . $this->nom;
        return $res;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCodeNip(): ?string
    {
        return $this->codeNip;
    }

    public function setCodeNip(string $codeNip): self
    {
        $this->codeNip = $codeNip;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getClassement(): ?int
    {
        return $this->classement;
    }

    public function setClassement(?int $classement): self
    {
        $this->classement = $classement;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPromotion(): ?Promotion
    {
        return $this->promotion;
    }

    public function setPromotion(?Promotion $promotion): self
    {
        $this->promotion = $promotion;
        if (!$promotion->getEtudiants()->contains($this)) {
            $promotion->addEtudiant($this);
        }
        return $this;
    }

    public function getBac(): ?Bac
    {
        return $this->bac;
    }

    public function setBac(?Bac $bac): self
    {
        $this->bac = $bac;
        if (!$bac->getEtudiants()->contains($this)) {
            $bac->addEtudiant($this);
        }
        return $this;
    }

    public function getGroupe(): ?Groupe
    {
        return $this->groupe;
    }

    public function setGroupe(?Groupe $groupe): self
    {
        $this->groupe = $groupe;
        if (!$groupe->getEtudiants()->contains($this)) {
            $groupe->addEtudiant($this);
        }
        return $this;
    }

    public function eraseCredentials()
    {
    }
    public function getRoles()
    {
        return array('ROLE_ETUDIANT');
    }
    public function getPassword()
    {
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }
}
