<?php

/**
 * User class, this will be used as the object to represent the logged in user
 */
namespace App\Models;


class User extends Model
{
    /* @var $fname String */
    public $fname;

    /* @var $lname String */
    public  $lname;

    /* @var $email String */
    protected $email;

    /* @var $password String */
    private $password;

    /**
     * User constructor.
     * @param $email
     * @param $password
     */
    public function __construct($email, $password)
    {
        parent::__construct();
        $this->email = $email;
        $this->password = $this->encrypt_password($password);
    }

    /**
     * Function to encrypt the inputted password
     * @param $password
     * @return false|string|null
     */
    private function encrypt_password($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}