<?php


namespace App\Models;


class FileList extends Model
{
    /* @var $files [File] */
    public $files;

    /* @var $user_id integer */
    protected $user_id;

    // Define a relationship variables to use to list an array of a class belonging to this one
    /* @var $relationship string */
    protected $relationship = 'files';

    public function __construct($user_id)
    {
        parent::__construct();
        $this->user_id = $user_id;
        $this->files = [];
        $this->populate_file_list();
    }

    private function populate_file_list() {
        $rows = $this->get_relationship_by_key('user_id');
        foreach ($rows as $row) {

            $file = new File(
                $row['name'],
                $row['file_name'],
                $row['source'],
                $this->user_id
            );
            // Set the file ID as the row retrieved from the database
            $file->id = $row['id'];

            array_push($this->files, $file);
        }
    }
}