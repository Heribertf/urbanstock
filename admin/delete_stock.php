<?php
if (isset($_POST['stockId'])) {
    include_once './includes/config.php';
    include_once './includes/db_connection.php';

    $stock_id = $_POST['stockId'];

    $deleteQuery = "UPDATE stocks SET delete_flag = 1 WHERE stock_id = ?";
    if ($stmt = mysqli_prepare($conn, $deleteQuery)) {
        mysqli_stmt_bind_param($stmt, "i", $stock_id);
        if (mysqli_stmt_execute($stmt)) {
            $response = array('success' => true, 'message' => 'Stock deleted successfully');
            echo json_encode($response);
        } else {
            $response = array('success' => false, 'message' => 'Failed to delete stock');
            echo json_encode($response);
        }
        mysqli_stmt_close($stmt);
    } else {
        $response = array('success' => false, 'message' => 'Database error: Could not update the database.');
        echo json_encode($response);
    }

    mysqli_close($conn);
}