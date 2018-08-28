<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Entity\Etudiant;
use App\Entity\Bac;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;


class CsvWriter
{
    private $targetDirectory;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function bddToCsv($csv, $entityManager, $delimiter = ';')
    {
        $champs = $csv->getTypeCsv()->getChamps();
        $header = array();
        $datas = array();
        $row = array();
        $path = $this->getTargetDirectory().'/'.$csv->getFile();
        $p = fopen($path, 'w');
        foreach($champs as $champ)
        {
            array_push($header, $champ->getChampCsv()->getIntitule());
        }
        fputcsv($p, $header, $delimiter);
        $etudiants = $entityManager->getRepository(Etudiant::class)->findBy(['promotion' => $csv->getPromotion()]);
        foreach($etudiants as $etudiant)
        {
            foreach($champs as $champ)
            {
                array_push($row, $etudiant->getSpecificField($champ->getChampBdd()->getIntitule()));
            }
            fputcsv($p, $row, $delimiter);
            $row = array();
        }
        fclose($p);

        return $path;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}