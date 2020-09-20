<?php
/**
 * Script to check if the user is logged in
 */

use App\Models\User;

require 'bootstrap.php';

// Check if the loggedin boolean exists in the session, if it does check if it is set to true, otherwise return false
$request = json_decode(file_get_contents("php://input"), true);
// get the users token from the request
$token = $request["token"];
// Create a new user object and check if they are logged in using the token
$user = new User();
$user->token = $token;
if($user->is_logged_in()) {
    // return the user object as the response
    echo json_encode($user);
} else {
    echo 'false';
}