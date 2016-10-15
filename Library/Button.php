<?php
/**
 * Created by PhpStorm.
 * User: Gelex
 * Date: 12.09.2016
 * Time: 14:47
 */

namespace Library;


use Model\ClothesModel;

class Button
{
    public $page;
    public $text;
    public $isActive;

    public function __construct($page, $isActive = true, $text = null)
    {
        $this->page = $page;
        $this->text = is_null($text) ? $page : $text;
        $this->isActive = $isActive;
    }

    public function activate()
    {
        $this->isActive = true;
    }

    public function deactivate()
    {
        $this->isActive = false;
    }
}