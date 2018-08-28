<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Entity\Csv;

class FileDeletor
{
    private $targetDirectory;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function delete(Csv $csv)
    {
        $filePath = $this->getTargetDirectory().'/'.$csv->getFile();
        unlink($filePath);
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}