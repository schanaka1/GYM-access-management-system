<?php
    session_start();
    
    $host = "localhost";
    $username = "id21900375_root";
    $password = "Database1234#";
    $database = "id21900375_gymnsb";

    // Create connection
    $conn = mysqli_connect($host, $username, $password, $database);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>

