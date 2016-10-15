<?php
/**
 * Created by PhpStorm.
 * User: Gelex
 * Date: 22.09.2016
 * Time: 1:49
 */

namespace Controller;


use Library\Controller;
use Library\Request;
use Library\DB;
use Library\Config;
use Library\Password;
use Library\Router;
use Library\Session;
use Model\RegistrationForm;

class RegistrationController extends Controller
{
    public function indexAction(Request $request)
    {
        $db = new DB(Config::get('host'), Config::get('user'), Config::get('pass'), Config::get('dbname'));
        $form = new RegistrationForm($_POST);
        Session::setFlash(null);
        if ($request->isPost()) {
            if ($form->validate()) {
                $email = $db->escape($form->getEmail());
                $username = $db->escape($form->getUsername());
                $password = new Password( $db->escape($form->getPassword()) );
                $res = $db->query("SELECT * FROM users WHERE username = '{$username}'");
                Session::setFlash('');
                if ($res) {
                    Session::setFlash('Такой пользователь уже существует');
                } else {
                    $db->query("INSERT INTO users (email, username, password) VALUES ('{$email}','{$username}','{$password}')");
                    Session::setFlash('Вы успешно зарегестрированы');
                    Router::redirect('/registration');
                }
            } else {
                Session::setFlash("{$form->passwordsMatch()}" ? 'Заполните пожалуйста все поля' : 'Пароль не совпадает');
            }
        }
        $args = array(
            'db' => $db,
            'form' => $form
        );
        return $this->render('registration', $args);
    }

}
