<?php
namespace Library;
class UploadedFile
{
    const MAX_SIZE = 500000;
    private $name;
    private $error;
    private $tmp_name;
    private $type;
    private $size;


    public function __construct(array $fileArray)
    {
        foreach ($fileArray as $key => $value) {
            $this->$key = $value;
        }
    }

    public function isJpeg()
    {
        
    }

    public function isPng()
    {
        
    }

    public function isImage()
    {
        return strpos($this->type, 'image');
    }

    public function getErrorText()
    {
        
    }
}