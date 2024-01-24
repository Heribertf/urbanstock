<?php
header('Content-Type: application/json');

include_once './includes/config.php';
include_once './includes/db_connection.php';


$response = [
    'success' => false,
    'message' => 'Unexpected error occurred.'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stock_id = trim($_POST['stock_invest']);
    $user_id = trim($_POST['paying_user_id']);
    $txn_id = trim($_POST['transaction_ref']);
    $plan_id = trim($_POST['plan_invest']);
    $capital = trim($_POST['capital']);

    date_default_timezone_set('Africa/Nairobi');

    $expFormat = mktime(
        date("H"),
        date("i"),
        date("s"),
        date("m"),
        date("d") + 1,
        date("Y")
    );

    $selectPlan = "SELECT hours FROM plans WHERE plan_id = ?";
    if ($plan_stmt = mysqli_prepare($conn, $selectPlan)) {
        mysqli_stmt_bind_param($plan_stmt, "s", $param_plan);
        $param_plan = $plan_id;

        if (mysqli_stmt_execute($plan_stmt)) {
            mysqli_stmt_store_result($plan_stmt);

            if (mysqli_stmt_num_rows($plan_stmt) > 0) {
                mysqli_stmt_bind_result($plan_stmt, $total_hours);

                if (mysqli_stmt_fetch($plan_stmt)) {
                    $duration = $total_hours;
                    $expFormat = mktime(
                        date("H") + $duration,
                        date("i"),
                        date("s"),
                        date("m"),
                        date("d"),
                        date("Y")
                    );
                }
            }
        }
        mysqli_stmt_close($plan_stmt);
    }

    $expDate = date("Y-m-d H:i:s", $expFormat);

    $pay_date = date('Y-m-d H:i:s');

    if (empty($txn_id)) {
        $response = [
            'success' => false,
            'message' => 'Kindly provide the M-Pesa transaction code.'
        ];
    } elseif (!empty($user_id) && !empty($stock_id) && !empty($plan_id)) {
        $prevPayment = "SELECT investment_id FROM investments WHERE txn = ?";
        if ($stmt = mysqli_prepare($conn, $prevPayment)) {
            mysqli_stmt_bind_param($stmt, "s", $param_txn);
            $param_txn = $txn_id;

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) > 0) {
                    $response = [
                        'success' => false,
                        'message' => 'Kindly provide a valid M-Pesa transaction code.'
                    ];
                } else {
                    $insert = "INSERT INTO investments (user_id, investment_type, stock_id, plan_id, capital, investment_date, close_date, txn, payment_mode, payment_status) VALUES(?,?,?,?,?,?,?,?,?,?)";
                    if ($statement = mysqli_prepare($conn, $insert)) {
                        mysqli_stmt_bind_param($statement, "isiiisssss", $param_user_id, $param_type, $param_stock, $param_plan, $param_capital, $param_date, $param_close, $param_txn, $param_mode, $param_pay_status);
                        $param_user_id = $user_id;
                        $param_type = "stock";
                        $param_stock = $stock_id;
                        $param_plan = $plan_id;
                        $param_capital = $capital;
                        $param_date = $pay_date;
                        $param_close = $expDate;
                        $param_txn = $txn_id;
                        $param_mode = "mpesa";
                        $param_pay_status = "unconfirmed";

                        if (mysqli_stmt_execute($statement)) {
                            $response = [
                                'success' => true,
                                'message' => 'Payment send successfully. Wait for payment approval before your investment activates.'
                            ];
                        } else {
                            $response = [
                                'success' => false,
                                'message' => 'Failed to submit payment details. Contact support for assistance.'
                            ];
                        }
                        mysqli_stmt_close($statement);

                    } else {
                        $response = [
                            'success' => false,
                            'message' => 'An error occurred while submitting payment details. Contact support for assistance.'
                        ];
                    }
                }
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Unable to complete your request. Contact support for assistance.'
                ];
            }

        } else {
            $response = [
                'success' => false,
                'message' => 'Encountered an error while submitting payment details. Contact support for assistance.'
            ];
        }
    }
    mysqli_close($conn);
}
echo json_encode($response);