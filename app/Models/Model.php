<?php
/**
 * Default model class, this will be extended by other models to access the database
 */
namespace App\Models;

class Model
{
    /**
     * Define an array for values that should not be included in database calls
     * @var array
     */
    private $noInsert = [
        'noInsert',
        'core',
        'db',
        'tableName'
    ];
    // value for the core model to be used to call global functions
    protected $core;
    /**
     * Define the var for the table name
     *
     * @var $tableName String
     */
    protected $tableName;

    public function __construct()
    {
        $this->core = Core::getInstance();
    }

    /**
     * Function for inserting values into the database for the given model
     * @return mixed
     */
    public function create() {
        // Get the object properties and remove the ones that should not be added to the DB
        $values = $this->remove_non_db_properties(get_object_vars($this));

        // Get the keys for the table
        $keys = array_keys($values);

        // Get the key string for the sql insert
        $keyStr = $this->core->concatenate_db_strings($keys);
        // add slashes to the value array
        $values = $this->core->add_slashes($values);
        // get the value string for the sql insert
        $valStr = $this->core->concatenate_db_strings($values);
        // insert the values into the database
        $insStr = "INSERT INTO $this->tableName $keyStr VALUES $valStr";
        // Insert the values into the db
        $this->core->db->query($insStr);
        // Return the ID from the inserted user
        return $this->core->db->lastInsertId();
    }

    public function find_unique_by_key($key) {
        // get the value for this object key
        $value = $this->$key;
        $query = "SELECT * FROM $this->tableName WHERE $key='$value' ORDER BY id DESC LIMIT 1";
        $smtp = $this->core->db->query($query);
        $fetch = $smtp->fetch();
        // return false if no rows are found
        if($fetch === false) {
            return $fetch;
        }

        // populate the model using the rows
        // Get the object properties and remove the ones that should not be added to the DB
        $values = $this->remove_non_db_properties(get_object_vars($this));

        // Get the keys for the table
        $keys = array_keys($values);

        // assign each key property from the DB search
        foreach ($keys as $key) {
            $this->$key = $fetch[$key];
        }

        // return the id for this entry
        return $fetch['id'];
    }
    private function remove_non_db_properties($values) {
        foreach ($this->noInsert as $key) {
            unset($values[$key]);
        }
        return $values;
    }
}