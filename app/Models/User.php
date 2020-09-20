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
    public $lname;

    /* @var $email String */
    public $email;

    /* @var $password String */
    protected $password;

    /* @var $tableName String */
    protected $tableName = 'users';

    /* @var $token String */
    public $token;
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

    /**
     * function for generating a session token for the user
     */
    public function generate_session_token() {
        $this->token = uniqid(rand(), true);
    }

    /**
     * function for logging in the user, this is done by storing their session
     * in the database
     */
    public function login() {
        $this->generate_session_token();
        $this->update_values(['token' => $this->token]);
    }

    /**
     * function to check if the user is logged in by checking if their token is stored in
     * the database
     */
    public function is_logged_in() {
        return $this->find_unique_by_key('token');
    }

    /**
     * Function to log the user out by setting the stored token to null in the database
     */
    public function logout() {
        if($this->find_unique_by_key('token') !== false) {
            $this->update_values(['token' => null]);
        }
    }
}