<?php 

class FileResponse
{
    public $name;
    public $fullPath;
    public $tempName;
    public $type;
    public $size;
    public $error;

    public function __construct() {
        $this->name = '';
        $this->fullPath = '';
        $this->tempName = '';
        $this->type = '';
        $this->size = '';
        $this->error = '';
     }
}