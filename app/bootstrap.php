<?php
/**
 * Bootstrap file for loading all the classes in
 */
// Start the session
header('Access-Control-Allow-Credentials: true');

session_start();
// Import constants
require 'constants.php';

// Import classes
require 'Models/Core.php';
require 'Models/Model.php';
require 'Models/User.php';