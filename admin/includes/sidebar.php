<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon">
            <img src="./assets/img/logo-reason-svgrepo-com.svg" alt="" width="50" />
        </div>
        <div class="sidebar-brand-text mx-3">Platform</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0" />

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="./index">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="./registered-users">
            <i class="fas fa-fw fa-users"></i>
            <span>Registered Users</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider" />

    <!-- Heading -->
    <div class="sidebar-heading">Investments</div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
            aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Stocks</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Choose Action:</h6>
                <a class="collapse-item" href="./manage-stocks">Manage Stocks</a>
                <a class="collapse-item" href="./stocks-deposits-mpesa">M-pesa Deposits</a>
                <a class="collapse-item" href="./stocks-deposits-paypal">Paypal Deposits</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Machines</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Choose Action:</h6>
                <a class="collapse-item" href="./manage-machines">Manage Machines</a>
                <a class="collapse-item" href="./machines-deposits-mpesa">M-pesa Deposits</a>
                <a class="collapse-item" href="./machines-deposits-paypal">Paypal Deposits</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true"
            aria-controls="collapseThree">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Payments</span>
        </a>
        <div id="collapseThree" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Choose Action:</h6>
                <a class="collapse-item" href="./mpesa-requests">M-pesa Requests</a>
                <a class="collapse-item" href="./paypal-requests">Paypal Requests</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider" />

    <!-- Heading -->
    <div class="sidebar-heading">System</div>

    <!-- Nav Item - Charts -->
    <!-- <li class="nav-item">
              <a class="nav-link" href="system-admins.php">
                  <i class="fas fa-fw fa-chart-area"></i>
                  <span>System Admins</span></a>
          </li> -->

    <!-- Nav Item - Tables -->
    <!-- <li class="nav-item">
              <a class="nav-link" href="register-admin.php">
                  <i class="fas fa-fw fa-table"></i>
                  <span>Admin Register</span></a>
          </li> -->

    <li class="nav-item">
        <a class="nav-link" href="logout">
            <i class="fas fa-fw fa-table"></i>
            <span>Logout</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block" />

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>