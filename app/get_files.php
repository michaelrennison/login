<?php
/**
 * Script for retriving a list of user files
 */

use App\Models\FileList;
use App\Models\User;

require 'bootstrap.php';

$request = json_decode(file_get_contents("php://input"), true);
// get the users token from the request
$token = $request["token"];
// Create a new user object and check if they are logged in using the token
$user = new User();
$user->token = $token;
if($user->is_logged_in()) {
    // create a new instance of the file list class
    $fileList = new FileList($user->id);

    echo json_encode($fileList);
}
