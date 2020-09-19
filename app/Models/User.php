<?php

/**
 * User class, this will be used as the object to represent the logged in user
 */
namespace App\Models;


class User extends Model
{
    /* @var $id integer */
    protected $id;

    /* @var $fname String */
    public $fname;

    /* @var $lname String */
    public $lname;

    /* @var $email String */
    public $email;

    /* @var $password String */
    protected $password;

    /* @var $tableName String */
    protected $tableName = 'users';

    /**
     * Encrypt the password when it is assigned
     * @param String $password
     */
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * @param String $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function authenticate($password) {
        return password_verify($password, $this->password);
    }
}