<?php
/**
 * Default model class, this will be extended by other models to access the database
 */
namespace App\Models;

class Model
{
    // value for the core model to be used to call global functions
    protected $core;
    /**
     * Define the var for the table name
     *
     * @var $tableName String
     */
    private $tableName;

    public function __construct()
    {
        $this->core = Core::getInstance();
    }

    /**
     * Function for inserting values into the database for the given model
     * @param $values
     * @return mixed
     */
    private function insert($values) {
        // Get the keys for the table
        $keys = array_keys($values);

        // Get the key string for the sql insert
        $keyStr = $this->core->concatenate_db_strings($keys);
        // get the value string for the sql insert
        $valStr = $this->core->concatenate_db_strings($values);

        // insert the values into the database
        $insStr = "INSERT INTO $this->tableName $keyStr VALUES $valStr";
        // return the result
        return $this->core->db->query($insStr);
    }
}