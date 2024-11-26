<?php 
namespace App\Services;

use App\Request\FileRequest;

class PDFUploader {
 
    public function handleUpload(FileRequest $fileRequest) {

        $files = $fileRequest->processMultipleFiles();
    }
 }