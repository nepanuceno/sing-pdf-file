<?php 
namespace App\Services;

use ZipArchive;

class ZipAsignedFiles
{
    public function __construct() {}

    public function zip($arrFileSigned): void {
        $zip = new ZipArchive();
        $zipFileName = "AsignedFiles.zip";

        if ($zip->open($zipFileName, ZipArchive::CREATE)!==TRUE) {
            exit("cannot open <$zipFileName>\n");
        }

        foreach($arrFileSigned as $file) {
            $file = __DIR__."/../public/Storage/".$file;
            if (file_exists($file)) {
                $zip->addFile($file, basename($file));
            }
        }
        
        $zip->close();
    }
}