<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

require_once "./includes/config.php";
require_once("./includes/db_connection.php");


$response = [
    'success' => false,
    'message' => 'An unexpected error.'
];

$password = $confirm_password = $firstname = $lastname = $email = $referral_username = null;
$password_err = $confirm_password_err = $firstname_err = $lastname_err = $email_err = $referral_username_err = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["email"]))) {
        $email_err = "Email cannot be empty";
        $response = [
            'success' => false,
            'message' => 'Email cannot be empty.'
        ];
    } else {
        $email_query = "SELECT userId FROM users WHERE email = ?";
        if ($statement = mysqli_prepare($conn, $email_query)) {
            mysqli_stmt_bind_param($statement, "s", $param_user_email);

            $param_user_email = trim($_POST["email"]);

            if (mysqli_stmt_execute($statement)) {
                mysqli_stmt_store_result($statement);

                if (mysqli_stmt_num_rows($statement) > 0) {
                    $email_err = "An account with that email already exists.";
                    $response = [
                        'success' => false,
                        'message' => 'An account with that email already exists.'
                    ];
                } else {
                    $email = trim($_POST['email']);
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

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
        $response = [
            'success' => false,
            'message' => 'Please enter a password.'
        ];
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
        $response = [
            'success' => false,
            'message' => 'Password must have at least 6 characters.'
        ];
    } else {
        $password = trim($_POST['password']);
    }

    if (empty(trim($_POST["conf_password"]))) {
        $confirm_password_err = "Please confirm password.";
        $response = [
            'success' => false,
            'message' => 'Please confirm password.'
        ];
    } else {
        $confirm_password = trim($_POST['conf_password']);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
            $response = [
                'success' => false,
                'message' => 'Password did not match.'
            ];
        }
    }

    if (empty(trim($_POST["first_name"]))) {
        $firstname_err = "Firstname cannot be empty";
        $response = [
            'success' => false,
            'message' => 'Firstname cannot be empty.'
        ];
    } else {
        $firstname = trim($_POST['first_name']);
    }

    if (empty(trim($_POST["last_name"]))) {
        $lastname_err = "Lastname cannot be empty";
        $response = [
            'success' => false,
            'message' => 'Lastname cannot be empty.'
        ];
    } else {
        $lastname = trim($_POST['last_name']);
    }



    if (empty($password_err) && empty($confirm_password_err) && empty($firstname_err) && empty($lastname_err) && empty($email_err)) {

        $query = "INSERT INTO users (firstname, lastname, email, password, registerDate, type) VALUES(?, ?, ?, ?, NOW(), 1)";

        if ($stmt = mysqli_prepare($conn, $query)) {
            mysqli_stmt_bind_param($stmt, 'ssss', $param_firstname, $param_lastname, $param_email, $param_password);

            $param_password = password_hash($password, PASSWORD_DEFAULT);
            $param_email = $email;
            $param_firstname = $firstname;
            $param_lastname = $lastname;

            if (mysqli_stmt_execute($stmt)) {
                $response = [
                    'success' => true,
                    'message' => 'Congratulations!! Start your Investment now.',
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Something went wrong. Please try again later.'
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
    mysqli_close($conn);
}

echo json_encode($response);
