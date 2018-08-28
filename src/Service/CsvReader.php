<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Entity\Etudiant;
use App\Entity\Bac;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;


class CsvReader
{
    private $targetDirectory;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function importDataFromCsv($file, $entityManager)
    {
        $champs = $file->getTypeCsv()->getChamps();

        $data = $this->csvToArray($this->getTargetDirectory()."/".$file->getFile());

        $promotion = $file->getPromotion();

        $promotion->removeCsv($file);
        $entityManager->persist($promotion);
        $entityManager->remove($file);
        $entityManager->flush();

        foreach($data as $row)
        {
            $etudiant = new Etudiant();
            foreach($champs as $champ)
            {
                

                $etudiant->setPromotion($promotion);

                if($champ->getChampBdd()->getIntitule() == 'bac')
                {
                    if($bac = $entityManager->getRepository(Bac::class)->findOneBy(['abreviation' => $row[$champ->getChampCsv()->getIntitule()]]))
                    {
                        $bac->addEtudiant($etudiant);
                    }
                    else
                    {
                        $bac = new Bac();
                        $bac->setAbreviation($row[$champ->getChampCsv()->getIntitule()]);
                        $bac->setIntitule($row[$champ->getChampCsv()->getIntitule()]);
                        $bac->addEtudiant($etudiant);
                        $entityManager->persist($etudiant);
                        $entityManager->flush();
                    }
                }
                else
                {
                    $etudiant->setSpecificField($champ->getChampBdd()->getIntitule(), $row[$champ->getChampCsv()->getIntitule()]);
                }
            }
            foreach($champs as $champ)
            {
                if($champ->getChampBdd()->getIntitule() == 'codeNip')
                {
                    $nom = strtolower($etudiant->getNom());
                    $etudiant->setUsername($nom[0].$etudiant->getCodeNip());
                }
            }
            $entityManager->persist($etudiant);
        }
        $entityManager->flush();
    }

    public function updateDataFromCsv($file, $entityManager)
    {
        $data = $this->csvToArray($this->getTargetDirectory()."/".$file->getFile());

        $champs = $file->getTypeCsv()->getChamps();

        $nomPrenom = array();
        $codeNip = null;
        $promotion = $file->getPromotion();

        $promotion->removeCsv($file);
        $entityManager->persist($promotion);
        $entityManager->remove($file);
        $entityManager->flush();

        foreach($data as $row)
        {
            foreach($champs as $champ)
            {
                if($champ->getChampBdd()->getIntitule() == 'codeNip')
                {
                    $codeNip = $row[$champ->getChampCsv()->getIntitule()];
                }
            }
            if(isset($codeNip) && $etudiant = $entityManager->getRepository(Etudiant::class)->findOneBy(['codeNip' => $codeNip, 'promotion' => $promotion]))
            {
                foreach($champs as $champ)
                {
                    if(!$etudiant->getSpecificField($champ->getChampBdd()->getIntitule()))
                    {
                        $etudiant->setSpecificField($champ->getChampBdd()->getIntitule(), $row[$champ->getChampCsv()->getIntitule()]);
                        $entityManager->persist($etudiant);
                    }
                }
            }
            else
            {
                foreach($champs as $champ)
                {  
                    if($champ->getChampBdd()->getIntitule() == 'nom')
                        $nomPrenom['nom'] = $row[$champ->getChampCsv()->getIntitule()];

                    elseif($champ->getChampBdd() == 'prenom')
                        $nomPrenom['prenom'] = $row[$champ->getChampCsv()->getIntitule()];
                }
                $etudiant = $entityManager->getRepository(Etudiant::class)->findOneBy(['nom' => $nomPrenom['nom'], 'prenom' => $nomPrenom['prenom'], 'promotion' => $promotion]);
                if(isset($etudiant))
                {
                    foreach($champs as $champ)
                    {
                        if(!$etudiant->getSpecificField($champ->getChampBdd()->getIntitule()))
                        {
                            $etudiant->setSpecificField($champ->getChampBdd()->getIntitule(), $row[$champ->getChampCsv()->getIntitule()]);
                            $entityManager->persist($etudiant);
                        }
                    }
                }
                foreach($champs as $champ)
                {
                    if($champ->getChampBdd()->getIntitule() == 'codeNip')
                    {
                        $nom = strtolower($etudiant->getNom());
                        $etudiant->setUsername($nom[0].$etudiant->getCodeNip());
                    }
                }
            }
            
        }
        $entityManager->flush();
    }
    /**
     * Useless
     */
    public function importEtudiantsFromCsv($file, $promotion, $entityManager)
    {
        $data = $this->csvToArray($this->getTargetDirectory()."/".$file->getFile());

        $promotion->removeCsv($file);
        $entityManager->persist($promotion);
        $entityManager->remove($file);
        $entityManager->flush();

        foreach($data as $row)
        {
            $etudiant = new Etudiant();
            $etudiant->setNom($row['nom']);
            $etudiant->setPrenom($row['prenom']);
            $etudiant->setCodeNIP($row['code_nip']);
            $nom = strtolower($etudiant->getNom());
            $etudiant->setUsername($nom[0].$etudiant->getCodeNip());
            $promotion->addEtudiant($etudiant);
            if(($bac = $entityManager->getRepository(Bac::class)->findOneBy(['abreviation' => $row['bac']]))!= null)
            {
                $bac->addEtudiant($etudiant);
            }
            else
            {
                $bac = new Bac();
                $bac->setAbreviation($row['bac']);
                $bac->addEtudiant($etudiant);
                $entityManager->persist($etudiant);
                $entityManager->flush();
            }
            
            $entityManager->persist($etudiant);
        }
        $entityManager->flush();
        
    }
    
    /**
     * Useless
     */
    public function updateEtudiantsFromCsv($file, $promotion, $entityManager)
    {
        $data = $this->csvToArray($this->getTargetDirectory()."/".$file->getFile());

        $promotion->removeCsv($file);
        $entityManager->persist($promotion);
        $entityManager->remove($file);
        $entityManager->flush();

        foreach($data as $row)
        {
            $etudiant = $entityManager->getRepository(Etudiant::class)->findOneBy(['codeNip' => $row['code_nip'], 'promotion' => $promotion]);
            if($etudiant)
            {
                $etudiant->setClassement($row['Rg']);
                $etudiant->setMoyenne(floatval($row['Moy']));
                $entityManager->persist($etudiant);
            }
            $entityManager->flush();
        }
        
    }

    public function csvToArray($filePath, $delimiter = ';')
    {
        if(!file_exists($filePath) || !is_readable($filePath)) 
        {
            return false;
        }
        
        $header = NULL;
        $data = array();
        
        if (($handle = fopen($filePath, 'r')) !== FALSE) 
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) 
            {
                if(!$header) 
                {
                    $header = $row;
                } 
                else 
                {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }
        unlink($filePath);

        return $data;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}