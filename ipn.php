<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


include_once './includes/config.php';

include_once './includes/db_connection.php';

date_default_timezone_set('Africa/Nairobi');

$logFile = './ipn_log.txt';
$ipnLogData = date('Y-m-d H:i:s') . " - IPN Data:\n" . print_r($_POST, true) . "\n\n";
file_put_contents($logFile, $ipnLogData, FILE_APPEND);
/* 
 * Read POST data 
 * reading posted data directly from $_POST causes serialization 
 * issues with array data in POST. 
 * Reading raw POST data from input stream instead. 
 */
$raw_post_data = file_get_contents('php://input');
$raw_post_array = explode('&', $raw_post_data);
$myPost = array();
foreach ($raw_post_array as $keyval) {
    $keyval = explode('=', $keyval);
    if (count($keyval) == 2)
        $myPost[$keyval[0]] = urldecode($keyval[1]);
}

// Read the post from PayPal system and add 'cmd' 
$req = 'cmd=_notify-validate';
if (function_exists('get_magic_quotes_gpc')) {
    $get_magic_quotes_exists = true;
}
foreach ($myPost as $key => $value) {
    if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
        $value = urlencode(stripslashes($value));
    } else {
        $value = urlencode($value);
    }
    $req .= "&$key=$value";
}

/* 
 * Post IPN data back to PayPal to validate the IPN data is genuine 
 * Without this step anyone can fake IPN data 
 */
$paypalURL = PAYPAL_URL;
$ch = curl_init($paypalURL);
if ($ch == FALSE) {
    return FALSE;
}
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSLVERSION, 6);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);

// Set TCP timeout to 30 seconds 
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close', 'User-Agent: company-name'));
$res = curl_exec($ch);

/* 
 * Inspect IPN validation result and act accordingly 
 * Split response headers and payload, a better way for strcmp 
 */
$tokens = explode("\r\n\r\n", trim($res));
$res = trim(end($tokens));
if (strcmp($res, "VERIFIED") == 0 || strcasecmp($res, "VERIFIED") == 0) {

    // Retrieve transaction info from PayPal 
    $stock_id = $_POST['item_number'];
    $machine_id = $_POST['item_number'];
    $txn_id = $_POST['txn_id'];
    $paid_amount = $_POST['mc_gross'];
    $currency_code = $_POST['mc_currency'];
    $payment_status = $_POST['payment_status'];
    $payment_date = $_POST['payment_date'];
    $payer_email = $_POST['payer_email'];
    $country = $_POST['residence_country'];
    $customField = $_POST['custom'];

    // Split the custom field values
    $customValues = explode('|', $customField);

    // Now $customValues is an array containing the individual custom field values
    $userId = $customValues[0];
    $investment_type = $customValues[1];
    $planId = $customValues[2];


    $formattedDate = DateTime::createFromFormat('H:i:s M d, Y T', $payment_date);
    $pay_date = $formattedDate->format('Y-m-d H:i:s');

    $expFormat = mktime(
        date("H"),
        date("i"),
        date("s"),
        date("m"),
        date("d") + 1,
        date("Y")
    );

    $cycle = mktime(
        date("H") + 1,
        date("i"),
        date("s"),
        date("m"),
        date("d"),
        date("Y")
    );

    $expDate = date("Y-m-d H:i:s", $expFormat);

    // Check if transaction data exists with the same TXN ID 
    $prevPayment = "SELECT investment_id FROM investments WHERE txn = ?";
    if ($stmt = mysqli_prepare($conn, $prevPayment)) {
        mysqli_stmt_bind_param($stmt, "s", $param_txn);
        $param_txn = $txn_id;

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) > 0) {
                exit();
            } else {
                if ($investment_type == "stock") {
                    $insert = "INSERT INTO investments (user_id, investment_type, stock_id, plan_id, capital, paid_amount, investment_date, close_date, txn, payment_mode, currency_code, payment_status, payer_email, payer_country, approval_status, investment_status) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                    if ($statement = mysqli_prepare($conn, $insert)) {
                        mysqli_stmt_bind_param($statement, "isiiddssssssssii", $param_user_id, $param_type, $param_stock, $param_plan, $param_capital, $param_amount, $param_date, $param_close, $param_txn, $param_mode, $param_code, $param_pay_status, $param_email, $param_country, $param_approval, $param_invest_status);
                        $param_user_id = $userId;
                        $param_type = $investment_type;
                        $param_stock = $stock_id;
                        $param_plan = $planId;
                        $param_capital = $paid_amount;
                        $param_amount = $paid_amount;
                        $param_date = $pay_date;
                        $param_close = $expDate;
                        $param_txn = $txn_id;
                        $param_mode = "paypal";
                        $param_code = $currency_code;
                        $param_pay_status = $payment_status;
                        $param_email = $payer_email;
                        $param_country = $country;
                        $param_approval = 2;
                        $param_invest_status = 1;

                        mysqli_stmt_execute($statement);
                        mysqli_stmt_close($statement);


                    }

                } elseif ($investment_type == "machine") {
                    $insert = "INSERT INTO investments (user_id, investment_type, machine_id, plan_id, capital, paid_amount, investment_date, close_date, txn, payment_mode, currency_code, payment_status, payer_email, payer_country, approval_status, investment_status, next_cycle_time) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                    if ($statement = mysqli_prepare($conn, $insert)) {
                        mysqli_stmt_bind_param($statement, "isiiddssssssssiis", $param_user_id, $param_type, $param_machine, $param_plan, $param_capital, $param_amount, $param_date, $param_close, $param_txn, $param_mode, $param_code, $param_pay_status, $param_email, $param_country, $param_approval, $param_invest_status, $param_cycle);
                        $param_user_id = $userId;
                        $param_type = $investment_type;
                        $param_machine = $machine_id;
                        $param_plan = $planId;
                        $param_capital = $paid_amount;
                        $param_amount = $paid_amount;
                        $param_date = $pay_date;
                        $param_close = $expDate;
                        $param_txn = $txn_id;
                        $param_mode = "paypal";
                        $param_code = $currency_code;
                        $param_pay_status = $payment_status;
                        $param_email = $payer_email;
                        $param_country = $country;
                        $param_approval = 2;
                        $param_invest_status = 1;
                        $param_cycle = date("Y-m-d H:i:s", $cycle);

                        mysqli_stmt_execute($statement);
                        mysqli_stmt_close($statement);


                    }
                }
            }
        }

    }

}
?>