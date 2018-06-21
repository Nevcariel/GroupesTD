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

    public function importEtudiantsFromCsv($fileName, $promotion, $entityManager)
    {
        $data = $this->csvToArray($this->getTargetDirectory()."/".$fileName);

        foreach($data as $row)
        {
            $etudiant = new Etudiant();
            $etudiant->setNom($row['nom_usuel']);
            $etudiant->setPrenom($row['prenom']);
            $etudiant->setCodeNIP($row['code_nip']);
            $nom = strtolower($etudiant->getNom());
            $etudiant->setUsername($nom[0].$etudiant->getCodeNip());
            $etudiant->setPromotion($promotion);
            if(($bac = $entityManager->getRepository(Bac::class)->findOneBy(['abreviation' => $row['bac']]))!= null)
            {
                $etudiant->setBac($bac);
            }
            else
            {
                $bac = new Bac();
                $bac->setAbreviation($row['bac']);
                $entityManager->persist($bac);
                $etudiant->setBac($bac);
                $entityManager->persist($etudiant);
                $entityManager->flush();
            }
            
            $entityManager->persist($etudiant);
        }
        $entityManager->flush();
        
    }
    public function updateEtudiantsFromCsv($fileName)
    {
        $data = csvToArray($targetDirectory."/".$fileName);
        $entityManager = $this->getDoctrine()->getManager();

        foreach($date as $row)
        {
            
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