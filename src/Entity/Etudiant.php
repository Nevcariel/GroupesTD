<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Column(type="string", length=255, nullable=true)
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
     * @ORM\Column(type="string", length=16, nullable=true)
     */
    private $classement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $username;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Promotion", inversedBy="etudiants")
     */
    private $promotion;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Bac", inversedBy="etudiants", cascade={"persist"})
     */
    private $bac;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Groupe", inversedBy="etudiants")
     */
    private $groupe;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Matiere", inversedBy="etudiantsPrincipal")
     * @Assert\Expression("this.getVoeuPrincipal() != this.getVoeuSecondaire() or this.getVoeuPrincipal() == null", message="Les deux voeux doivent être différents")
     */
    private $voeuPrincipal;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Matiere", inversedBy="etudiantsSecondaire")
     */
    private $voeuSecondaire;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $moyenne;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentaire;


    public function __toString(): ?string
    {
        $res = $this->prenom." ".$this->nom;
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

    public function getClassement(): ?string
    {
        return $this->classement;
    }

    public function setClassement(?string $classement): self
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
        return $this;
    }

    public function getBac(): ?Bac
    {
        return $this->bac;
    }

    public function setBac(?Bac $bac): self
    {
        $this->bac = $bac;
        return $this;
    }

    public function getGroupe(): ?Groupe
    {
        return $this->groupe;
    }

    public function setGroupe(?Groupe $groupe): self
    {
        $this->groupe = $groupe;
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

    public function getVoeuPrincipal(): ?Matiere
    {
        return $this->voeuPrincipal;
    }

    public function setVoeuPrincipal(?Matiere $matiere): self
    {
        $this->voeuPrincipal = $matiere;
        return $this;
    }

    public function getVoeuSecondaire(): ?Matiere
    {
        return $this->voeuSecondaire;
    }

    public function setVoeuSecondaire(?Matiere $matiere): self
    {
        $this->voeuSecondaire = $matiere;
        return $this;
    }

    public function getMoyenne(): ?float
    {
        return $this->moyenne;
    }

    public function setMoyenne(?float $moyenne): self
    {
        $this->moyenne = $moyenne;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }
    public function setSpecificField($field, $data)
    {
        if($field == 'nom')
            $this->setNom($data);

        elseif($field == 'prenom')
            $this->setPrenom($data);
        
        elseif($field == 'codeNip')
            $this->setCodeNip($data);

        elseif($field == 'classement')
            $this->setClassement($data);
        
        elseif($field == 'commentaire')
            $this->setCommentaire($data);
        
        elseif($field == 'moyenne')
            $this->setMoyenne(floatval($data));
    }

    public function getSpecificField(string $field)
    {
        if($field == 'nom')
            return $this->nom;

        elseif($field == 'prenom')
        return $this->prenom;
        
        elseif($field == 'codeNip')
            return $this->codeNip;

        elseif($field == 'classement')
            return $this->classement;
        
        elseif($field == 'bac')
            return $this->bac;
        
        elseif($field == 'groupe')
            return $this->groupe;
        
        elseif($field == 'moyenne')
            return $this->moyenne;

        elseif($field == 'voeuPrincipal')
            return $this->voeuPrincipal;

        elseif($field == 'voeuSecondaire')
            return $this->voeuSecondaire;
    }
}
