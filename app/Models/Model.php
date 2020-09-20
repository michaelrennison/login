<?php
/**
 * Default model class, this will be extended by other models to access the database
 */
namespace App\Models;

class Model
{
    /* @var $id integer */
    public $id;

    /**
     * Define an array for values that should not be included in database calls
     * @var array
     */
    private $noInsert = [
        'noInsert',
        'core',
        'db',
        'tableName',
        'relationship'
    ];
    // value for the core model to be used to call global functions
    protected $core;
    /**
     * Define the var for the table name
     *
     * @var $tableName String
     */
    protected $tableName;

    protected $relationship;

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

    /**
     * Function for finding a database entry using a specific key, e.g. email
     * @param $key
     * @return false
     */
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

        $this->populate_model($fetch);
        // return the id for this entry
        return $fetch['id'];
    }

    public function get_relationship_by_key($key) {
        $value = $this->$key;
        $query = "SELECT * FROM $this->relationship WHERE $key='$value'";
        return $this->core->db->query($query)->fetchAll();
    }

    public function update_values($values) {
        // Get the keys for the table
        $keys = array_keys($values);

        $query = "UPDATE $this->tableName SET ";

        foreach ($values as $key => $value) {
            // Check if this is the last element in the array
            reset($values);
            end($values);
            if ($key === key($values)) {
                $query .= "$key='$value'";
            } else {
                $query .= "$key='$value',";
            }
        }

        $query .= "WHERE id=$this->id";
        // run the query
        $this->core->db->query($query);
    }
    /**
     * function for striping non database properties when creating an entry
     * @param $values
     * @return mixed
     */
    private function remove_non_db_properties($values) {
        foreach ($this->noInsert as $key) {
            unset($values[$key]);
        }
        return $values;
    }

    /**
     * function for populating the model after values have been retrieved from the database
     * @param $fetch
     */
    private function populate_model($fetch){
        // populate the model using the rows
        // Get the object properties and remove the ones that should not be added to the DB
        $values = $this->remove_non_db_properties(get_object_vars($this));

        // Get the keys for the table
        $keys = array_keys($values);

        // assign each key property from the DB search
        foreach ($keys as $key) {
            // Check if key exists in the fetch
            if(array_key_exists($key, $fetch)) {
                $this->$key = $fetch[$key];
            }
        }
    }
}