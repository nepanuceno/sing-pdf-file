<?php
namespace App\Services;

class DownloadSignedFiles {

    public function __construct(string $zipFileName) {

        $pathFile = __DIR__ . "/../public/Storage/".$zipFileName;
        header('Content-Description: File Transfer');
        header('Content-type: application/zip');
        header('Content-disposition: attachment; filename="'.basename($zipFileName).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize( $pathFile));
        
        readfile( $pathFile);
        unlink( $pathFile);
        
    }
}