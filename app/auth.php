<?php
/**
 * Script to check if the user is logged in
 */
require 'bootstrap.php';

// Check if the loggedin boolean exists in the session, if it does check if it is set to true, otherwise return false
if(isset($_SESSION['loggedin'])) {
    if($_SESSION['loggedin'] === true) {
        echo $_SESSION['userid'];
    } else {
        echo 'false';
    }
} else {
    echo 'false';
}