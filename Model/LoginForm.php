<?php
namespace Model;
use Library\Request;
class LoginForm
{
    public $password;
    public $email;

    public function __construct(Request $request)
    {
        $this->email = $request->post('email');
        $this->password = $request->post('password');
    }

    public function isValid()
    {
        $res = $this->email !== '' && $this->password !== '';
        return $res;
    }
}