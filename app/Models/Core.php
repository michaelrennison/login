<?php


namespace App\Models;


use PDO;

class Core
{
    // Database connection variable
    public $db;
    // Instance variable to return to models to call database functions
    private static $instance;

    private function __construct()
    {
        // Get the database connection from the db connection files
        $host = DB_HOST;
        $user = DB_USER;
        $pass = DB_PASS;
        $port = DB_PORT;
        $name = DB_NAME;

        // Connect to the DB using pdo
        $this->db = new PDO("mysql:host=$host:$port;dbname=$name", "$user", "$pass");
    }

    /**
     * Return an instance of this model
     */
    public static function getInstance()
    {
        if (!isset(self::$instance))
        {
            $object = __CLASS__;
            self::$instance = new $object;
        }
        return self::$instance;
    }

    /**
     * Function for concatenating values for an SQL string to be returned
     * in the structure (value_1, value_2, value_3)
     * @param $values
     * @return string
     */
    public function concatenate_db_strings($values) {
        // define the string for the insert query
        $str = "(";
        foreach ($values as $key => $value) {
            // Check if this is the last element in the array
            reset($values);
            end($values);
            if ($key === key($values)) {
                $str .= " $value";
            } else {
                $str .= "$value,";
            }
        }
        $str .= ")";

        return $str;
    }

    public function add_slashes($array) {
        return array_map(function($str) {
            return "'$str'";
        }, $array);
    }
}