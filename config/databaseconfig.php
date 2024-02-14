<?php
    error_reporting(0);
    define("DB_HOST", "localhost");
    define("DB_USER", "root");
    define("DB_PASS", "1234567890");
    define("DB_NAME", "agriloansys");

    // Create connection
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    //Check the connection
    if($conn->connect_error){
        die("Connection Failed" . $conn->connect_error);
    }
    //echo" Connection successful!";


// Start or resume a session
session_start();

// Check if user is not logged in, redirect to login page
// if (!isset($_SESSION['idNumber'])) {
//     header("Location: farmerlogin.php");
//     exit();
//  }
?> 