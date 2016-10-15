<?php
namespace Model;
use Library\Request;
class ContactForm
{
    public $username;
    public $email;
    public $message;


    /**
     * ContactForm constructor.
     * @param $email
     * @param $message
     * @param $username
     */
    public function __construct(Request $request)
    {
        $this->username = $request->post('username');
        $this->email = $request->post('email');
        $this->message = $request->post('message');
    }

    public function isValid()
    {
        $res = $this->username !== '' && $this->email !== '' && $this->message !== '';
        return $res;
    }


}