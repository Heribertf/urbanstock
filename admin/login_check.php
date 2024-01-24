<?php
header('Content-Type: application/json');

require_once "./includes/config.php";
require_once("./includes/db_connection.php");

$response = [
    'success' => false,
    'message' => 'unexpected error occurred.'
];

$email = $password = "";
$email_err = $password_err = $verification_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
        $response = [
            'success' => false,
            'message' => 'Please enter your email.'
        ];
    } else {
        $email = trim($_POST["email"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
        $response = [
            'success' => false,
            'message' => 'Please enter your password.'
        ];
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($email_err) && empty($password_err)) {
        $sql = "SELECT userId, CONCAT(firstName, ' ', lastName) AS fullname, email, verified, password FROM users WHERE email = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            $param_email = $email;

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $userId, $fullname, $email, $verification_status, $hashed_password);

                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            session_start();

                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $userId;
                            $_SESSION["email"] = $email;
                            $_SESSION["fullname"] = $fullname;
                            $_SESSION["user_type"] = 1;

                            $response = [
                                'success' => true,
                                'message' => 'Successfully logged in.'
                            ];
                        } else {
                            $password_err = "The password you entered was not valid.";
                            $response = [
                                'success' => false,
                                'message' => 'The password you entered was not valid.'
                            ];
                        }
                    }
                } else {
                    $email_err = "No account found with that email.";
                    $response = [
                        'success' => false,
                        'message' => 'No account found with that email.'
                    ];
                }
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Something went wrong. Please try again later.'
                ];
            }

            mysqli_stmt_close($stmt);
        }
    }

    mysqli_close($conn);
}

echo json_encode($response);