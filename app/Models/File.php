<?php


namespace App\Models;


class File extends Model
{
    /* @var $name String */
    public $name;

    /* @var $fileName String */
    public $fileName;

    /* @var $source String */
    public $source;

    /* @var $user_id int */
    protected $user_id;

    /* @var $tableName String */
    protected $tableName = 'files';

    public function __construct($name, $fileName, $source, $userId)
    {
        parent::__construct();
        $this->name = $name;
        $this->fileName = $fileName;
        $this->source = $source;
        $this->user_id = $userId;
    }
}