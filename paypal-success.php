<?php

include_once("./includes/header.php");

include_once './includes/config.php';

include_once './includes/db_connection.php';

// If transaction data is available in the URL 
if (!empty($_GET['item_number']) && !empty($_GET['tx']) && !empty($_GET['amt']) && !empty($_GET['cc']) && !empty($_GET['st'])) {
    // Get transaction information from URL 
    $item_number = $_GET['item_number'];
    $txn_id = $_GET['tx'];
    $payment_gross = $_GET['amt'];
    $currency_code = $_GET['cc'];
    $payment_status = $_GET['st'];

    // Check if transaction data exists with the same TXN ID. 
    $prevPaymentResult = $conn->query("SELECT * FROM investments WHERE txn = '" . $txn_id . "'");

    if ($prevPaymentResult->num_rows > 0) {
        $paymentRow = $prevPaymentResult->fetch_assoc();
        $payment_id = $paymentRow['investment_id'];
        $type = $paymentRow['investment_type'];
        $payment_gross = $paymentRow['paid_amount'];
        $payment_status = $paymentRow['payment_status'];
    }
    // else {
    //     // Insert tansaction data into the database 
    //     $insert = $db->query("INSERT INTO payments(item_number,txn_id,payment_gross,currency_code,payment_status) VALUES('" . $item_number . "','" . $txn_id . "','" . $payment_gross . "','" . $currency_code . "','" . $payment_status . "')");
    //     $payment_id = $db->insert_id;
    // }
}
?>

<main>
    <article>
        <section class="section plans" data-section>
            <div class="container">
                <div class="about-section-el">
                    <img src="assets/images/el-2.png" alt="" />
                </div>
                <div class="">
                    <?php if (!empty($payment_id)) { ?>
                        <h1 class="success">Your payment has been successful</h1>

                        <h4>Payment Information</h4>
                        <p><b>Investment Type:</b>
                            <?php echo $type . " Investment."; ?>
                        </p>
                        <p><b>Transaction Ref:</b>
                            <?php echo $txn_id; ?>
                        </p>
                        <p><b>Paid Amount:</b>
                            <?php echo "$" . $payment_gross . " (Ksh " . $payment_gross * 150 . ")"; ?>
                        </p>
                        <p><b>Payment Status:</b>
                            <?php echo $payment_status; ?>
                        </p>


                    <?php } else { ?>
                        <h1 class="error">Your Payment has Failed</h1>
                    <?php } ?>
                </div>
                <a href="investment.php" class="btn btn-primary">Go to Investments</a>
            </div>
        </section>
    </article>
</main>
<?php
include_once("./includes/footer.php");
include_once("./includes/footer-end.php");
?>