<?php
header('Content-Type: application/json');

include_once './includes/config.php';
include_once './includes/db_connection.php';


$response = [
    'success' => false,
    'message' => 'Unexpected error occurred.'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $user_id = trim($_POST['user_id']);
    $withdraw_amount = trim($_POST['withdraw_amount']);
    $recipient_number = trim($_POST['mpesa_phone']);
    $recipient_email = trim($_POST['paypal_email']);



    if ($withdraw_amount < 50) {
        $response = [
            'success' => false,
            'message' => 'Minimum withdrawal amount accepted is Ksh50.'
        ];
        echo json_encode($response);
        exit();
    }

    if (empty($user_id)) {
        $response = [
            'success' => false,
            'message' => 'Cannot validate request.'
        ];
        echo json_encode($response);
        exit();
    } elseif (empty($withdraw_amount)) {
        $response = [
            'success' => false,
            'message' => 'Please enter amount to withdraw.'
        ];
        echo json_encode($response);
        exit();
    }

    $balance_query = "SELECT account_balance FROM user_account WHERE user_id = ?";
    if ($statement = mysqli_prepare($conn, $balance_query)) {
        mysqli_stmt_bind_param($statement, "i", $param_user_id);

        $param_user_id = $user_id;

        if (mysqli_stmt_execute($statement)) {
            mysqli_stmt_store_result($statement);

            if (mysqli_stmt_num_rows($statement) == 1) {
                mysqli_stmt_bind_result($statement, $account_balance);
                mysqli_stmt_fetch($statement);

                if ($withdraw_amount > $account_balance) {
                    $response = [
                        'success' => false,
                        'message' => 'Sorry, you do not have enough balance to make this request.'
                    ];
                    echo json_encode($response);
                    exit();
                } else {
                    if (!empty($recipient_number) && empty($recipient_email)) {
                        $insertQuery = "INSERT INTO withdrawals (user_id, withdraw_amount, recipient_number, withdraw_request_date, type) VALUES ( ?, ?, ?, NOW(), ?)";

                        if ($stmt = mysqli_prepare($conn, $insertQuery)) {
                            mysqli_stmt_bind_param($stmt, "iisi", $param_userId, $param_amount, $param_phone, $param_type);
                            $param_userId = $user_id;
                            $param_amount = $withdraw_amount;
                            $param_phone = $recipient_number;
                            $param_type = 1;

                            if (mysqli_stmt_execute($stmt)) {
                                $response = [
                                    'success' => true,
                                    'message' => 'Withdraw request submitted successfully. Wait for approval.'
                                ];
                            } else {
                                $response = [
                                    'success' => false,
                                    'message' => 'Failed to submit withdraw request.'
                                ];
                            }
                            mysqli_stmt_close($stmt);
                        } else {
                            $response = [
                                'success' => false,
                                'message' => 'An error occurred.'
                            ];
                        }
                    } elseif (empty($recipient_number) && !empty($recipient_email)) {
                        $insertQuery2 = "INSERT INTO withdrawals (user_id, withdraw_amount, recipient_email, withdraw_request_date, type) VALUES ( ?, ?, ?, NOW(), ?)";

                        if ($stmt2 = mysqli_prepare($conn, $insertQuery2)) {
                            mysqli_stmt_bind_param($stmt2, "iisi", $param_userId, $param_amount, $param_email, $param_type);
                            $param_userId = $user_id;
                            $param_amount = $withdraw_amount;
                            $param_email = $recipient_email;
                            $param_type = 2;

                            if (mysqli_stmt_execute($stmt2)) {
                                $response = [
                                    'success' => true,
                                    'message' => 'Withdraw request submitted successfully. Wait for approval.'
                                ];
                            } else {
                                $response = [
                                    'success' => false,
                                    'message' => 'Failed to submit withdraw request.'
                                ];
                            }
                            mysqli_stmt_close($stmt2);
                        } else {
                            $response = [
                                'success' => false,
                                'message' => 'An error occurred.'
                            ];
                        }
                    } else {
                        $insertQuery = "INSERT INTO withdrawals (user_id, withdraw_amount, recipient_number, withdraw_request_date, type) VALUES ( ?, ?, ?, NOW(), ?)";

                        if ($stmt = mysqli_prepare($conn, $insertQuery)) {
                            mysqli_stmt_bind_param($stmt, "iisi", $param_userId, $param_amount, $param_phone, $param_type);
                            $param_userId = $user_id;
                            $param_amount = $withdraw_amount;
                            $param_phone = $recipient_number;
                            $param_type = 1;

                            if (mysqli_stmt_execute($stmt)) {
                                $response = [
                                    'success' => true,
                                    'message' => 'Withdraw request submitted successfully. Wait for approval.'
                                ];
                            } else {
                                $response = [
                                    'success' => false,
                                    'message' => 'Failed to submit withdraw request.'
                                ];
                            }
                            mysqli_stmt_close($stmt);
                        } else {
                            $response = [
                                'success' => false,
                                'message' => 'An error occurred.'
                            ];
                        }
                    }

                }

            } else {
                $response = [
                    'success' => false,
                    'message' => 'No earning records found for this user.'
                ];
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
            'message' => 'An error occurred.'
        ];
    }
}

echo json_encode($response);