<?php

use App\Request\FileRequest;
use App\Services\PDFUploader;

require_once dirname(__FILE__) . "/../../vendor/autoload.php";
require_once dirname(__FILE__) ."/../Views/form.html";

try {      
   $uploader = new PDFUploader();
   $result = $uploader->handleUpload(new FileRequest());
   
} catch (Exception $e) {
   header('HTTP/1.1 500 Internal Server Error');
   echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
