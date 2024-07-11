<?php 
    ob_start();
    // Set sessions
    if(!isset($_SESSION)) {
        session_start();
    }
    $hostname = "localhost";
    $username = "u880697035_Vhiron";
    $password = "Vhiron@123";
    $dbname = "u880697035_db_DYOR";
    $conn = mysqli_connect($hostname, $username, $password, $dbname) or die("Database connection not established.")
?>