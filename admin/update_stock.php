<?php
include_once './includes/config.php';
include_once './includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input data
    $stockId = isset($_POST['stockId']) ? intval($_POST['stockId']) : 0;
    $stockName = isset($_POST['stockName']) ? htmlspecialchars($_POST['stockName']) : '';
    $stockPercentage = isset($_POST['stockPercentage']) ? floatval($_POST['stockPercentage']) : 0;

    // Check if the stockId is valid
    if ($stockId <= 0) {
        $response = array('success' => false, 'message' => 'Invalid stock ID.');
        echo json_encode($response);
        exit;
    }

    // Update the data in the database
    $updateQuery = "UPDATE stocks SET stock_name = ?, percentage_interest = ? WHERE stock_id = ?";

    if ($stmt = mysqli_prepare($conn, $updateQuery)) {
        mysqli_stmt_bind_param($stmt, "sdi", $stockName, $stockPercentage, $stockId);

        if (mysqli_stmt_execute($stmt)) {
            $response = array('success' => true, 'message' => 'Stock updated successfully.');
            echo json_encode($response);
        } else {
            $response = array('success' => false, 'message' => 'Failed to update stock.');
            echo json_encode($response);
        }

        mysqli_stmt_close($stmt);
    } else {
        $response = array('success' => false, 'message' => 'Database error: Could not update the stock.');
        echo json_encode($response);
    }

    mysqli_close($conn);
} else {
    // Invalid request method
    $response = array('success' => false, 'message' => 'Invalid request method.');
    echo json_encode($response);
}