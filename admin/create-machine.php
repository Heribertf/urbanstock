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

    $machine_name = trim($_POST['machine_name']);
    $machine_interest = trim($_POST['machine_interest']);
    $machine_price = trim($_POST['machine_price']);
    $machine_status = trim($_POST['machine_status']);

    // Check for empty fields
    if (empty($machine_name)) {
        $validData = false;
        $response = [
            'success' => false,
            'message' => 'Stock name cannot be empty.'
        ];
    } elseif (empty($machine_price)) {
        $validData = false;
        $response = [
            'success' => false,
            'message' => 'Machine price cannot be empty.'
        ];
    } elseif (empty($machine_interest)) {
        $validData = false;
        $response = [
            'success' => false,
            'message' => 'Stock interest cannot be empty.'
        ];
    } elseif (empty($machine_status)) {
        $validData = false;
        $response = [
            'success' => false,
            'message' => 'Please set a stock status.'
        ];
    }

    $name_query = "SELECT machine_id FROM machines WHERE machine_name = ?";
    if ($statement = mysqli_prepare($conn, $name_query)) {
        mysqli_stmt_bind_param($statement, "s", $param_machine_name);

        $param_machine_name = trim($_POST['machine_name']);

        if (mysqli_stmt_execute($statement)) {
            mysqli_stmt_store_result($statement);

            if (mysqli_stmt_num_rows($statement) > 0) {
                $validData = false;
                $response = [
                    'success' => false,
                    'message' => 'Machine name already exists. Choose a different one.'
                ];
            } else {
                $machine_name = trim($_POST['machine_name']);
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
        $insertQuery = "INSERT INTO machines (machine_name, percentage_interest, machine_price, machine_status) 
        VALUES (?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($conn, $insertQuery)) {
            mysqli_stmt_bind_param($stmt, "siii", $param_name, $param_interest, $param_price, $param_status);
            $param_name = $machine_name;
            $param_price = $machine_price;
            $param_interest = $machine_interest;
            $param_status = $machine_status;

            if (mysqli_stmt_execute($stmt)) {
                $response = [
                    'success' => true,
                    'message' => 'The machine has been created successfully.'
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Machine creation failed, please try again.'
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
