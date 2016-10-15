<?php
namespace Controller;

use Library\Controller;
use Library\Password;
use Library\Request;
use Library\Router;
use Library\Session;
use Library\Cookie;
use Model\LoginForm;
use Model\UserModel;

class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {
        /**
         * @param Request $request
         * @return string
         * @throws \Library\\Exception
         */
        $form = new LoginForm($request);
        $status = true;
        if ($request->isPost()) {
            if ($form->isValid()) {
                if ($status) {
                    if (isset($_POST['remember'])) {
                        Cookie::set('email', $form->email);
                        Cookie::set('password', $form->password);
                    }
                }
                $model = new UserModel();
                $password = new Password($form->password);

                if ($user = $model->find($form->email, $password)) {
                    Session::set('user', $user['email']);

                    Router::redirect('/admin');
                }

                Session::setFlash('Неправильный пароль');
                Router::redirect('/login');
            }

            Session::setFlash('Fill the fields');
        } elseif ($_COOKIE) {
            $form->email = isset($_COOKIE['email']) ? $_COOKIE['email'] : null;
            $form->password = isset($_COOKIE['password']) ? $_COOKIE['password'] : null;
            $model = new UserModel();
            $password = new Password($form->password);
            if ($user = $model->find($form->email, $password)) {
                Session::set('user', $user['email']);
                Router::redirect('/');
            }
        }

        return $this->render('login', array('form' => $form));
    }

    public function logoutAction(Request $request)
    {
        Cookie::remove('email');
        Cookie::remove('password');
        Session::remove('user');
        Router::redirect('/login');
    }

   
}