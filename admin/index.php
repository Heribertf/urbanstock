<?php
include("./includes/header.php");
include("./includes/sidebar.php");
?>

<?php
include_once './includes/config.php';
include_once './includes/db_connection.php';
?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
        <!-- Topbar -->
        <?php
        include("./includes/navbar.php");
        ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Welcome Admin</h1>
            </div>

            <!-- Content Row -->
            <div class="row">
                <!-- Earnings (Monthly) Card Example -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        New Stocks Deposits
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php
                                        echo $conn->query("SELECT stock_id FROM `investments` WHERE investment_type = 'stock' AND payment_status = 'unconfirmed'")->num_rows;
                                        ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        New Machine Deposits
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php
                                        echo $conn->query("SELECT machine_id FROM `investments` WHERE investment_type = 'machine' AND payment_status = 'unconfirmed'")->num_rows;
                                        ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Registered Users
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php
                                        echo $conn->query("SELECT userId FROM `users` WHERE type = 2 ")->num_rows;
                                        ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Requests Card Example -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Active Users
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php
                                        echo $conn->query("SELECT userId FROM `users` WHERE type = 2 AND delete_flag = 0 ")->num_rows;
                                        ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-comments fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Total Stocks Investments
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php
                                        $result = $conn->query("SELECT SUM(capital) AS totalStockInvestments FROM `investments` WHERE investment_type = 'stock' AND payment_mode = 'mpesa' AND payment_status = 'Completed'");
                                        $result2 = $conn->query("SELECT SUM(capital) AS totalStockInvestments FROM `investments` WHERE investment_type = 'stock' AND payment_mode = 'paypal' AND payment_status = 'Completed'");

                                        $row = $result->fetch_assoc();
                                        $totalInvestments = $row['totalStockInvestments'];

                                        $rowP = $result2->fetch_assoc();
                                        $totalInvestmentsP = $rowP['totalStockInvestments'];
                                        $totalInvestmentsP = $totalInvestmentsP * 150;
                                        echo 'Ksh ' . number_format($totalInvestments + $totalInvestmentsP, 2);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-comments fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Total Machine Investments
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php
                                        // $result = $conn->query("SELECT SUM(capital) AS totalMachineInvestments FROM `investments` WHERE investment_type = 'machine'");
                                        // $row = $result->fetch_assoc();
                                        // $totalInvestments = $row['totalMachineInvestments'];
                                        // echo 'Ksh ' . number_format($totalInvestments, 2);
                                        
                                        $result3 = $conn->query("SELECT SUM(capital) AS totalMachineInvestments FROM `investments` WHERE investment_type = 'machine' AND payment_mode = 'mpesa' AND payment_status = 'Completed'");
                                        $result4 = $conn->query("SELECT SUM(capital) AS totalMachineInvestments FROM `investments` WHERE investment_type = 'machine' AND payment_mode = 'paypal' AND payment_status = 'Completed'");

                                        $rowM = $result3->fetch_assoc();
                                        $totalInvestmentsM = $rowM['totalMachineInvestments'];

                                        $rowPP = $result4->fetch_assoc();
                                        $totalInvestmentsPP = $rowPP['totalMachineInvestments'];
                                        $totalInvestmentsPP = $totalInvestmentsPP * 150;
                                        echo 'Ksh ' . number_format($totalInvestmentsM + $totalInvestmentsPP, 2);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-comments fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Row -->

            <div class="row">
                <!-- Area Chart -->
                <div class="col-xl-12 col-lg-7">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">
                                Registered Users
                            </h6>
                            <div class="dropdown no-arrow">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                    aria-labelledby="dropdownMenuLink">
                                    <div class="dropdown-header">Dropdown Header:</div>
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas id="myAreaChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->
    <?php
    include("./includes/footer.php");
    ?>
    <?php
    include("./includes/footer_end.php");
    ?>