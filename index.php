<?php
include_once './includes/header.php';
include_once './includes/config.php';
include_once './includes/db_connection.php';
?>
<main>
    <article>
        <!-- hero -->
        <section class="section hero" aria-label="hero">
            <div class="container">
                <div class="hero-content">
                    <h1 class="h1 hero-title">
                        Unlock Your Financial Potential with Smart Investing
                    </h1>

                    <p class="hero-text">
                        Discover curated investment opportunities tailored to your
                        financial goals. Whether you're a seasoned investor or just
                        getting started, our platform provides the tools and insights
                        you need to make informed decisions and grow your wealth.
                    </p>

                    <a href="#" class="btn btn-primary">Get started now</a>
                </div>
            </div>
        </section>
        <!-- market -->
        <section class="section trend" aria-label="crypto trend">
            <div class="container">
                <div class="trend-tab">
                    <ul class="tab-nav">
                        <li>
                            <button class="tab-btn" data-filter=".group-1">
                                Top Stocks
                            </button>
                        </li>

                        <li>
                            <button class="tab-btn" data-filter=".group-2">
                                Gainers
                            </button>
                        </li>

                        <li>
                            <button class="tab-btn" data-filter=".group-3">Losers</button>
                        </li>
                    </ul>

                    <ul class="tab-content">
                        <li class="group-1">
                            <div class="trend-card">
                                <!-- TradingView Widget BEGIN -->
                                <div class="tradingview-widget-container">
                                    <div class="tradingview-widget-container__widget"></div>
                                    <script type="text/javascript"
                                        src="https://s3.tradingview.com/external-embedding/embed-widget-single-quote.js"
                                        async>
                                            {
                                                "symbol": "NASDAQ:AAPL",
                                                    "width": "100%",
                                                        "isTransparent": true,
                                                            "colorTheme": "dark",
                                                                "locale": "en"
                                            }
                                        </script>
                                </div>
                                <!-- TradingView Widget END -->

                            </div>
                        </li>

                        <li class="group-1">
                            <div class="trend-card">
                                <!-- TradingView Widget BEGIN -->
                                <div class="tradingview-widget-container">
                                    <div class="tradingview-widget-container__widget"></div>
                                    <script type="text/javascript"
                                        src="https://s3.tradingview.com/external-embedding/embed-widget-single-quote.js"
                                        async>
                                            {
                                                "symbol": "NASDAQ:AMZN",
                                                    "width": "100%",
                                                        "isTransparent": true,
                                                            "colorTheme": "dark",
                                                                "locale": "en"
                                            }
                                        </script>
                                </div>
                                <!-- TradingView Widget END -->

                            </div>
                        </li>

                        <li class="group-1">
                            <div class="trend-card">
                                <!-- TradingView Widget BEGIN -->
                                <div class="tradingview-widget-container">
                                    <div class="tradingview-widget-container__widget"></div>
                                    <script type="text/javascript"
                                        src="https://s3.tradingview.com/external-embedding/embed-widget-single-quote.js"
                                        async>
                                            {
                                                "symbol": "NASDAQ:GOOGL",
                                                    "width": "100%",
                                                        "isTransparent": true,
                                                            "colorTheme": "dark",
                                                                "locale": "en"
                                            }
                                        </script>
                                </div>
                                <!-- TradingView Widget END -->

                            </div>
                        </li>
                    </ul>

                </div>
            </div>
        </section>
        <!-- market -->
        <section class="section market" aria-label="market update">
            <div class="container">
                <div class="title-wrapper">
                    <h2 class="h2 section-title">Market Summary</h2>

                    <button class="btn btn-primary" data-open-modal="choose-stock">
                        Invest
                    </button>
                    <!-- <a href="chart.html" class="btn-link">Chart Data</a> -->
                </div>

                <div class="market-tab">
                    <ul class="tab-nav">
                        <li>
                            <button class="tab-btn active">All Stocks</button>
                        </li>
                    </ul>

                    <table class="market-table">
                        <!-- TradingView Widget BEGIN -->
                        <div class="tradingview-widget-container">
                            <div class="tradingview-widget-container__widget"></div>
                            <script type="text/javascript"
                                src="https://s3.tradingview.com/external-embedding/embed-widget-screener.js" async>
                                    {
                                        "width": "100%",
                                            "height": "623",
                                                "defaultColumn": "overview",
                                                    "defaultScreen": "most_capitalized",
                                                        "market": "america",
                                                            "showToolbar": true,
                                                                "colorTheme": "dark",
                                                                    "locale": "en",
                                                                        "isTransparent": true
                                    }
                                </script>
                        </div>
                        <!-- TradingView Widget END -->
                    </table>
                </div>

                <!-- <button class="btn btn-primary" data-open-modal="choose-stock">
                    Invest
                </button> -->

                <div class="center-button" style="margin: 0 auto; text-align: center;" data-open-modal="choose-stock">
                    <a href="#" style="text-align: center; padding-top: 40px;">Invest Now</a>
                </div>


            </div>
        </section>

        <section class="section plans">
            <div class="container">
                <div class="about-section-el">
                    <img src="assets/images/el-2.png" alt="" />
                </div>
                <h2 class="h2 section-title">Our Machine Plans</h2>

                <p class="section-text">
                    Stacks is a production-ready library of stackable content blocks
                    built in React Native.
                </p>

                <div class="plans-list">
                    <div class="cards__card card">
                        <figure class="blog-banner img-holder">
                            <img src="./assets/images/m1.jpeg" width="400" height="290" loading="lazy" alt="Step 1"
                                class="img-cover" />
                        </figure>
                        <div class="card__content">
                            <h2 class="card__heading" id="v-series">V-series (V1)</h2>
                            <p class="card__price">Minimum Ksh 12,500</p>
                            <input type="hidden" id="v1" name="v1" readonly required value="12500">
                            <input type="hidden" id="v1-id" name="v1-id" readonly required value="1">
                            <ul role="list" class="card__bullets flow">
                                <li>Top 10 US Stocks</li>
                                <li>Return on investment 200%</li>
                                <li>24/7 Priority support</li>
                            </ul>
                            <a href="#basic" class="card__cta cta" id="machine-one"
                                data-open-modal-machine="choose-machine">Invest
                                Now</a>
                        </div>
                    </div>

                    <div class="cards__card card">
                        <figure class="blog-banner img-holder">
                            <img src="./assets/images/m4.jpeg" width="400" height="290" loading="lazy" alt="Step 1"
                                class="img-cover" />
                        </figure>
                        <div class="card__content">
                            <h2 class="card__heading" id="m-series">M-series (M1)</h2>
                            <p class="card__price">Minimum Ksh 8,000</p>
                            <input type="hidden" id="m1" name="m1" readonly required value="8000">
                            <input type="hidden" id="m1-id" name="m1-id" readonly required value="2">
                            <ul role="list" class="card__bullets flow">
                                <li>Top 10 US Stocks</li>
                                <li>Return on investment 200%</li>
                                <li>24/7 Priority support</li>
                            </ul>
                            <a href="#pro" class="card__cta cta" id="machine-two"
                                data-open-modal-machine="choose-machine">Invest
                                Now</a>
                        </div>
                    </div>

                    <div class="cards__card card">
                        <figure class="blog-banner img-holder">
                            <img src="./assets/images/m3.jpeg" width="400" height="290" loading="lazy" alt="Step 1"
                                class="img-cover" />
                        </figure>
                        <div class="card__content">
                            <h2 class="card__heading" id="k-series">K-series (K1)</h2>
                            <p class="card__price">Minimum Ksh 16,000</p>
                            <input type="hidden" id="k1" name="k1" readonly required value="16000">
                            <input type="hidden" id="k1-id" name="k1-id" readonly required value="3">
                            <ul role="list" class="card__bullets flow">
                                <li>Top 10 US Stocks</li>
                                <li>Return on investment 200%</li>
                                <li>24/7 Priority support</li>
                            </ul>
                            <a href="#ultimate" class="card__cta cta" id="machine-three"
                                data-open-modal-machine="choose-machine">Invest Now</a>
                        </div>
                    </div>
                </div>
                <div class="center-button" style="margin: 0 auto; text-align: center;">
                    <a href="machines.php" style="text-align: center">View All Machines</a>
                </div>
            </div>
        </section>

        <!-- profit calculator -->
        <section class="section calculator">
            <div class="container">
                <h2 class="h2 section-title">Profit Calculator</h2>
                <div class="calculator-area">
                    <div class="amount">
                        <label for="amount">Amount</label>
                        <input type="text" name="amount" placeholder="Enter Amount" />
                    </div>
                    <div class="duration">
                        <label for="">Investment Plan</label>
                        <select name="duration" id="">
                            <option selected disabled>Select a duration</option>
                            <option value="3">24 hours</option>
                            <option value="2">1 Week</option>
                            <option value="1">1 month</option>
                        </select>
                    </div>
                    <button class="btn-primary">Calculate Earning</button>
                </div>
            </div>
        </section>
        <!-- modal fired by the calculate btn -->
        <!-- process -->
        <section class="section instruction">
            <div class="container">

                <h2 class="h2 section-title">
                    Start Your Investment Journey with Our Platform
                </h2>

                <p class="section-text">
                    Joining our platform is quick and easy. Follow these simple steps
                    to start building your investment portfolio today.
                </p>

                <ul class="instruction-list">
                    <li>
                        <div class="instruction-card">
                            <p class="card-subtitle">Step 1</p>

                            <h3 class="h3 card-title">Sign Up</h3>

                            <p class="card-text">
                                Start by creating an account on our platform by providing
                                basic information. It's a seamless and secure process.
                            </p>
                        </div>
                    </li>

                    <li>
                        <div class="instruction-card">

                            <p class="card-subtitle">Step 2</p>

                            <h3 class="h3 card-title">Fund your Account</h3>

                            <p class="card-text">
                                Deposit funds into your account using the provided payment
                                method. Your funds are protected with advanced security
                                measures
                            </p>
                        </div>
                    </li>

                    <li>
                        <div class="instruction-card">

                            <p class="card-subtitle">Step 3</p>

                            <h3 class="h3 card-title">Explore Opportunities</h3>

                            <p class="card-text">
                                Explore a wide range of investment opportunities across
                                different markets. Use our tools to analyze stocks markets.
                            </p>
                        </div>
                    </li>
                </ul>
            </div>
        </section>
        <!-- about -->
        <section class="section about" aria-label="about">
            <div class="container">
                <figure class="about-banner">
                    <img src="./assets/images/Revenue-pana.png" width="748" height="436" loading="lazy"
                        alt="about banner" class="w-100" />
                </figure>

                <div class="about-content">
                    <h2 class="h2 section-title">
                        Join the Thriving Investment Community
                    </h2>

                    <p class="section-text">
                        Our platform provides a diverse range of investment
                        opportunities, enabling you to invest in various stocks. Our
                        expert team will handle trading activities on your behalf,
                        ensuring a comprehensive approach to portfolio management.
                        Explore the world of stock investments with confidence, backed
                        by a team of seasoned professionals.
                    </p>

                    <ul class="section-list">
                        <li class="section-item">
                            <div class="title-wrapper">
                                <ion-icon name="checkmark-circle" aria-hidden="true"></ion-icon>

                                <h3 class="h3 list-title">
                                    Invest in your favourite stocks
                                </h3>
                            </div>

                            <p class="item-text">
                                Explore a vast selection of stocks and invest in your
                                favorite companies, diversifying your portfolio for
                                long-term financial growth.
                            </p>
                        </li>

                        <li class="section-item">
                            <div class="title-wrapper">
                                <ion-icon name="checkmark-circle" aria-hidden="true"></ion-icon>

                                <h3 class="h3 list-title">
                                    Stay Informed with Expert Trading
                                </h3>
                            </div>

                            <p class="item-text">
                                Stay informed with up-to-the-minute stock market prices,
                                empowering you to make timely and informed investment
                                decisions.
                            </p>
                        </li>
                    </ul>

                    <a href="#" class="btn btn-primary">Explore More</a>
                </div>
            </div>
        </section>
        <!-- latest investments, deposits & withdraws -->
        <section class="section latest">
            <div class="container">
                <h2 class="h2 section-title">Our Latest Transactions</h2>
                <div class="latest-columns">
                    <div class="latest-tab">
                        <ul class="tab-nav">
                            <li>
                                <button class="tab-btn active">Latest Deposits</button>
                            </li>
                        </ul>
                        <table class="latest-table">
                            <thead class="table-head">
                                <tr class="table-row table-title">
                                    <th class="table-heading" scope="col">#</th>

                                    <th class="table-heading" scope="col">Username</th>

                                    <th class="table-heading" scope="col">Date</th>

                                    <th class="table-heading" scope="col">Amount</th>

                                    <th class="table-heading" scope="col">Gateway</th>
                                </tr>
                            </thead>
                            <tbody class="table-body">
                                <tr class="table-row">
                                    <th class="table-data rank" scope="row">1</th>

                                    <td class="table-data">James</td>

                                    <td class="table-data last-price">2023-2-12</td>

                                    <td class="table-data last-update green">ksh 45,500</td>

                                    <td class="table-data market-cap">Deposit</td>
                                </tr>
                                <tr class="table-row">
                                    <th class="table-data rank" scope="row">2</th>

                                    <td class="table-data">Cole</td>

                                    <td class="table-data last-price">2023-2-12</td>

                                    <td class="table-data last-update green">ksh 45,500</td>

                                    <td class="table-data market-cap">Deposit</td>
                                </tr>
                                <tr class="table-row">
                                    <th class="table-data rank" scope="row">3</th>

                                    <td class="table-data">Miriam</td>

                                    <td class="table-data last-price">2023-2-12</td>

                                    <td class="table-data last-update green">ksh 45,500</td>

                                    <td class="table-data market-cap">Deposit</td>
                                </tr>
                                <tr class="table-row">
                                    <th class="table-data rank" scope="row">4</th>

                                    <td class="table-data">Austin</td>

                                    <td class="table-data last-price">2023-2-12</td>

                                    <td class="table-data last-update green">ksh 45,500</td>

                                    <td class="table-data market-cap">Deposit</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- latest withdraws -->
                    <div class="latest-tab">
                        <ul class="tab-nav">
                            <li>
                                <button class="tab-btn active">Latest Withdraws</button>
                            </li>
                        </ul>
                        <table class="latest-table">
                            <thead class="table-head">
                                <tr class="table-row table-title">
                                    <th class="table-heading" scope="col">#</th>

                                    <th class="table-heading" scope="col">Username</th>

                                    <th class="table-heading" scope="col">Date</th>

                                    <th class="table-heading" scope="col">Amount</th>

                                    <th class="table-heading" scope="col">Gateway</th>
                                </tr>
                            </thead>
                            <tbody class="table-body">
                                <tr class="table-row">
                                    <th class="table-data rank" scope="row">1</th>

                                    <td class="table-data">Jane224</td>

                                    <td class="table-data last-price">2023-2-12</td>

                                    <td class="table-data last-update green">ksh 45,500</td>

                                    <td class="table-data market-cap">Deposit</td>
                                </tr>
                                <tr class="table-row">
                                    <th class="table-data rank" scope="row">2</th>

                                    <td class="table-data">James8</td>

                                    <td class="table-data last-price">2023-2-12</td>

                                    <td class="table-data last-update green">ksh 45,500</td>

                                    <td class="table-data market-cap">Deposit</td>
                                </tr>
                                <tr class="table-row">
                                    <th class="table-data rank" scope="row">3</th>

                                    <td class="table-data">Donald</td>

                                    <td class="table-data last-price">2023-2-12</td>

                                    <td class="table-data last-update green">ksh 45,500</td>

                                    <td class="table-data market-cap">Deposit</td>
                                </tr>
                                <tr class="table-row">
                                    <th class="table-data rank" scope="row">4</th>

                                    <td class="table-data">Sammy</td>

                                    <td class="table-data last-price">2023-2-12</td>

                                    <td class="table-data last-update green">ksh 45,500</td>

                                    <td class="table-data market-cap">Deposit</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        <!-- testimonials -->
        <!-- <section class="section testimonials"></section> -->
        <!-- faq -->
        <section class="section faq">
            <div class="container">
                <h2 class="h2 section-title">Frequently Asked Questions</h2>
                <div class="accordion">
                    <div class="accordion-item">
                        <button id="accordion-button-1" aria-expanded="false">
                            <span class="accordion-title">How do I create an account on the Platform?</span><span
                                class="icon" aria-hidden="true"></span>
                        </button>
                        <div class="accordion-content">
                            <p>
                                Creating an account is simple. Click on the "Sign Up" button at the top right, provide
                                the required information, and follow the on-screen instructions. Once completed, you'll
                                have access to our platform.
                            </p>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <button id="accordion-button-2" aria-expanded="false">
                            <span class="accordion-title">What type of investments can I make on this
                                platform?</span><span class="icon" aria-hidden="true"></span>
                        </button>
                        <div class="accordion-content">
                            <p>
                                Our platform offers various investment opportunities, including stocks, and machines.
                                You can explore different markets and diversify your portfolio based on your preferences
                                and risk tolerance.
                            </p>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <button id="accordion-button-3" aria-expanded="false">
                            <span class="accordion-title">What currencies does the platform support?</span><span
                                class="icon" aria-hidden="true"></span>
                        </button>
                        <div class="accordion-content">
                            <p>
                                Our platform currently supports two currencies; US Dollar (USD) and Kenyan Shilling
                                (KES). Transactions involving USD are made via PayPal while transactions involving KES
                                are made via M-Pesa. However the platform's base currency is KES but every transaction
                                involving PayPal is automatically converted to USD, from deposits to withdrawals.
                            </p>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <button id="accordion-button-4" aria-expanded="false">
                            <span class="accordion-title">can I use a mobile device on the Platform?</span><span
                                class="icon" aria-hidden="true"></span>
                        </button>
                        <div class="accordion-content">
                            <p>
                                Yes, our platform is mobile-friendly. You can manage your investments on the go by
                                accessing the platform through your mobile browser. At the moment, we do not have a
                                dedicated mobile app.
                            </p>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <button id="accordion-button-5" aria-expanded="false">
                            <span class="accordion-title">How do I contact customer support?</span><span class="icon"
                                aria-hidden="true"></span>
                        </button>
                        <div class="accordion-content">
                            <p>
                                Our customer support team is available 24/7. You can reach us through the "Contact"
                                section on the platform, where you'll find options email support, and a dedicated
                                helpline to assist you with any queries or concerns.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- news -->
        <section class="section blog" id="blog" aria-label="blog">
            <div class="container">
                <h2 class="h2 section-title">Latest News</h2>

                <ul class="blog-list">
                    <li>
                        <div class="blog-card">
                            <figure class="blog-banner img-holder" style="--width: 400; --height: 290">
                                <img src="./assets/images/6464a219d46fe1684316697.jpg" width="400" height="290"
                                    loading="lazy" alt="Step 1" class="img-cover" />
                            </figure>

                            <div class="card-content">
                                <ul class="card-meta-list">
                                    <li class="card-meta-item">
                                        <ion-icon name="person-outline"></ion-icon>

                                        <a href="#" class="item-text">Admin</a>
                                    </li>

                                    <li class="card-meta-item">
                                        <ion-icon name="calendar-outline"></ion-icon>

                                        <time datetime="2022-09-19" class="item-text">September 19, 2022</time>
                                    </li>
                                </ul>

                                <h3>
                                    <a href="#" class="card-title">Cultural exchange week</a>
                                </h3>

                                <p class="card-text">
                                    Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                                    Voluptate doloribus, dignissimos, consequ
                                </p>

                                <a href="#" class="card-link">
                                    <span class="span">Read More</span>

                                    <ion-icon name="caret-forward"></ion-icon>
                                </a>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="blog-card">
                            <figure class="blog-banner img-holder" style="--width: 400; --height: 290">
                                <img src="./assets/images/646876c6d53181684567750.jpg" width="400" height="290"
                                    loading="lazy" alt="Step 2" class="img-cover" />
                            </figure>

                            <div class="card-content">
                                <ul class="card-meta-list">
                                    <li class="card-meta-item">
                                        <ion-icon name="person-outline"></ion-icon>

                                        <a href="#" class="item-text">Admin</a>
                                    </li>

                                    <li class="card-meta-item">
                                        <ion-icon name="calendar-outline"></ion-icon>

                                        <time datetime="2022-09-19" class="item-text">September 19, 2022</time>
                                    </li>
                                </ul>

                                <h3>
                                    <a href="#" class="card-title">Cultural exchange week</a>
                                </h3>

                                <p class="card-text">
                                    Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                                    Voluptate doloribus, dignissimos, consequ
                                </p>

                                <a href="#" class="card-link">
                                    <span class="span">Read More</span>

                                    <ion-icon name="caret-forward"></ion-icon>
                                </a>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="blog-card">
                            <figure class="blog-banner img-holder" style="--width: 400; --height: 290">
                                <img src="./assets/images/6464a1fe408351684316670.jpg" width="400" height="290"
                                    loading="lazy" alt="Step 3" class="img img-cover" />
                            </figure>

                            <div class="card-content">
                                <ul class="card-meta-list">
                                    <li class="card-meta-item">
                                        <ion-icon name="person-outline"></ion-icon>

                                        <a href="#" class="item-text">Admin</a>
                                    </li>

                                    <li class="card-meta-item">
                                        <ion-icon name="calendar-outline"></ion-icon>

                                        <time datetime="2022-09-19" class="item-text">September 19, 2022</time>
                                    </li>
                                </ul>

                                <h3>
                                    <a href="#" class="card-title">Cultural exchange week</a>
                                </h3>

                                <p class="card-text">
                                    Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                                    Voluptate doloribus, dignissimos, consequ
                                </p>

                                <a href="#" class="card-link">
                                    <span class="span">Read More</span>

                                    <ion-icon name="caret-forward"></ion-icon>
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </section>
        <?php
        $dataVariable = $_SESSION['id'];
        ?>
        <input type="hidden" id="dataVariable" value='<?php echo $dataVariable; ?>'>
    </article>
