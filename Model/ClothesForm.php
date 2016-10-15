<?php
namespace Model;

use Library\Request;
use Library\UploadedFile;

class ClothesForm
{
    public $title;
    public $price;
    public $description;
    public $style;

    /**
     * @var UploadedFile
     */
    public $attachment;


    /**
     * ContactForm constructor.
     * @param $email
     * @param $message
     * @param $username
     */
    public function __construct(Request $request)
    {
        $this->title = $request->post('title');
        $this->price = $request->post('price');
        $this->description = $request->post('description');
        $this->style = $request->post('style');
        $this->image = $request->files('document');
    }

    public function isValid()
    { 
        $res = $this->title !== '' && $this->price !== '' && $this->description !== '';

        $res = $res && $this->attachment->isImage();
        return $res;
    }

    public function setFromArray(array $clothes)
    {
        $this->title = $clothes['title'];
        $this->price = $clothes['price'];
        $this->description = $clothes['description'];
        $this->style = $clothes['style'];
    }

}