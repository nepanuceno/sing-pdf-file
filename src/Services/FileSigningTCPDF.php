<?php

namespace App\Services;

use setasign\Fpdi\Tcpdf\Fpdi;

class FileSigningTCPDF
{
    public function __construct(
        private string $filename, 
        private string $tempFileName
    ){}

    public function sing(): string
    {
        //Endereço do arquivo do certificado
        //Obs.: Tentei usar o certificado no formato PFX e não funcionou
        //Para converter use o comando no Prompt do Windows ou Terminal do Linux:
        //openssl pkcs12 -in certificado.pfx -out tcpdf.crt -nodes
        $cert = '../../certified/cert.crt';

        //Informações da assinatura - Preencha com os seus dados
        $info = array(
           'Name' => 'Paulo Roberto Torres',
           'Location' => 'Palmas',
           'Reason' => 'Teste de Assinatura de arquivo PDF com certificado SSL .crt',
           'ContactInfo' => 'paulo.torres.apps@gmail.com',
        );

        $pdf = new Fpdi();

        // set document information
        $pdf->SetCreator('Paulo Torres');
        $pdf->SetAuthor('Paulo Roberto Torres');
        $pdf->SetTitle('TCPDF Example');
        $pdf->SetSubject('PDF Asign');
        $pdf->SetKeywords('TCPDF, PDF, RSA, example, test, guide');

        //Configura a assinatura. Para saber mais sobre os parâmetros
        //consulte a documentação do TCPDF, exemplo 52.
        //Não esqueça de mudar 'senha' para a senha do seu certificado
        $pdf->setSignature('file://'.$cert, 'file://'.realpath($cert), 'senha','', 2, $info);

        //Importa uma página
        $pdf->AddPage();

        // set font
        // $pdf->SetFont('helvetica', '', 12);

        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // *** set signature appearance ***

        // create content for signature (image and/or text)
        $pdf->Image('../../files/stamp-certificate.png', 90, 200, 25, 25, 'PNG');

        // define active area for signature appearance
        $pdf->setSignatureAppearance(90, 220, 25, 25);

        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

        // *** set an empty signature appearance ***
        $pdf->addEmptySignatureAppearance(90, 250, 25, 25);


        $pathTempFile = __DIR__ . '/../../uploads/'.$this->tempFileName;

        $pdf->setSourceFile($pathTempFile);

        unlink($pathTempFile);
        
        $tplId = $pdf->importPage(1);
        $pdf->useTemplate($tplId, 0, 0); //Importa nas medidas originais

        $fileAsign = 'asign-'.$this->filename;

        //Manda o PDF pra download
        $pdf->Output(__DIR__ . '/../public/Storage/'.$fileAsign, 'F');

        return $fileAsign;
    }
}