</main>
<dialog data-modal class="modal">
    <!-- stock details -->
    <form id="form1">
        <a class="close-btn" data-close-modal="form1"> Close </a>
        <h3>Invest Stock</h3>
        <div class="stock">
            <label for="">Stock</label>
            <select name="stock" id="stockSelect" required>
                <option selected disabled>Pick a Stock</option>
                <?php

                $query = "SELECT stock_id, stock_name
                        FROM 
                            stocks
                        WHERE stock_status = 1
                            AND delete_flag = 0";

                if ($stmt = mysqli_prepare($conn, $query)) {
                    mysqli_stmt_execute($stmt);

                    mysqli_stmt_bind_result($stmt, $stockId, $stockName);

                    if (mysqli_stmt_fetch($stmt)) {
                        $i = 1;
                        do {
                            echo "<option value='" . htmlspecialchars($stockId) . "'>" . htmlspecialchars($stockName) . "</option>";
                        } while (mysqli_stmt_fetch($stmt));

                        mysqli_stmt_close($stmt);
                    }
                } else {
                    error_log("Error in prepared statement: " . mysqli_error($conn));
                }

                ?>
            </select>
        </div>
        <div class="amount">
            <label for="amount">Amount:</label>
            <input type="number" name="amount" id="amountInput" placeholder="Minimum Ksh 2,500/stock" required />
        </div>
        <div class="duration">
            <label for="">Investment Plan</label>
            <select name="duration" id="durationSelect" required>
                <option selected disabled>Select a duration</option>
                <option value="3">24 hours</option>
                <option value="2">1 Week</option>
                <option value="1">1 month</option>
            </select>
        </div>

        <p style="color: #fff; text-align: center">
            Choose payment Preferred Method
        </p>

        <div class="modal-btns">
            <!-- <button type="button" class="modal-btn" id="next">Next</button> -->
            <button type="button" class="modal-btn" id="mpesa" data-open-mpesa-modal="mpesa">
                Mpesa
            </button>
            <button type="button" class="modal-btn" id="paypal" data-open-paypal-modal="paypal">
                Paypal
            </button>
        </div>
    </form>
