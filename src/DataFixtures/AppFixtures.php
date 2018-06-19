<?php

namespace App\DataFixtures;

use App\Entity\Etudiant;
use App\Entity\Enseignant;
use App\Entity\Groupe;
use App\Entity\Matiere;
use App\Entity\Filiere;
use App\Entity\Bac;
use App\Entity\Promotion;
use Doctrine\Bundle\FixturesBundle\Fixture; 
use Doctrine\Common\Persistence\ObjectManager;



class AppFixtures extends Fixture 
{
    public function load(ObjectManager $manager) 
    {  
        $groupe1 = new Groupe();
        $groupe1->setNom("Groupe 1");
        $groupe1->setTaille(4);
        $manager->persist($groupe1);

        $groupe2 = new Groupe();
        $groupe2->setNom("Groupe 2");
        $groupe2->setTaille(4);
        $manager->persist($groupe2);

        $manager->flush();
        
        $filieres = new Filiere();
        $filieres->setIntitule("Sciences");
        $filieres->setAbreviation("S");
        $manager->persist($filieres);

        $filierel = new Filiere();
        $filierel->setIntitule("Littéraire");
        $filierel->setAbreviation("L");
        $manager->persist($filierel);

        $filierees = new Filiere();
        $filierees->setIntitule("Economique et Social");
        $filierees->setAbreviation("ES");
        $manager->persist($filierees);

        $filieresti2d= new Filiere();
        $filieresti2d->setIntitule("Sciences et Technologies de l'Industrie et du Développement Durable");
        $filieresti2d->setAbreviation("STI2D");
        $manager->persist($filieresti2d);
        
        $manager->flush();

        $bacs = new Bac();
        $bacs->setFiliere($filieres);
        $manager->persist($bacs);

        $bacl = new Bac();
        $bacl->setFiliere($filierel);
        $manager->persist($bacl);

        $baces = new Bac();
        $baces->setFiliere($filierees);
        $manager->persist($baces);

        $manager->flush();

        $promo1 = new Promotion();
        $promo1->setAnneeDebut(2017);
        $promo1->setAnneeFin(2019);
        $manager->persist($promo1);
        $groupe1->setPromotion($promo1);
        $manager->persist($groupe1);


        $manager->flush();

        $alain = new Etudiant();
        $alain->setNom("Truc");
        $alain->setPrenom("Alain");
        $alain->setGroupe($groupe1);
        $alain->setBac($bacs);
        $alain->setPromotion($promo1);
        $manager->persist($alain);
        $groupe1->addEtudiant($alain);
        $manager->persist($groupe1);
        
        $jean = new Etudiant();
        $jean->setNom("Machin");
        $jean->setPrenom("Jean");
        $jean->setGroupe($groupe1);
        $jean->setBac($bacs);
        $jean->setPromotion($promo1);
        $manager->persist($jean);
        $groupe1->addEtudiant($jean);
        $manager->persist($groupe1);

        $jacques = new Etudiant();
        $jacques->setNom("Chose");
        $jacques->setPrenom("Jacques");
        $jacques->setGroupe($groupe1);
        $jacques->setBac($baces);
        $jacques->setPromotion($promo1);
        $manager->persist($jacques);
        $groupe1->addEtudiant($jacques);
        $manager->persist($groupe1);

        $robert = new Etudiant();
        $robert->setNom("Bidule");
        $robert->setPrenom("Robert");
        $robert->setGroupe($groupe1);
        $robert->setBac($bacl);
        $robert->setPromotion($promo1);
        $manager->persist($robert);
        $groupe1->addEtudiant($robert);
        $manager->persist($groupe1);
        
        $manager->flush();
        
        $enseignant1 = new Enseignant();
        $enseignant1->setNom("Demory");
        $enseignant1->setPrenom("Jean-Philippe");
        $manager->persist($enseignant1);

        $enseignant2 = new Enseignant();
        $enseignant2->setNom("Marhic");
        $enseignant2->setPrenom("Bruno");
        $manager->persist($enseignant2);

        $enseignant3 = new Enseignant();
        $enseignant3->setNom("Masson");
        $enseignant3->setPrenom("Jean-Baptiste");
        $manager->persist($enseignant3);

        $mat1 = new Matiere();
        $mat1->setIntitule("Certification CISCO");
        $mat1->setDescription("Préparation et passage de la certification officielle CISCO. Matière orientée réseaux.");
        $mat1->addEnseignant($enseignant1);
        $manager->persist($mat1);

        $manager->flush();

        $mat2 = new Matiere();
        $mat2->setIntitule("Traitement de l'information");
        $mat2->setDescription("Mathématiques appliquées à l'analyse de données et au traitement d'images. Matière conseillée aux étudiants souhaitant poursuivre en études longues");
        $mat2->addEnseignant($enseignant2);
        $mat2->addEnseignant($enseignant3);
        $manager->persist($mat2);

        $manager->flush();

        $enseignant1->addMatiere($mat1);
        $manager->persist($enseignant1);
        $enseignant2->addMatiere($mat2);
        $manager->persist($enseignant2);
        $enseignant3->addMatiere($mat2);
        $manager->persist($enseignant3);

        $manager->flush();
        
    }

}