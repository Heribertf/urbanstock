<?php
if (isset($_POST['machineId'])) {
    include_once './includes/config.php';
    include_once './includes/db_connection.php';

    $machine_id = $_POST['machineId'];

    $deleteQuery = "UPDATE machines SET delete_flag = 1 WHERE machine_id = ?";
    if ($stmt = mysqli_prepare($conn, $deleteQuery)) {
        mysqli_stmt_bind_param($stmt, "i", $machine_id);
        if (mysqli_stmt_execute($stmt)) {
            $response = array('success' => true, 'message' => 'Machine deleted successfully');
            echo json_encode($response);
        } else {
            $response = array('success' => false, 'message' => 'Failed to delete machine');
            echo json_encode($response);
        }
        mysqli_stmt_close($stmt);
    } else {
        $response = array('success' => false, 'message' => 'Database error: Could not update the database.');
        echo json_encode($response);
    }

    mysqli_close($conn);
}