</dialog>
<!-- payment -->
<dialog data-modal class="modal">
    <!-- mpesa -->
    <form action="" enctype="multipart/form-data" id="mpesa-payment-form" method="post">
        <a class="close-btn" data-close-modal="mpesa"> Close </a>
        <h3>Invets Stock</h3>
        <div class="payment-img">
            <img src="assets/images/mpesa.png" alt="" class="img-cover" />
        </div>
        <div class="stock">
            <h3>TILL NO: 12345678</h3>
            <h3>Business Name: Platform Investments</h3>
            <h3 id="payment-amount"></h3>
        </div>
        <div class="amount">
            <label for="amount">Transaction Code:</label>
            <input type="text" name="transaction_ref" id="transaction_ref" placeholder="Enter Transaction Code Here..."
                required />
            <input type="hidden" name="stock_invest" id="stock_invest" readonly required />
            <input type="hidden" name="plan_invest" id="plan_invest" readonly required />
            <input type="hidden" name="paying_user_id" id="paying_user_id" readonly required />
            <input type="hidden" name="capital" id="capital" readonly required />
        </div>
        <div class="modal-btns">
            <button id="mpesa-pay-btn" type="submit" class="">Pay Now</button>
            <!-- <button type="button" class="modal-btn" id="m_back">Back</button> -->
        </div>
    </form>
