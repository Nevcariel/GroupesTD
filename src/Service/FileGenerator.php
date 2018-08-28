<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Entity\Csv;

class FileGenerator
{
    private $targetDirectory;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function generate(Csv $csv)
    {
        $fileName = md5(uniqid()).'.csv';

        $handle = fopen($this->getTargetDirectory().'/'.$fileName, 'w');

        fclose($handle);

        return $fileName;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}