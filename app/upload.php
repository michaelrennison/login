<?php
/**
 * Script for handling the file upload
 */

use App\Models\File;
use App\Models\User;

require 'bootstrap.php';
// get the users token from the request
$token = $_POST["token"];
// Create a new user object and check if they are logged in using the token
$user = new User();
$user->token = $token;
if($user->is_logged_in()) {
    // generate a unique filename
    $filename = uniqid(rand(), true);
    $ext = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
    $uploadTarget = "uploads/$filename.$ext";

    $file = new File(
        $_POST["name"],
        $_FILES["file"]["name"],
        $uploadTarget,
        $user->id
    );

    // Save the file to the server
    move_uploaded_file( $_FILES['file']['tmp_name'], $file->source);
    // Create the file database entry
    $file->create();

    echo json_encode($file);
} else {
}
