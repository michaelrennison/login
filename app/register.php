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
    // Check if user already exists in database
    if($user->find_unique_by_key('email') === false) {
        // Save the user model to the DB
        $data = $user->create();
        // Store the users login credentials to the session
        $user->login();
        $resp = $user;
    } else {
        $resp = [
            'error' => true,
            'message' => 'A user with that email address already exists'
        ];
    }

    echo json_encode($resp);
}
