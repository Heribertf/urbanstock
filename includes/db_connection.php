<?php

// $conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

// // Check connection
// if (!$conn) {
//     die("Connection failed: " . mysqli_connect_error());
// }


try {
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if ($conn->connect_error) {
        error_log("Database connection failed: " . $conn->connect_error);

        die("Oops! Something went wrong. Please try again later.");
    }
} catch (Exception $e) {
    error_log("Exception during database connection: " . $e->getMessage());

    die("Oops! Something went wrong. Please try again later.");
}