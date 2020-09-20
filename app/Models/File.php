<?php


namespace App\Models;


class File extends Model
{
    /* @var $name String */
    public $name;

    /* @var $file_name String */
    public $file_name;

    /* @var $source String */
    public $source;

    /* @var $user_id int */
    protected $user_id;

    /* @var $tableName String */
    protected $tableName = 'files';

    public function __construct($name, $file_name, $source, $userId)
    {
        parent::__construct();
        $this->name = $name;
        $this->file_name = $file_name;
        $this->source = $source;
        $this->user_id = $userId;
    }
}