<?php
/**
 * Created by PhpStorm.
 * User: Gelex
 * Date: 25.09.2016
 * Time: 3:38
 */

namespace Model;

use Library\Cart;
use Library\DbConnection;
use Library\Config;

class CartModel
{
    public function order($itemCount)
    {
        $db = DbConnection::getInstance()->getPdo();
        $sql = "SELECT * FROM clothes WHERE id IN ({$id_sql})";
        $clothess = $db->query($sql);
        return $clothess;
    }
}