</dialog>
<!-- paypal -->
<dialog data-modal class="modal">
    <form action="<?php echo PAYPAL_URL; ?>" enctype="multipart/form-data" id="paypal-payment-form" method="post">
        <a class="close-btn" data-close-modal="paypal"> Close </a>
        <h3>Invest Stock</h3>

        <div class="payment-img">
            <img src="assets/images/Paypal-Logo.png" alt="" class="img-cover" />
        </div>

        <!-- Identify your business so that you can collect the payments. -->
        <input type="hidden" name="business" value="<?php echo PAYPAL_ID; ?>">

        <!-- Specify a Pay Now button. -->
        <input type="hidden" name="cmd" value="_xclick">

        <input type="hidden" id="p_stock_name" name="item_name">
        <input type="hidden" id="stock_id" name="item_number">
        <input type="hidden" id="amount" name="amount">
        <input type="hidden" id="plan" name="plan">
        <input type="hidden" id="plan_id" name="plan_id">
        <input type="hidden" id="custom_val" name="custom">
        <input type="hidden" name="currency_code" value="<?php echo PAYPAL_CURRENCY; ?>">


        <!-- Specify URLs -->
        <input type="hidden" name="return" value="<?php echo PAYPAL_RETURN_URL; ?>">
        <input type="hidden" name="cancel_return" value="<?php echo PAYPAL_CANCEL_URL; ?>">
        <input type="hidden" name="notify_url" value="<?php echo PAYPAL_NOTIFY_URL; ?>">

        <p style="color: #fff">
            Click on the Pay button to be redirected to paypal payment
        </p>

        <div class="modal-btns">
            <button type="submit" class="modal-btn">Pay Now</button>
        </div>
    </form>
