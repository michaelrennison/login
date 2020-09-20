<?php
/**
 * Script for logging a user out of the server
 */

use App\Models\User;

require 'bootstrap.php';

$request = json_decode(file_get_contents("php://input"), true);
// get the users token from the request
$token = $request["token"];
// Create a new user object and check if they are logged in using the token
$user = new User();
$user->token = $token;
// log the user out
$user->logout();
