<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Urban Stock Investors</title>
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="./assets/vendors/sweetalert2/sweetalert2.min.css">

    <link rel="stylesheet" href="./assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css">

    <link rel="stylesheet" href="./assets/css/investments.css">

</head>

<body>
    <!-- header -->
    <header class="header">
        <div class="header-top">
            <div class="container">
                <div class="contact">
                    <a href="#" class="phone">
                        <img src="assets/images/phone.svg" alt="logo" width="22" height="22" />
                        +1 (929) 517-1743
                    </a>
                    <a href="#" class="email">
                        <img src="assets/images/mail.svg" alt="logo" width="22" height="22" />
                        support@urbanstockinvestments.com
                    </a>
                </div>
                <div class="link-btn">
                    <?php
                    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["user_type"] === 2) {
                        echo '<a href="./logout" class="btn btn-primary" data-nav-link>Logout</a>';
                    } else {
                        echo '<a href="./login" class="btn btn-outline">Login</a>';
                        echo '<a href="./register" class="btn btn-primary">Signup</a>';
                    }

                    $encodedCheck = isset($_SESSION['loggedin']) ? json_encode($_SESSION['loggedin']) : json_encode(false);
                    ?>
                    <input type="hidden" id="conditionCheck" value='<?php echo $encodedCheck; ?>'>
                </div>
            </div>
        </div>
        <div class="header-bottom" data-header>
            <div class="container">
                <a href="#" class="logo">
                    <!-- <img src="assets/images/logo-reason-svgrepo-com.svg" alt="logo" width="52" height="52" /> -->
                    UrbanStockInvestors
                </a>

                <nav class="navbar" data-navbar>
                    <ul class="navbar-list">
                        <li class="navbar-item">
                            <a href="./index" class="navbar-link" data-nav-link>Homepage</a>
                        </li>
                        <li class="navbar-item">
                            <a href="#" class="navbar-link" data-nav-link>Markets</a>
                        </li>
                        <li class="navbar-item">
                            <a href="./investment" class="navbar-link" data-nav-link>Investments</a>
                        </li>
                        <li class="navbar-item">
                            <a href="./machines" class="navbar-link" data-nav-link>Machines</a>
                        </li>
                        <!-- <li class="navbar-item">
                            <a href="#" class="navbar-link" data-nav-link>About</a>
                        </li> -->
                        <li class="navbar-item">
                            <a href="#" class="navbar-link" data-nav-link>Contact</a>
                        </li>
                        <li class="navbar-item">
                            <a href="#" class="navbar-link" data-nav-link>News</a>
                        </li>
                        <li class="navbar-item navbar-auth">
                            <div class="link-btn">
                                <?php
                                if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["user_type"] === 2) {
                                    echo '<a href="./logout" class="btn btn-primary" data-nav-link>Logout</a>';
                                } else {
                                    echo '<a href="./login" class="btn btn-outline">Login</a>';
                                    echo '<a href="./register" class="btn btn-primary">Signup</a>';
                                }

                                $encodedCheck = isset($_SESSION['loggedin']) ? json_encode($_SESSION['loggedin']) : json_encode(false);
                                ?>
                                <input type="hidden" id="conditionCheck" value='<?php echo $encodedCheck; ?>'>
                            </div>
                        </li>
                    </ul>
                </nav>
                <button class="nav-toggle-btn" aria-label="Toggle menu" data-nav-toggler>
                    <span class="line line-1"></span>
                    <span class="line line-2"></span>
                    <span class="line line-3"></span>
                </button>
            </div>
        </div>
    </header>