</dialog>

<dialog data-modal-machine class="modal">
    <!-- stock details -->
    <form id="machine-form">
        <a class="close-btn" data-close-modal-machine="machine-form"> Close </a>
        <h3>Invest Machines</h3>
        <div class="stock">
            <h3 id="machine-name"></h3>
            <h3 id="machine-pay-amount"></h3>
        </div>
        <div class="duration">
            <label for="">Investment Plan</label>
            <select name="duration" id="durationSelection" required>
                <option selected disabled>Select a duration</option>
                <option value="3">1 Month</option>
                <option value="2">1 Week</option>
                <option value="1">24 Hours</option>
            </select>
        </div>

        <p style="color: #fff; text-align: center">
            Choose payment Preferred Method
        </p>

        <div class="modal-btns">
            <!-- <button type="button" class="modal-btn" id="next">Next</button> -->
            <button type="button" class="modal-btn" id="machine-mpesa" data-open-machine-mpesa-modal="machine-mpesa">
                Mpesa
            </button>
            <button type="button" class="modal-btn" id="machine-paypal" data-open-machine-paypal-modal="machine-paypal">
                Paypal
            </button>
        </div>
    </form>
</dialog>

<dialog data-modal-machine class="modal">
    <!-- mpesa -->
    <form action="" enctype="multipart/form-data" id="machine-mpesa-payment-form" method="post">
        <a class="close-btn" data-close-modal-machine="mpesa"> Close </a>
        <h3>Invest Machines</h3>
        <div class="payment-img">
            <img src="assets/images/mpesa.png" alt="" class="img-cover" />
        </div>
        <div class="stock">
            <h3>TILL NO: 12345678</h3>
            <h3>Business Name: Platform Investments</h3>
            <h3 id="machine-payment-amount"></h3>
        </div>
        <div class="amount">
            <label for="amount">Transaction Code:</label>
            <input type="text" name="transaction_ref" id="machine_transaction_ref"
                placeholder="Enter Transaction Code Here..." required />
            <input type="hidden" name="machine_invest" id="machine_invest" readonly required />
            <input type="hidden" name="investment_plan" id="investment_plan" readonly required />
            <input type="hidden" name="client_id" id="client_id" readonly required />
            <input type="hidden" name="capital_invested" id="capital_invested" readonly required />
        </div>
        <div class="modal-btns">
            <button id="machine-mpesa-pay-btn" type="submit" class="">Pay Now</button>
        </div>
    </form>
