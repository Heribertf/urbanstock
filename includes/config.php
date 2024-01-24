<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Load environment variables
require_once __DIR__ . '/../vendor/autoload.php';

// require_once '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$host = $_ENV['DB_HOST'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];
$database = $_ENV['DB_NAME'];

$paypalId = $_ENV['PAYPAL_ID'];
$paypalSandbox = $_ENV['PAYPAL_SANDBOX'];
$paypalReturn = $_ENV['PAYPAL_RETURN_URL'];
$paypalCancel = $_ENV['PAYPAL_CANCEL_URL'];
$paypalNotify = $_ENV['PAYPAL_NOTIFY_URL'];
$paypalCurrency = $_ENV['PAYPAL_CURRENCY'];

// PayPal configuration 
define('PAYPAL_ID', $paypalId);
define('PAYPAL_SANDBOX', $paypalSandbox); //TRUE or FALSE 

define('PAYPAL_RETURN_URL', $paypalReturn);
define('PAYPAL_CANCEL_URL', $paypalCancel);
define('PAYPAL_NOTIFY_URL', $paypalNotify);
define('PAYPAL_CURRENCY', $paypalCurrency);

// Database configuration  
define('DB_HOST', $host);
define('DB_USERNAME', $username);
define('DB_PASSWORD', $password);
define('DB_NAME', $database);

// Change not required 
define('PAYPAL_URL', (PAYPAL_SANDBOX == true) ? "https://www.sandbox.paypal.com/cgi-bin/webscr" : "https://www.paypal.com/cgi-bin/webscr");

