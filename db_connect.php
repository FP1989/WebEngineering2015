<?php

    require_once "config.php";
    $conn = mysqli_connect(HOST, USER, PASSWORD, DATABASE);

    if (!$conn) {
        echo "Error: Unable to connect to MySQL.\n";
        echo "Debugging errno: " . mysqli_connect_errno() . "\n";
        echo "Debugging error: " . mysqli_connect_error() . "\n";
        exit;
    }