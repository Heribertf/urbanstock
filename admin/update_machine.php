<?php
include_once './includes/config.php';
include_once './includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input data
    $machineId = isset($_POST['machineId']) ? intval($_POST['machineId']) : 0;
    $machineName = isset($_POST['machineName']) ? htmlspecialchars($_POST['machineName']) : '';
    $machinePercentage = isset($_POST['machinePercentage']) ? floatval($_POST['machinePercentage']) : 0;
    $machineAmount = isset($_POST['machineAmount']) ? floatval($_POST['machineAmount']) : 0;
    $machineStatus = isset($_POST['machineStatus']) ? ($_POST['machineStatus'] === 'Active' ? 1 : 0) : 0;

    // Check if the machineId is valid
    if ($machineId <= 0) {
        $response = array('success' => false, 'message' => 'Invalid machine ID.');
        echo json_encode($response);
        exit;
    }

    // Update the data in the database
    $updateQuery = "UPDATE machines SET machine_name = ?, percentage_interest = ?, machine_price = ?, machine_status = ? WHERE machine_id = ?";

    if ($stmt = mysqli_prepare($conn, $updateQuery)) {
        mysqli_stmt_bind_param($stmt, "sdisi", $machineName, $machinePercentage, $machineAmount, $machineStatus, $machineId);


        if (mysqli_stmt_execute($stmt)) {
            $response = array('success' => true, 'message' => 'Machine updated successfully.');
            echo json_encode($response);
        } else {
            $response = array('success' => false, 'message' => 'Failed to update machine.');
            echo json_encode($response);
        }

        mysqli_stmt_close($stmt);
    } else {
        $response = array('success' => false, 'message' => 'Database error: Could not update the machine.');
        echo json_encode($response);
    }

    mysqli_close($conn);
} else {
    // Invalid request method
    $response = array('success' => false, 'message' => 'Invalid request method.');
    echo json_encode($response);
}
