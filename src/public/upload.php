<?php 

use App\Request\FileRequest;
use App\Services\PDFUploader;
use App\Services\FileSigningTCPDF;

require_once dirname(__FILE__) . "/../../vendor/autoload.php";

// header('Content-Type: application/json');

try {      
    $uploader = new PDFUploader();
    $resp = $uploader->handleUpload(new FileRequest());
    
    foreach($resp as $item) {        
        (new FileSigningTCPDF($item['filename'], $item['new_filename']))->sing();
    }

    // echo json_encode(['status'=>true,'message' => 'Sucesso!']);
    
 } catch (Exception $e) {
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
 }
 