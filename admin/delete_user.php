<?php
if (isset($_POST['userId'])) {
    include_once './includes/config.php';
    include_once './includes/db_connection.php';

    $userId = $_POST['userId'];

    $deleteQuery = "UPDATE users SET delete_flag = 1 WHERE userId = ?";
    if ($stmt = mysqli_prepare($conn, $deleteQuery)) {
        mysqli_stmt_bind_param($stmt, "i", $userId);
        if (mysqli_stmt_execute($stmt)) {
            $response = array('success' => true, 'message' => 'User deleted successfully');
            echo json_encode($response);
        } else {
            $response = array('success' => false, 'message' => 'Failed to delete user');
            echo json_encode($response);
        }
        mysqli_stmt_close($stmt);
    } else {
        $response = array('success' => false, 'message' => 'Database error: Could not update the database.');
        echo json_encode($response);
    }

    mysqli_close($conn);
}