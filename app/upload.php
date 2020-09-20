<?php
/**
 * Script for handling the file upload
 */

use App\Models\File;

require 'bootstrap.php';
// check if user is logged in
// Only process data if the server request method is POST
if($_COOKIE['loggedin'] && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // generate a unique filename
    $filename = uniqid(rand(), true);
    $ext = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
    $uploadTarget = "uploads/$filename.$ext";

    $file = new File(
        $_POST["name"],
        $_FILES["file"]["name"],
        $uploadTarget,
        $_POST["userId"]
    );

    // Save the file to the server
    move_uploaded_file( $_FILES['file']['tmp_name'], $file->source);
    // Create the file database entry
    $file->create();

    echo json_encode($file);
}