</dialog>

<dialog data-modal-machine class="modal">
    <form action="<?php echo PAYPAL_URL; ?>" enctype="multipart/form-data" id="paypal-machine-payment-form"
        method="post">
        <a class="close-btn" data-close-modal-machine="paypal"> Close </a>
        <h3>Invest Machine</h3>

        <div class="payment-img">
            <img src="assets/images/Paypal-Logo.png" alt="" class="img-cover" />
        </div>

        <!-- Identify your business so that you can collect the payments. -->
        <input type="hidden" name="business" value="<?php echo PAYPAL_ID; ?>">

        <!-- Specify a Pay Now button. -->
        <input type="hidden" name="cmd" value="_xclick">

        <input type="hidden" id="machine_name" name="item_name">
        <input type="hidden" id="machine_id" name="item_number">
        <input type="hidden" id="machine_amount" name="amount">
        <input type="hidden" id="chosen_plan" name="plan">
        <input type="hidden" id="chosen_plan_id" name="plan_id">
        <input type="hidden" id="machine_custom_val" name="custom">
        <input type="hidden" name="currency_code" value="<?php echo PAYPAL_CURRENCY; ?>">


        <!-- Specify URLs -->
        <input type="hidden" name="return" value="<?php echo PAYPAL_RETURN_URL; ?>">
        <input type="hidden" name="cancel_return" value="<?php echo PAYPAL_CANCEL_URL; ?>">
        <input type="hidden" name="notify_url" value="<?php echo PAYPAL_NOTIFY_URL; ?>">

        <p style="color: #fff">
            Click on the Pay button to be redirected to paypal payment
        </p>

        <div class="modal-btns">
            <button type="submit" class="modal-btn">Pay Now</button>
            <!-- <input type="submit" class="modal-btn" name="submit" value="Pay with PayPal"> -->
            <!-- <button type="button" class="modal-btn" id="p_back">Back</button> -->
        </div>
    </form>
</dialog>
<?php include_once './includes/footer.php'; ?>
<script src="./assets/js/form-data.js"></script>

<?php include_once './includes/footer-end.php'; ?>