<?php 
namespace App\Request;

use App\Request\Request;

class FileRequest
{
    private array $files;
    private array $arrNames;
    private array $arrFullPath;
    private array $arrTempNames;
    private array $arrType;
    private array $arrSize;
    private array $arrError;

    public function __construct()
    {        
        $this->files = $_FILES;
    }


    public function getInfoFiles(): void
    {
        foreach($this->files as $key => $files){

            foreach($files['name'] as $name) {
                $this->arrNames[] = $name;
            }

            foreach($files['full_path'] as $fullPath) {
                $this->arrFullPath[] = $fullPath;
            }

            foreach($files['type'] as $type) {
                $this->arrType[] = $type;
            }  

            foreach($files['tmp_name'] as $tmpName) {
                $this->arrTempNames[] = $tmpName;
            } 

            foreach($files['error'] as $error) {
                $this->arrError[] = $error;
            } 

            foreach($files['size'] as $size) {
                $this->arrSize[] = $size;
            } 
        }
    
        // array(1) { 
        //     ["pdfFiles"] => array(6) { 
        //         ["name"]=> array(3) { 
        //             [0]=> string(45) "contracheque-paulo-roberto-torres-09_2024.pdf" 
        //             [1]=> string(13) "RECADO JM.pdf" 
        //             [2]=> string(11) "09-2024.pdf" 
        //         } ["full_path"]=> array(3) { 
        //             [0]=> string(45) "contracheque-paulo-roberto-torres-09_2024.pdf" 
        //             [1]=> string(13) "RECADO JM.pdf" 
        //             [2]=> string(11) "09-2024.pdf" 
        //         } 
        //         ["type"]=> array(3) { 
        //             [0]=> string(15) "application/pdf" 
        //             [1]=> string(15) "application/pdf" 
        //             [2]=> string(15) "application/pdf" 
        //         } 
        //         ["tmp_name"]=> array(3) { 
        //             [0]=> string(27) "/tmp/phpdgu36dopa42m4z4u1Tt" 
        //             [1]=> string(27) "/tmp/php53j9r4gn8lbcf6jgt0r" 
        //             [2]=> string(27) "/tmp/phpdju40pckkf1kcf5D74l" 
        //         } 
        //         ["error"]=> array(3) { 
        //             [0]=> int(0) 
        //             [1]=> int(0) 
        //             [2]=> int(0) 
        //         }
        //         ["size"]=> array(3) {
        //             [0]=> int(11841) 
        //             [1]=> int(14076) 
        //             [2]=> int(116401) 
        //         } 
        //     } 
        // }
    }
}