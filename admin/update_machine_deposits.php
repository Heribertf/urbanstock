<?php
include_once './includes/config.php';
include_once './includes/db_connection.php';

mysqli_autocommit($conn, false); // Disable autocommit

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $edit_user_id = trim($_POST['edit_user_id']);
        $edit_investment_id = trim($_POST['edit_investment_id']);
        $machine_id = trim($_POST['machine_id']);
        $editSubStatus = trim($_POST['editSubStatus']);

        // Validate and sanitize input as needed

        // Check if the investment status has already been updated
        $checkQuery = "SELECT payment_status FROM investments WHERE user_id = ? AND investment_id = ? AND machine_id = ?";
        $check_stmt = mysqli_prepare($conn, $checkQuery);
        mysqli_stmt_bind_param($check_stmt, "iss", $edit_user_id, $edit_investment_id, $machine_id);
        mysqli_stmt_execute($check_stmt);
        mysqli_stmt_store_result($check_stmt);

        if (mysqli_stmt_num_rows($check_stmt) > 0) {
            mysqli_stmt_bind_result($check_stmt, $payment_status);

            if (mysqli_stmt_fetch($check_stmt)) {
                if ($payment_status == 'Completed') {
                    throw new Exception('Payment status for this investment has already been marked as Completed.');
                }
            }
        }

        mysqli_stmt_close($check_stmt);

        // Update the payment status and investment status
        $updateQuery = "UPDATE investments SET payment_status = ?, investment_status = 1 WHERE user_id = ? AND investment_id = ? AND machine_id = ?";
        $update_stmt = mysqli_prepare($conn, $updateQuery);
        mysqli_stmt_bind_param($update_stmt, "siii", $editSubStatus, $edit_user_id, $edit_investment_id, $machine_id);

        if (!mysqli_stmt_execute($update_stmt)) {
            throw new Exception('Failed to update payment status and investment status.');
        }

        mysqli_stmt_close($update_stmt);

        // Commit the transaction
        mysqli_commit($conn);

        $response = array('success' => true, 'message' => 'Payment status and investment status updated successfully');
        echo json_encode($response);
    }
} catch (Exception $e) {
    // Rollback the transaction in case of an error
    mysqli_rollback($conn);
    mysqli_autocommit($conn, true);

    // Output the error message
    $response = array('success' => false, 'message' => 'Error: ' . $e->getMessage());
    echo json_encode($response);
} finally {
    // Enable autocommit and close the connection
    mysqli_autocommit($conn, true);
    mysqli_close($conn);
}