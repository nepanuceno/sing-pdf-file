<?php 
namespace App\Request;

use App\Request\Request;
use App\Response\FileResponse;

class FileRequest
{
    private array $files;

    private const MAX_FILE_SIZE = 10 * 1024 * 1024; // 10MB
    private const ALLOWED_TYPES = ['application/pdf'];
    private const UPLOAD_DIR = __DIR__ . '/../../uploads/';


    public function __construct()
    {        
        $this->files = $_FILES;        
    }
   
    public function processMultipleFiles(): array {
        
        $processedFiles = [];
        
        if (!isset($this->files['pdfFiles'])) {
            return ['error' => 'Nenhum arquivo enviado'];
        }
        
        // Normalize file array
        $fileCount = count($this->files['pdfFiles']['name']);

        for ($i = 0; $i < $fileCount; $i++) {
            $fileInfo = [
                'original_name' => $this->files['pdfFiles']['name'][$i],
                'type' => $this->files['pdfFiles']['type'][$i],
                'tmp_name' => $this->files['pdfFiles']['tmp_name'][$i],
                'error' => $this->files['pdfFiles']['error'][$i],
                'size' => $this->files['pdfFiles']['size'][$i]
            ];            

            $processResult = $this->processFile($fileInfo);
            $processedFiles[] = $processResult;
        }

        return $processedFiles;
    }

    private function processFile(array $file): array {
        // Verificações de erro
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return [
                'success' => false,
                'filename' => $file['original_name'],
                'error' => $this->getUploadErrorMessage($file['error'])
            ];
        }

        // Validar tamanho
        if ($file['size'] > self::MAX_FILE_SIZE) {
            return [
                'success' => false,
                'filename' => $file['original_name'],
                'error' => 'Arquivo excede o tamanho máximo permitido'
            ];
        }

        // Validar tipo de arquivo
        $mimeType = mime_content_type($file['tmp_name']);
        if (!in_array($mimeType, self::ALLOWED_TYPES)) {
            return [
                'success' => false,
                'filename' => $file['original_name'],
                'error' => 'Tipo de arquivo não permitido'
            ];
        }

        // Gerar nome de arquivo único
        $newFilename = uniqid('pdf_') . '_' . $file['original_name'];
        $uploadPath = self::UPLOAD_DIR . $newFilename;        

        // Criar diretório de uploads se não existir
        if (!is_dir(self::UPLOAD_DIR)) {
            mkdir(self::UPLOAD_DIR, 0755, true);
        }

        // Mover arquivo
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            return [
                'success' => true,
                'filename' => $file['original_name'],
                'new_filename' => $newFilename,
                'size' => $file['size'],
                'mime_type' => $mimeType
            ];
        }

        return [
            'success' => false,
            'filename' => $file['original_name'],
            'error' => 'Falha ao salvar arquivo'
        ];
    }

    private function getUploadErrorMessage(int $errorCode): string {
        $errorMessages = [
            UPLOAD_ERR_INI_SIZE => 'Arquivo excede o tamanho máximo definido em php.ini',
            UPLOAD_ERR_FORM_SIZE => 'Arquivo excede o tamanho máximo definido no formulário',
            UPLOAD_ERR_PARTIAL => 'Upload do arquivo foi parcial',
            UPLOAD_ERR_NO_FILE => 'Nenhum arquivo foi enviado',
            UPLOAD_ERR_NO_TMP_DIR => 'Falta pasta temporária',
            UPLOAD_ERR_CANT_WRITE => 'Falha ao gravar arquivo em disco',
            UPLOAD_ERR_EXTENSION => 'Extensão PHP interrompeu upload'
        ];

        return $errorMessages[$errorCode] ?? 'Erro desconhecido no upload';
    }
}