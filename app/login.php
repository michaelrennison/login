<?php
/**
 * Script to handle logging in
 */

use App\Models\User;

require 'bootstrap.php';

// Only process data if the server request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request = json_decode(file_get_contents("php://input"), true);

    // Create a new user object
    $user = new User();
    // Set the email and password for the new user object
    $user->setEmail($request["email"]);

    // Call the function to check if a user exists with this email address in the db
    $userId = $user->find_unique_by_key('email');

    if($userId === false) {
        $resp = [
            'error' => true,
            'message' => 'We do not have a user with that email address registered'
        ];
    } else {
        // Set the user password and authenticate it
        if($user->authenticate($request["password"]) === true) {
            // Save session data and return the user object
            $_SESSION['loggedin'] = true;
            $_SESSION['userid'] = $userId;
            $resp = $user;
        } else {
            $resp = [
                'error' => true,
                'message' => 'Login incorrect'
            ];
        }
    }

    echo json_encode($resp);
}