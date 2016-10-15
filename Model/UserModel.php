<?php
namespace Model;

use Library\DbConnection;
class UserModel
{
    public function find($email, $password)
    {
        $db = DbConnection::getInstance()->getPdo();
        $sth = $db->prepare('select * from users where email = :email and password = :password and status = 1 ');
        $sth->execute(array(
            'email' => $email,
            'password' => $password
        ));
        
        $user = $sth->fetch(\PDO::FETCH_ASSOC);
        
        return $user;
    }
}