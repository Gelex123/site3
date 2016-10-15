<?php
/**
 * Created by PhpStorm.
 * User: Gelex
 * Date: 22.09.2016
 * Time: 1:37
 */

namespace Model;


class RegistrationForm
{
    private $email;
    private $username;
    private $password;
    private $passwordConfirm;

    /**
     * @param array $data
     */
    public function __construct(Array $data)
    {
        $this->email = isset($data['email']) ? $data['email'] : null;
        $this->username = isset($data['username']) ? $data['username'] : null;
        $this->password = isset($data['password']) ? $data['password'] : null;
        $this->passwordConfirm = isset($data['passwordConfirm']) ? $data['passwordConfirm'] : null;
    }

    public function validate()
    {
        return !empty($this->email) && !empty($this->username) && !empty($this->password) && !empty($this->passwordConfirm) && $this->passwordsMatch();
    }

//    public function result()
//    {
//       $res = $db->query("SELECT * FROM users WHERE username = '{$this->username}'");
//    }

    /**
     * @param mixed|null $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @param mixed|null $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param mixed|null $passwordConfirm
     */
    public function setPasswordConfirm($passwordConfirm)
    {
        $this->passwordConfirm = $passwordConfirm;
    }

    /**
     * @return mixed|null
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed|null
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed|null
     */
    public function getPasswordConfirm()
    {
        return $this->passwordConfirm;
    }

    public function passwordsMatch()
    {
        return $this->password == $this->passwordConfirm;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
}