<?php
    $servername = "localhost";
    $username = "root";
    $password = ""; 
    $databases = "blogpost";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $databases);

    if ($conn->connect_error) {
        die("Connection failed: " . mysqli_connect_error() . "  " . $conn->connect_error);
    }
    // echo "Connected successfully";
