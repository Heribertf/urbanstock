<?php
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["user_type"] !== 2) {
  header("location: ./login.php");
  exit;
}
include_once './includes/header.php';

include_once './includes/config.php';
include_once './includes/db_connection.php';

$session_user = $_SESSION["id"];

$statQuery = "SELECT SUM(capital) AS total_stock_invest, currency_code FROM investments WHERE user_id = ? AND payment_status = ? AND investment_type = ?";
$total_stock_invested = 0;
$total_machine_invested = 0;

if ($stmt1 = mysqli_prepare($conn, $statQuery)) {
  mysqli_stmt_bind_param($stmt1, "iss", $param_userid, $param_status, $param_type);

  $param_userid = $session_user;
  $param_status = "Completed";
  $param_type = "stock";

  if (mysqli_stmt_execute($stmt1)) {
    mysqli_stmt_store_result($stmt1);

    if (mysqli_stmt_num_rows($stmt1) > 0) {
      mysqli_stmt_bind_result($stmt1, $total_stock_invest, $currencyCode);

      if (mysqli_stmt_fetch($stmt1)) {
        if ($currencyCode === "USD") {
          $total_stock_invested = $total_stock_invest * 150;
        } else {
          $total_stock_invested = $total_stock_invest;
        }
      }
    }
  }
  mysqli_stmt_close($stmt1);
}

$statQuery2 = "SELECT SUM(capital) AS total_machine_invest, currency_code FROM investments WHERE user_id = ? AND payment_status = ? AND investment_type = ?";

if ($stmt2 = mysqli_prepare($conn, $statQuery2)) {
  mysqli_stmt_bind_param($stmt2, "iss", $param_userid, $param_status, $param_type);

  $param_userid = $session_user;
  $param_status = "Completed";
  $param_type = "machine";

  if (mysqli_stmt_execute($stmt2)) {
    mysqli_stmt_store_result($stmt2);

    if (mysqli_stmt_num_rows($stmt2) > 0) {
      mysqli_stmt_bind_result($stmt2, $total_machine_invest, $currencyCode);

      if (mysqli_stmt_fetch($stmt2)) {
        if ($currencyCode === "USD") {
          $total_machine_invested = $total_machine_invest * 150;
        } else {
          $total_machine_invested = $total_machine_invest;
        }
      }
    }
  }
  mysqli_stmt_close($stmt2);
}

$balance_query = "SELECT account_balance FROM user_account WHERE user_id = ?";

$accountBalance = 0;

