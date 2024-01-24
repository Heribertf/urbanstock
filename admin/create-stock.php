<?php
header('Content-Type: application/json');

include_once './includes/config.php';
include_once './includes/db_connection.php';


$response = [
    'success' => false,
    'message' => 'Unexpected error occurred.'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validData = true; // A flag to validate the data

    $stock_name = trim($_POST['stock_name']);
    $stock_interest = trim($_POST['stock_interest']);
    $stock_status = trim($_POST['stock_status']);

    // Check for empty fields
    if (empty($stock_name)) {
        $validData = false;
        $response = [
            'success' => false,
            'message' => 'Stock name cannot be empty.'
        ];
    } elseif (empty($stock_interest)) {
        $validData = false;
        $response = [
            'success' => false,
            'message' => 'Stock interest cannot be empty.'
        ];
    } elseif (empty($stock_status)) {
        $validData = false;
        $response = [
            'success' => false,
            'message' => 'Please set a stock status.'
        ];
    }

    $name_query = "SELECT stock_id FROM stocks WHERE stock_name = ?";
    if ($statement = mysqli_prepare($conn, $name_query)) {
        mysqli_stmt_bind_param($statement, "s", $param_stock_name);

        $param_stock_name = trim($_POST['stock_name']);

        if (mysqli_stmt_execute($statement)) {
            mysqli_stmt_store_result($statement);

            if (mysqli_stmt_num_rows($statement) > 0) {
                $validData = false;
                $response = [
                    'success' => false,
                    'message' => 'Stock name already exists. Choose a different one.'
                ];
            } else {
                $stock_name = trim($_POST['stock_name']);
            }
        } else {
            $response = [
                'success' => false,
                'message' => 'Something went wrong. Please try again later.'
            ];
        }

        mysqli_stmt_close($statement);
    } else {
        $response = [
            'success' => false,
            'message' => 'Database error.'
        ];
    }


    if ($validData) {
        $insertQuery = "INSERT INTO stocks (stock_name, percentage_interest, stock_status) 
        VALUES (?, ?, ?)";

        if ($stmt = mysqli_prepare($conn, $insertQuery)) {
            mysqli_stmt_bind_param($stmt, "sii", $param_name, $param_interest, $param_status);
            $param_name = $stock_name;
            $param_interest = $stock_interest;
            $param_status = $stock_status;

            if (mysqli_stmt_execute($stmt)) {
                $response = [
                    'success' => true,
                    'message' => 'The stock has been added successfully.'
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Stock creation failed, please try again.'
                ];
            }
            mysqli_stmt_close($stmt);
        } else {
            $response = [
                'success' => false,
                'message' => 'Database error: Could not insert into database.'
            ];
        }
    }
}

echo json_encode($response);
