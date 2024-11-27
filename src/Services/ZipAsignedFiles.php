<?php 
namespace App\Services;

use ZipArchive;

class ZipAsignedFiles
{
    public function __construct() {}

    public function zip(array $arrFileSigned): string {
        $zip = new ZipArchive();
        $zipFileName = "./Storage/AsignedFiles.zip";

        if ($zip->open($zipFileName, ZipArchive::CREATE)!==TRUE) {
            exit("cannot open <$zipFileName>\n");
        }

        foreach($arrFileSigned as $file) {
            $filePath = __DIR__."/../public/Storage/".$file;
            if (file_exists($filePath)) {
                $zip->addFile($filePath, basename($file));
            }
        }
        
        $zip->close();
        $this->deleteFiles($arrFileSigned);
        
        return basename($zipFileName);
    }

    private function deleteFiles(array $arrFileSigned): void {
        foreach($arrFileSigned as $file) {
            unlink( $filePath = __DIR__."/../public/Storage/".$file);
        }
    }

}