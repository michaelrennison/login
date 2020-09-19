<?php
// TODO: validate input data
// TODO: add methods to avoid SQL injection
use App\Models\User;

require 'bootstrap.php';
// Only process data if the server request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request = json_decode(file_get_contents("php://input"), true);

    $password = $request["password"];

    // Construct the user model
    $user = new User();
    // populate the user models properties
    $user->setEmail($request["email"]);
    $user->setPassword($request["password"]);
    $user->fname = $request["fname"];
    $user->lname = $request["lname"];
    // Save the user model to the DB
    $data = $user->create();
    // Store the users login credentials to the session
    $_SESSION['loggedin'] = true;
    $_SESSION['userid'] = $data;

    $user->authenticate($request["password"]);
}
