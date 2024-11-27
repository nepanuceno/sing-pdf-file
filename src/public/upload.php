<?php 

use App\Request\FileRequest;
use App\Services\DownloadSignedFiles;
use App\Services\PDFUploader;
use App\Services\FileSigningTCPDF;
use App\Services\ZipAsignedFiles;

require_once dirname(__FILE__) . "/../../vendor/autoload.php";

header('Content-Type: application/json');

try {    
    $arrFileSigned = [];  
    $uploader = new PDFUploader();
    $resp = $uploader->handleUpload(new FileRequest());
    
    foreach($resp as $item) {        
        $arrFileSigned[] = (new FileSigningTCPDF($item['filename'], $item['new_filename']))->sing();
    }
    
    $zipFile = (new ZipAsignedFiles())->zip($arrFileSigned);
    (new DownloadSignedFiles( $zipFile));
    // echo json_encode(['status'=>true,'message' => 'Sucesso!', 'zipFile' =>  $zipFile]);
    
 } catch (Exception $e) {
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
 }
 