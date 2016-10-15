<?php
/**
 * Created by PhpStorm.
 * User: Gelex
 * Date: 25.09.2016
 * Time: 1:32
 */

namespace Library;

/**
 * Class Cart
 */
class Cart
{
    /**
     * Products array
     *
     * @var array|mixed
     */
    private $products;

    /**
     *  Constructor
     */
    function __construct()
    {
        $this->products = Cookie::get('Clothess') == null ?
            array()
            :
            unserialize(Cookie::get('Clothess'));
    }

    /**
     * products getter
     *
     * @return mixed
     */
    public function getProducts($for_sql = false)
    {
        if ($for_sql) {
            return implode(',', $this->products);
        }

        return $this->products;
    }

    /**
     * adding product
     *
     * @param $id
     */
    public function addProduct($id)
    {
        $id = (int)$id;

        if (!in_array($id, $this->products)) {
            array_push($this->products, $id);
        }

        Cookie::set('Clothess', serialize($this->products));
    }

    public function deleteProduct($id)
    {
        $id = (int)$id;

        $key = array_search($id, $this->products);
        if ($key !== false) {
            unset($this->products[$key]);
        }

        Cookie::set('Clothess', serialize($this->products));
    }

    public function clear()
    {
        Cookie::remove('Clothess');
    }

    public function isEmpty()
    {
        return !$this->products;
    }
}