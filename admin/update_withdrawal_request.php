<?php
include_once './includes/config.php';
include_once './includes/db_connection.php';

mysqli_autocommit($conn, false); // Disable autocommit

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $withdrawId = trim($_POST['edit_withdraw_id']);
        $userId = trim($_POST['edit_user_id']);
        $withdraw_amount = trim($_POST['withdraw_amount']);
        $newStatus = trim($_POST['editWthStatus']);
        $transactionRef = trim($_POST['transaction']);
        $rejectionComment = trim($_POST['rejection_comment']);

        $checkQuery = "SELECT status FROM withdrawals WHERE withdraw_id = ? AND user_id = ?";
        $check_stmt = mysqli_prepare($conn, $checkQuery);
        mysqli_stmt_bind_param($check_stmt, "ii", $withdrawId, $userId);
        mysqli_stmt_execute($check_stmt);
        mysqli_stmt_store_result($check_stmt);

        if (mysqli_stmt_num_rows($check_stmt) > 0) {
            mysqli_stmt_bind_result($check_stmt, $check_status);

            if (mysqli_stmt_fetch($check_stmt)) {
                if ($check_status == 1) {
                    throw new Exception('This withdrawal request has already been approved and marked completed.');
                }
            }
        }

        mysqli_stmt_close($check_stmt);

        $newStatus = strtolower($newStatus);
        switch ($newStatus) {
            case 'completed':
                $status = 1;
                break;
            case 'cancelled':
                $status = 0;
                break;
            case 'pending':
                $status = 2;
                break;
            default:
                $status = 2;
        }

        if ($status === 1) {
            $subQuery = "SELECT user_id, total_withdrawn, account_balance FROM user_account WHERE user_id = ?";
            $sub_stmt = mysqli_prepare($conn, $subQuery);
            mysqli_stmt_bind_param($sub_stmt, "i", $userId);
            mysqli_stmt_execute($sub_stmt);
            mysqli_stmt_store_result($sub_stmt);

            if (mysqli_stmt_num_rows($sub_stmt) > 0) {
                mysqli_stmt_bind_result($sub_stmt, $user_id, $total_withdrawn, $balance);

                if (mysqli_stmt_fetch($sub_stmt)) {
                    $total_withdrawn += $withdraw_amount;
                    $balance -= $withdraw_amount;

                    $accQuery = "UPDATE user_account SET total_withdrawn = ?, account_balance = ? WHERE user_id = ?";
                    $stmt = mysqli_prepare($conn, $accQuery);
                    mysqli_stmt_bind_param($stmt, "iii", $total_withdrawn, $balance, $user_id);

                    if (mysqli_stmt_execute($stmt)) {
                        mysqli_stmt_close($stmt);
                    } else {
                        throw new Exception('Failed to update user account.');
                    }
                }
            }

            mysqli_stmt_close($sub_stmt);
        }

        if (!empty($transactionRef) && !empty($rejectionComment)) {
            $updateQuery = "UPDATE withdrawals SET status = ?, transaction_ref = ?, comment = ? WHERE withdraw_id = ?";
            $stmt2 = mysqli_prepare($conn, $updateQuery);
            mysqli_stmt_bind_param($stmt2, "issi", $status, $transactionRef, $rejectionComment, $withdrawId);

            if (mysqli_stmt_execute($stmt2)) {
                mysqli_stmt_close($stmt2);
            } else {
                throw new Exception('Failed to update withdrawal request status');
            }
        } else if (!empty($transactionRef) && empty($rejectionComment)) {
            $updateQuery = "UPDATE withdrawals SET status = ?, transaction_ref = ? WHERE withdraw_id = ?";
            $stmt2 = mysqli_prepare($conn, $updateQuery);
            mysqli_stmt_bind_param($stmt2, "isi", $status, $transactionRef, $withdrawId);

            if (mysqli_stmt_execute($stmt2)) {
                mysqli_stmt_close($stmt2);
            } else {
                throw new Exception('Failed to update withdrawal request status');
            }
        } else if (empty($transactionRef) && !empty($rejectionComment)) {
            $updateQuery = "UPDATE withdrawals SET status  = ?, comment = ? WHERE withdraw_id = ?";
            $stmt2 = mysqli_prepare($conn, $updateQuery);
            mysqli_stmt_bind_param($stmt2, "isi", $status, $rejectionComment, $withdrawId);

            if (mysqli_stmt_execute($stmt2)) {
                mysqli_stmt_close($stmt2);
            } else {
                throw new Exception('Failed to update withdrawal request status');
            }
        } else {
            $query = "UPDATE withdrawals SET status = ? WHERE withdraw_id = ?";
            $statement = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($statement, "ii", $status, $withdrawId);

            if (mysqli_stmt_execute($statement)) {
                mysqli_stmt_close($statement);
            } else {
                throw new Exception('Failed to update withdrawal request status');
            }
        }

        // Commit the transaction
        mysqli_commit($conn);
        $response = array('success' => true, 'message' => 'Withdrawal request updated successfully');
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
?>