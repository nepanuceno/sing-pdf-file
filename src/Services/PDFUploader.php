<?php 
namespace App\Services;

use App\Request\FileRequest;

class PDFUploader {
    private const MAX_FILE_SIZE = 10 * 1024 * 1024; // 10MB
    private const UPLOAD_DIR = __DIR__ . '/uploads/';

 
    public function handleUpload(FileRequest $fileRequest): array {

        $files = $fileRequest->getInfoFiles();
                var_dump($files) or die();
                
        if (!isset($_FILES['pdfFile'])) {
            return ['success' => false, 'message' => 'Nenhum arquivo enviado'];
        }
 
        $file = $_FILES['pdfFile'];
 
        // Validações
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'message' => 'Erro no upload'];
        }
 
        if ($file['size'] > self::MAX_FILE_SIZE) {
            return ['success' => false, 'message' => 'Arquivo excede o tamanho máximo'];
        }
 
        $mimeType = mime_content_type($file['tmp_name']);
        if ($mimeType !== 'application/pdf') {
            return ['success' => false, 'message' => 'Apenas arquivos PDF são permitidos'];
        }
 
        // Gerar nome de arquivo único
        $fileName = uniqid('pdf_') . '.pdf';
        $uploadPath = self::UPLOAD_DIR . $fileName;
 
        // Criar diretório de uploads se não existir
        if (!is_dir(self::UPLOAD_DIR)) {
            mkdir(self::UPLOAD_DIR, 0755, true);
        }
 
        // Mover arquivo
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            return [
                'success' => true, 
                'message' => 'Upload concluído', 
                'filename' => $fileName
            ];
        }
 
        return ['success' => false, 'message' => 'Falha ao salvar arquivo'];
    }
 }