if ($bal_stmt = mysqli_prepare($conn, $balance_query)) {
  mysqli_stmt_bind_param($bal_stmt, "i", $param_user_id);

  $param_user_id = $_SESSION["id"];

  if (mysqli_stmt_execute($bal_stmt)) {
    mysqli_stmt_store_result($bal_stmt);

    if (mysqli_stmt_num_rows($bal_stmt) > 0) {
      mysqli_stmt_bind_result($bal_stmt, $account_balance);

      if (mysqli_stmt_fetch($bal_stmt)) {
        $accountBalance = $account_balance;
      }
    }
  }
  mysqli_stmt_close($bal_stmt);
}
?>
<main>
  <article>
    <section class="invest section">
      <div class="container">
        <div class="invest-tab">
          <ul class="tab-nav">
            <li>
              <button data-filter=".group-1" class="tab-btn">
                Overview
              </button>
            </li>

            <li>
              <button data-filter=".group-2" class="tab-btn">Stocks</button>
            </li>

            <li>
              <button data-filter=".group-3" class="tab-btn">
                Machines
              </button>
            </li>
          </ul>
          <ul class="tab-content">
            <li class="group-1">
              <div class="trend-card" style="background: linear-gradient(to right, #8b6914, #000000);">
                <div class="card-title-wrapper">
                  <img src="./assets/images/deposit-svgrepo-com.svg" width="24" height="24" alt="bitcoin logo" />

                  <a href="#" class="card-title">
                    Account Balance<span class="span"></span>
                  </a>
                </div>

                <data class="card-value" value="46168.95"><span>Ksh</span>
                  <?php echo number_format($accountBalance, 2); ?>
                </data>

                <div class="card-analytics">
                  <data class="current-price" value="36641.20">Total Profit investments</data>

                  <div class="badge green">
                    <?php
                    echo $conn->query("SELECT investment_id FROM investments WHERE user_id = $session_user AND payment_status = 'Completed' AND investment_status = 0")->num_rows;
                    ?>
                  </div>
                </div>
              </div>
            </li>

            <li class="group-1">
              <div class="trend-card" style="background: linear-gradient(to right, #8b6914, #000000);">
                <div class="card-title-wrapper">
                  <img src="./assets/images/cash-svgrepo-com.svg" width="24" height="24" alt="ethereum logo" />

                  <a href="#" class="card-title">
                    Total Invested <span class="span"></span>
                  </a>
                </div>

                <data class="card-value" value="3480.04"><span>Ksh</span>
                  <?php echo number_format($total_stock_invested + $total_machine_invested, 2); ?>
                </data>

                <div class="card-analytics">
                  <data class="current-price" value="36641.20">Total Invested</data>

                  <div class="badge green">
                    <?php
                    echo $conn->query("SELECT investment_id FROM investments WHERE user_id = $session_user AND payment_status = 'Completed'")->num_rows;
                    ?> Investments
                  </div>
                </div>
              </div>
            </li>

            <li class="group-1 group-2">
              <div class="trend-card" style="background: linear-gradient(to right, #8b6914, #000000);">
                <div class="card-title-wrapper">
                  <img src="./assets/images/stock-market-svgrepo-com.svg" width="24" height="24" alt="tether logo" />

                  <a href="#" class="card-title">
                    Stock Markets <span class="span"></span>
                  </a>
                </div>

                <data class="card-value" value="1.00"><span>Ksh</span>
                  <?php echo number_format($total_stock_invested, 2); ?>
                </data>

                <div class="card-analytics">
                  <data class="current-price" value="36641.20">Total Stocks:
                  </data>

                  <div class="badge green">
                    <?php
                    echo $conn->query("SELECT investment_id FROM investments WHERE user_id = $session_user AND payment_status = 'Completed' AND investment_type = 'stock'")->num_rows;
                    ?> stocks
                  </div>
                </div>
              </div>
            </li>

            <li class="group-1 group-3">
              <div class="trend-card" style="background: linear-gradient(to right, #8b6914, #000000);">
                <div class="card-title-wrapper">
                  <img src="./assets/images/bot-svgrepo-com.svg" width="24" height="24" alt="bnb logo" />

                  <a href="#" class="card-title">
                    Bulk Machines <span class="span"></span>
                  </a>
                </div>

                <data class="card-value" value="443.56"><span>Ksh</span>
                  <?php echo number_format($total_machine_invested, 2); ?>
                </data>

                <div class="card-analytics">
                  <data class="current-price" value="36641.20">Total Machines:</data>

                  <div class="badge green">
                    <?php
                    echo $conn->query("SELECT investment_id FROM investments WHERE user_id = $session_user AND payment_status = 'Completed' AND investment_type = 'machine'")->num_rows;
                    ?> Machines
                  </div>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </section>
    <section class="section transaction" data-section>
      <div class="container">
        <div class="transaction-container">
          <h2 class="h2 section-title">My Portfolio</h2>
          <button class="btn-primary" data-open-modal>
            Withdraw Funds
          </button>
        </div>
        <div class="transaction-columns">
          <div class="transaction-tab">
            <ul class="tab-nav">
              <li>
                <button class="tab-btn active">Investment Deposits</button>
              </li>
            </ul>
            <table class="transaction-table">
              <thead class="table-head">
                <tr class="table-row table-title">
                  <th class="table-heading" scope="col">#</th>

                  <th class="table-heading" scope="col">Asset</th>

                  <th class="table-heading" scope="col">Amount</th>

                  <th class="table-heading" scope="col">Date Paid</th>
                  <th class="table-heading" scope="col">Deposit Status</th>
                  <th class="table-heading" scope="col">Expected Return</th>
                  <th class="table-heading" scope="col">Market</th>
                </tr>
              </thead>
              <tbody class="table-body">
                <?php
                $i = 1;
                $percentage = 0.25;

                $query2 = "SELECT i.capital, DATE_FORMAT(i.investment_date, '%d-%b-%Y') AS date_invested, i.currency_code, i.payment_status, 
                          CASE
                            WHEN i.investment_status = 1 THEN 'Active'
                            WHEN i.investment_status = 2 THEN 'Pending'
                            WHEN i.investment_status = 0 THEN 'Closed'
                          END AS investment_status,
                          COALESCE(m.machine_name, s.stock_name) AS asset_name,
                          COALESCE(m.percentage_interest, s.percentage_interest) AS interest
                          FROM investments i
                          LEFT JOIN machines m ON i.machine_id = m.machine_id
                          LEFT JOIN stocks s ON i.stock_id = s.stock_id
                          WHERE i.user_id = $session_user
                          ORDER BY i.investment_date DESC";

                if ($statement = mysqli_prepare($conn, $query2)) {
                  mysqli_stmt_execute($statement);
                  mysqli_stmt_bind_result($statement, $amount, $date_invested, $currency_code, $payment_status, $investment_status, $asset_name, $interest);

                  while (mysqli_stmt_fetch($statement)) {
                    echo "<tr class='table-row'>";
                    echo "<td class='table-data rank'>" . $i++ . "</td>";
                    echo "<td class='table-data market-cap'>" . htmlspecialchars($asset_name) . "</td>";

                    if ($currency_code === 'USD') {
                      echo "<td class='table-data last-update'> Ksh " . number_format($amount * 150, 2) . "</td>";
                    } else {
                      echo "<td class='table-data last-update'> Ksh " . number_format($amount, 2) . "</td>";
                    }

                    echo "<td class='table-data last-price'>" . htmlspecialchars($date_invested) . "</td>";

                    if ($payment_status === 'Completed') {
                      echo "<td><span class='table-data last-update green'>" . htmlspecialchars($payment_status) . "</span></td>";
                    } else if ($payment_status === 'unconfirmed') {
                      echo "<td><span class='table-data last-update yellow'>" . htmlspecialchars($payment_status) . "</span></td>";
                    } else if ($payment_status === 'rejected') {
                      echo "<td><span class='table-data last-update red'>" . htmlspecialchars($payment_status) . "</span></td>";
                    }

                    if ($currency_code === 'USD') {
                      echo "<td class='table-data market-cap'> Ksh " . number_format(($amount * 150) * ($interest / 100), 2) . "</td>";
                    } else {
                      echo "<td class='table-data market-cap'> Ksh " . number_format($amount * ($interest / 100), 2) . "</td>";
                    }

                    echo "<td class='table-data market-cap'>" . htmlspecialchars($investment_status) . "</td>";
                    echo "</tr>";
                  }
                  if ($i === 1) {
                    // No records found
                    echo '<tr class="table-row"><td colspan="7" class="text-center">No records found.</td></tr>';
                  }

                  mysqli_stmt_close($statement);
                } else {
                  error_log("Error in prepared statement: " . mysqli_error($conn));
                }
                ?>

              </tbody>
            </table>
          </div>

          <!-- latest withdraws -->
          <div class="transaction-tab">
            <ul class="tab-nav">
              <li>
                <button class="tab-btn active">Recent withdrawals</button>
              </li>
            </ul>
            <table class="transaction-table">
              <thead class="table-head">
                <tr class="table-row table-title">
                  <th class="table-heading" scope="col">#</th>

                  <th class="table-heading" scope="col">Date</th>

                  <th class="table-heading" scope="col">Amount</th>

                  <th class="table-heading" scope="col">Status</th>
                </tr>
              </thead>
              <tbody class="table-body">
                <?php

                $query = "SELECT withdraw_id, user_id, withdraw_amount, recipient_number, recipient_email, DATE_FORMAT(withdraw_request_date, '%d-%b-%Y') AS formattedDate, DATE_FORMAT(updated, '%d-%b-%Y') AS formattedDate2,
                                        CASE
                                            WHEN status = 1 THEN 'Completed'
                                            WHEN status = 2 THEN 'Pending'
                                            WHEN status = 0 THEN 'Cancelled'
                                        END AS withdrawStatus, type
                                        FROM 
                                            withdrawals
                                        WHERE user_id = $session_user
                                        ORDER BY withdraw_request_date DESC";

                if ($withdraw_stmt = mysqli_prepare($conn, $query)) {
                  mysqli_stmt_execute($withdraw_stmt);

                  mysqli_stmt_bind_result($withdraw_stmt, $withdrawId, $userId, $withdraw_amount, $recipient_number, $recipient_email, $formattedDate, $formattedDate2, $status, $withdraw_type);

                  if (mysqli_stmt_fetch($withdraw_stmt)) {
                    $i = 1;
                    do {
                      echo "<tr class='table-row'>";
                      echo "<td class='table-data rank'>" . $i++ . "</td>";
                      echo "<td class='table-data last-price'>" . htmlspecialchars($formattedDate) . "</td>";

                      if ($withdraw_type == 1) {
                        echo "<td class='table-data last-price red'> Ksh " . number_format($withdraw_amount, 2) . "</td>";
                      } elseif ($withdraw_type == 2) {
                        echo "<td class='table-data last-price red'> USD " . number_format($withdraw_amount / 150, 2) . "</td>";
                      }
                      if ($status === 'Completed') {
                        echo "<td class='table-data last-price green'>" . htmlspecialchars($status) . "</td>";
                      } else if ($status === 'Cancelled') {
                        echo "<td class='table-data last-price red'>" . htmlspecialchars($status) . "</td>";
                      } else if ($status === 'Pending') {
                        echo "<td class='table-data last-price yellow'>" . htmlspecialchars($status) . "</td>";
                      }
                      echo "</tr>";
                    } while (mysqli_stmt_fetch($withdraw_stmt));

                    mysqli_stmt_close($withdraw_stmt);
                  } else {
                    echo '<tr class="table-row"><td colspan="4" class=" table-data market-cap text-center">No records found.</td></tr>';
                  }
                } else {
                  error_log("Error in prepared statement: " . mysqli_error($conn));
                }

                ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="">
          <div class="transaction-tab">
            <ul class="tab-nav">
              <li>
                <button class="tab-btn active">My Stock Investments</button>
              </li>
            </ul>
            <table class=" transaction-table">
              <thead class="table-head">
                <tr class="table-row table-title">
                  <th class="table-heading" scope="col">#</th>

                  <th class="table-heading" scope="col">Stock</th>

                  <th class="table-heading" scope="col">Period</th>

                  <th class="table-heading" scope="col">Amount</th>

                  <th class="table-heading" scope="col">Date Invested</th>

                  <th class="table-heading" scope="col">Return</th>

                  <th class="table-heading" scope="col">Market Status</th>
                </tr>
              </thead>
              <tbody class="table-body">
                <?php
                $i = 1;
                $percentage = 0.25;

                $query = "SELECT i.capital, i.currency_code, DATE_FORMAT(i.investment_date, '%d-%b-%Y') AS date_invested,
                        CASE 
                          WHEN i.investment_status = 1 THEN 'Active'
                          WHEN i.investment_status = 2 THEN 'Pending'
                          WHEN i.investment_status = 0 THEN 'Closed'
                        END AS investment_status, s.stock_name, p.plan_name, s.percentage_interest
                        FROM investments i
                        JOIN stocks s ON i.stock_id = s.stock_id
                        JOIN plans p ON i.plan_id = p.plan_id
                        WHERE i.user_id = $session_user AND i.payment_status = 'Completed'
                        ORDER BY i.investment_date DESC";

                if ($stmt = mysqli_prepare($conn, $query)) {
                  mysqli_stmt_execute($stmt);
                  mysqli_stmt_bind_result($stmt, $amount, $currency_code, $date_invested, $investment_status, $stock_name, $plan_name, $percentage_interest);

                  while (mysqli_stmt_fetch($stmt)) {
                    echo "<tr class='table-row' >";
                    echo "<td>" . $i++ . "</td>";
                    echo "<td class='table-data' >" . htmlspecialchars($stock_name) . "</td>";
                    echo "<td class='table-data market-cap' >" . htmlspecialchars($plan_name) . "</td>";

                    if ($currency_code === 'USD') {
                      echo "<td class='table-data last-update'> Ksh " . number_format($amount * 150, 2) . "</td>";
                    } else {
                      echo "<td class='table-data last-update'> Ksh " . number_format($amount, 2) . "</td>";
                    }

                    echo "<td class='table-data last-price'>" . htmlspecialchars($date_invested) . "</td>";

                    if ($currency_code === 'USD') {
                      echo "<td class='table-data last-update green'> Ksh " . number_format(($amount * 150) * ($percentage_interest / 100), 2) . "</td>";
                    } else {
                      echo "<td class='table-data last-update green'> Ksh " . number_format($amount * ($percentage_interest / 100), 2) . "</td>";
                    }

                    echo "<td class='table-data market-cap'>" . htmlspecialchars($investment_status) . "</td>";
                    echo "</tr>";
                  }
                  if ($i === 1) {
                    // No records found
                    echo '<tr class="table-row"><td colspan="7" class="text-center">No records found.</td></tr>';
                  }

                  mysqli_stmt_close($stmt);
                } else {
                  error_log("Error in prepared statement: " . mysqli_error($conn));
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="">
          <div class="transaction-tab">
            <ul class="tab-nav">
              <li>
                <button class="tab-btn active">My Machine Investments</button>
              </li>
            </ul>
            <table class="transaction-table">
              <thead class="table-head">
                <tr class="table-row table-title">
                  <th class="table-heading" scope="col">#</th>

                  <th class="table-heading" scope="col">Machine</th>

                  <th class="table-heading" scope="col">Period</th>

                  <th class="table-heading" scope="col">Amount</th>

                  <th class="table-heading" scope="col">Date Invested</th>

                  <th class="table-heading" scope="col">Return Rate</th>

                  <th class="table-heading" scope="col">Cycles Made</th>

                  <th class="table-heading" scope="col">Current Profit Value</th>

                  <th class="table-heading" scope="col">Market Status</th>
                </tr>
              </thead>
              <tbody class="table-body">
                <?php
                $i = 1;
                $percentage = 0.25;

                $query = "SELECT i.capital, i.currency_code, DATE_FORMAT(i.investment_date, '%d-%b-%Y') AS date_invested,
                        CASE 
                          WHEN i.investment_status = 1 THEN 'Active'
                          WHEN i.investment_status = 2 THEN 'Pending'
                          WHEN i.investment_status = 0 THEN 'Closed'
                        END AS investment_status, i.machine_cycles, i.current_machine_value, m.machine_name, m.percentage_interest, p.plan_name
                        FROM investments i
                        JOIN machines m ON i.machine_id = m.machine_id
                        JOIN plans p ON i.plan_id = p.plan_id
                        WHERE i.user_id = $session_user AND i.payment_status = 'Completed'
                        ORDER BY i.investment_date DESC";

                if ($stmt = mysqli_prepare($conn, $query)) {
                  mysqli_stmt_execute($stmt);
                  mysqli_stmt_bind_result($stmt, $amount, $currency_code, $date_invested, $investment_status, $cycles, $current_value, $machine_name, $percentage_rate, $plan_name);

                  while (mysqli_stmt_fetch($stmt)) {
                    echo "<tr class='table-row' >";
                    echo "<td>" . $i++ . "</td>";
                    echo "<td class='table-data' >" . htmlspecialchars($machine_name) . "</td>";
                    echo "<td class='table-data market-cap' >" . htmlspecialchars($plan_name) . "</td>";

                    if ($currency_code === 'USD') {
                      echo "<td class='table-data last-update'> Ksh " . number_format($amount * 150, 2) . "</td>";
                    } else {
                      echo "<td class='table-data last-update'> Ksh " . number_format($amount, 2) . "</td>";
                    }

                    echo "<td class='table-data last-price'>" . htmlspecialchars($date_invested) . "</td>";
                    echo "<td class='table-data last-update green'>" . htmlspecialchars($percentage_rate) . "% </td>";
                    echo "<td class='table-data last-update green'>" . htmlspecialchars($cycles) . "</td>";

                    if ($currency_code === 'USD') {
                      echo "<td class='table-data last-update green'> Ksh " . number_format($current_value, 2) . "</td>";
                    } else {
                      echo "<td class='table-data last-update green'> Ksh " . number_format($current_value, 2) . "</td>";
                    }

                    echo "<td class='table-data market-cap'>" . htmlspecialchars($investment_status) . "</td>";
                    echo "</tr>";
                  }
                  if ($i === 1) {
                    // No records found
                    echo '<tr class="table-row"><td colspan="7" class="text-center">No records found.</td></tr>';
                  }

                  mysqli_stmt_close($stmt);
                } else {
                  error_log("Error in prepared statement: " . mysqli_error($conn));
                }
                mysqli_close($conn);

                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>
  </article>
</main>
<!-- widthdraw dialog modal -->
<dialog data-modal class="modal">
  <form action="" method="post" enctype="multipart/form-data" id="withdraw-form">
    <a class="close-btn" data-close-modal="form1"> Close </a>
    <h3>Withdraw Funds</h3>
    <p>For M-Pesa requests, enter your registered M-Pesa number<br>For PayPal requests, enter your PayPal email</p>
    <div class="amount">
      <input type="hidden" id="user_id" name="user_id" value="<?php echo htmlspecialchars($_SESSION["id"]); ?>" required
        readonly />
      <label for="amount">Phone Number:</label>
      <input type="text" name="mpesa_phone" id="mpesa_phone" placeholder="Enter your mpesa number" />
    </div>
    <div class="amount">
      <label for="amount">PayPal Email:</label>
      <input type="email" name="paypal_email" id="paypal_email" placeholder="Enter your paypal email" />
    </div>
    <div class="amount">
      <label for="amount">Amount:</label>
      <input type="text" name="withdraw_amount" id="withdraw_amount" placeholder="Enter amount" required />
    </div>
    <div class="modal-btns">
      <button type="submit" class="modal-btn">Withdraw</button>
    </div>
  </form>
</dialog>



<?php include_once './includes/footer.php'; ?>
<script src="./assets/js/pay.js"></script>
<script>
  // modal
  const openBtn = document.querySelector("[data-open-modal]");
  const closeBtns = document.querySelectorAll("[data-close-modal]");
  const modal = document.querySelector("[data-modal]");
  const modalOverlay = document.createElement("div");
  modalOverlay.classList.add("modal-overlay");

  document.body.appendChild(modalOverlay);

  openBtn.addEventListener("click", () => {
    modal.showModal();
    modalOverlay.style.display = "block";
  });

  closeBtns.forEach((closeBtn) => {
    closeBtn.addEventListener("click", () => {
      modal.close();
      modalOverlay.style.display = "none";
    });
  });

  modalOverlay.addEventListener("click", () => {
    modal.close();
    modalOverlay.style.display = "none";
  });
</script>

<?php include_once './includes/footer-end.php'; ?>