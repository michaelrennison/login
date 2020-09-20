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
        'relationship',
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
        // remove ID from the values
        unset($values['id']);
        // Get the keys for the table
        $keys = array_keys($values);
        // Get the key string for the sql insert
        $keyStr = $this->core->concatenate_db_strings($keys);
        // add slashes to the value array
        // $values = $this->core->add_slashes($values);
        // Begin making the SQL insert statement
        $insStr = "INSERT INTO $this->tableName $keyStr VALUES (";
        // Loop through the keys to bind them to the insert string;
        foreach ($keys as $index => $key) {
            // Check if this is the last element in the array
            reset($keys);
            end($keys);
            if ($index === key($keys)) {
                $insStr .= " :$key";
            } else {
                $insStr .= " :$key, ";
            }
        }
        // Close the values bing binded
        $insStr .= ")";
        // prepare the database query
        $stmt  = $this->core->db->prepare($insStr);
        // Execute the query and bind the values to their key
        $stmt->execute($values);
        // Return the ID from the inserted user
        // set the objects ID
        $this->id = $this->core->db->lastInsertId();
        return $this->id;
    }

    /**
     * Function for finding a database entry using a specific key, e.g. email
     * @param $key
     * @return false
     */
    public function find_unique_by_key($key) {
        // get the value for this object key
        $value = $this->$key;
        $query = "SELECT * FROM $this->tableName WHERE $key= :$key ORDER BY id DESC LIMIT 1";
        $smtp = $this->core->db->prepare($query);

        $smtp->execute([$key => $value]);
        $fetch = $smtp->fetch();
        // return false if no rows are found
        if($fetch === false) {
            return $fetch;
        }

        $this->populate_model($fetch);
        // return the id for this entry
        return $fetch['id'];
    }


    /**
     * function for getting all the values in the relationship table using a specific key e.g. user_id
     * @param $key
     * @return mixed
     */
    public function get_relationship_by_key($key) {
        $value = $this->$key;
        $query = "SELECT * FROM $this->relationship WHERE $key= :$key";
        $smtp = $this->core->db->prepare($query);
        $smtp->execute([$key => $value]);
        return $smtp->fetchAll();
    }


    /**
     * function for updating values for an entry in the database
     * @param $values
     */
    public function update_values($values) {

        $query = "UPDATE $this->tableName SET ";

        foreach ($values as $key => $value) {
            // Check if this is the last element in the array
            reset($values);
            end($values);
            if ($key === key($values)) {
                $query .= "$key = :$key";
            } else {
                $query .= "$key = :$key,";
            }
        }

        $query .= " WHERE id=$this->id";

        $smtp = $this->core->db->prepare($query);
        // Execute the query
        $smtp->execute($values);
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