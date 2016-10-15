<?php
/**
 * Created by PhpStorm.
 * User: Gelex
 * Date: 25.09.2016
 * Time: 1:37
 */

namespace Controller;


use Library\Controller;
use Library\Cart;
use Library\Request;
use Library\Cookie;
use Library\Router;
use Library\Session;
use Library\Config;
use Library\DB;

class CartController extends Controller
{
    public function indexAction(Request $request)
    {
        $cart = new Cart();
        $getAction = $request->get('action');
        $action = isset($getAction) ? $getAction : 'list';
        $db = new Db(Config::get('host'), Config::get('user'), Config::get('pass'), Config::get('dbname'));
        
        if ($action == 'add') {
            $id = $request->get('id');
            $cart->addProduct($id);
            Router::redirect('/cart?');
        } elseif ($action == 'delete') {
            $id = $request->get('id');
            $cart->deleteProduct($id);
            Router::redirect('/cart?');
        } elseif ($action == 'clear') {
            $cart->clear();
            Router::redirect('/clothes-1.html');
        }
        else {
            if ($cart->isEmpty()) {
                Session::setFlash('Корзина пуста');
                $clothess = '';
            } else {
                $id_sql = $cart->getProducts(true);
                $sql = "SELECT * FROM clothes WHERE id IN ({$id_sql})";
                $clothess = $db->query($sql);
                
            }
        }
        $args = array(
            'cart' => $cart,
            'clothess' => $clothess
        );

        return $this->render('index', $args);
    }

}