<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 28/06/18
 * Time: 21:41
 */

namespace AppBundle\Services;

class Zip
{
    private $ecfDirectory;
    private $zipDirectory;

    public function __construct($zipDirectory, $ecfDirectory)
    {
        $this->ecfDirectory = $ecfDirectory;
        $this->zipDirectory = $zipDirectory;
    }

    public function zipFolder(){
        $zip = new \ZipArchive();

        //TODO: add real campus
        if (!file_exists($this->zipDirectory)) {
            mkdir($this->zipDirectory, 0777, true);
        }
        $zip->open($this->zipDirectory . 'paris_ecf.zip', \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

// Initialize empty "delete list"
        $filesToDelete = array();

// Create recursive directory iterator
        /** @var SplFileInfo[] $files */
        $files = new \RecursiveIteratorIterator(

            //TODO: Add real campus
            new \RecursiveDirectoryIterator($this->ecfDirectory . 'Paris'),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file)
        {
            // Skip directories (they would be added automatically)
            if (!$file->isDir())
            {
                // Get real and relative path for current file
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($this->ecfDirectory) + 1);

                // Add current file to archive
                $zip->addFile($filePath, $relativePath);
                $filesToDelete[] = $filePath;
            }
        }

        // Zip archive will be created only after closing object
        $zip->close();

        // Delete all files from "delete list"
        foreach ($filesToDelete as $file)
        {
            unlink($file);
        }

        //TODO: Add real campus
        return ['filename' => 'paris_ecf.zip', 'path_to_zip' => $this->zipDirectory . 'paris_ecf.zip'];
    }
}