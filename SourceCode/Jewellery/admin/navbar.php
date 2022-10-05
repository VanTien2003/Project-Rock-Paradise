<?php
include "connect.php";
$sql = "SELECT * FROM account WHERE role = 'admin' ";
$result = $conn->query($sql);
$admin = [];
if ($result->num_rows > 0) {
    $admin = $result->fetch_all(MYSQLI_ASSOC);
} else {
    echo "Error: " . $conn->error;
}
?>
<!-- sidebar -->
<ul class="sidebar mb-0 list-unstyled" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-item-center justify-content-center p-3" style="text-decoration: none;" href="admin.php">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fa-solid fa-gem"></i>
        </div>
        <div class="sidebar-brand-text ml-2">Rock paradise</div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">Interface</div>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item collapsed">
        <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseTwo">
            <i class="fa-solid fa-user"></i>
            <span>Account</span>
        </a>
        <div id="collapseTwo" class="collapse">
            <div class="bg-white py-2 rounded-lg m-auto " style="width:13rem; font-size: .9rem;">
                <h6 class="dropdown-header">ACCOUNT MANAGEMENT:</h6>
                <a href="listAdmin.php" class="dropdown-item">Admin Information</a>
                <a href="listUser.php" class="dropdown-item">User Information</a>
            </div>
        </div>
    </li>


    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link" href="listProduct.php">
            <i class="fa-solid fa-list"></i>
            <span>Product</span>
        </a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">Addons</div>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item collapsed">
        <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseFour">
            <i class="fa-solid fa-folder"></i>
            <span>Product Attribute</span>
        </a>
        <div id="collapseFour" class="collapse">
            <div class="bg-white py-2 rounded-lg m-auto" style="width:13rem; font-size: .9rem;">
                <a href="brandPage.php" class="dropdown-item">Brand</a>
                <a href="categoryPage.php" class="dropdown-item">Category</a>
                <a href="gemstonePage.php" class="dropdown-item">Gemstone</a>
            </div>
        </div>
    </li>
    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a href="order.php" class="nav-link">
            <i class="fa-solid fa-cart-shopping"></i>
            <span>Orders</span>
        </a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a href="contact.php" class="nav-link">
            <i class="fa-solid fa-address-book"></i>
            <span>Contact</span>
        </a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a href="comments.php" class="nav-link">
            <i class="fa-solid fa-comments"></i>
            <span>Comments</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Sidebar Toggler (Sidebar) -->
    <!-- <div class="d-none d-md-flex text-center justify-content-center">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div> -->
</ul>

<!-- End of Sidebar -->
<!-- Content Wrapper -->
<div id="content-wrapper">
    <!-- Main Content -->
    <div id="content">
        <!-- Topbar -->
        <nav class="navbar navbar-expand-sm navbar-light bg-white topbar mb-4 static-top shadow">
            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggle" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa-solid fa-bars"></i>
            </button>
            <!-- Top Search -->
            <form class="d-none d-sm-inline-block form-inline mw-100 navbar-search">
                <!-- <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 px-3 small" placeholder="Search for...">
                    <div class="input-group-append">
                        <button class="btn btn-primary rounded" type="button">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div> -->
            </form>

            <!-- Topbar navbar -->
            <ul class="navbar-nav info-user">
                <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                <li class="nav-item dropdown d-sm-none">
                    <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown">
                        <i class="fas fa-search fa-fw"></i>
                    </a>
                    <!-- Dropdown - Messages -->
                    <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in">
                        <form class="form-inline mr-auto w-100 navbar-search">
                            <div class="input-group">
                                <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-primary rounded" type="button">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

                <!-- Nav Item - Alerts -->
                <li class="nav-item  mx-1">
                    <a class="nav-link " href="#">
                        <i class="fas fa-bell"></i>
                        <!-- Counter - Alerts -->
                        <span class="badge badge-danger">9+</span>
                    </a>
                </li>
                <!-- Nav Item - Messages -->
                <li class="nav-item  mx-1">
                    <a class="nav-link " href="#">
                        <i class="fas fa-envelope"></i>
                        <!-- Counter - Messages -->
                        <span class="badge badge-danger">6</span>
                    </a>
                </li>

                <div class="" id="topbar-divider"></div>

                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="userDropdown" role="button" data-toggle="dropdown">
                        <?php
                        if (is_array($admin)) {
                            foreach ($admin as $key => $value) {
                        ?>
                                <span class="ml-2 d-none d-lg-inline small text-secondary"><?php if (!empty($value['fullname'])) echo $value['fullname'] ?></span>
                        <?php
                            }
                        }
                        ?>
                        <img style="width: 20%;" class="ml-2 img-profile rounded-circle" src="../public/images/dashboardAdmin/avatar.jpg">
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow">
                        <a class="dropdown-item" href="logout.php">
                            <i class="fas fa-right-from-bracket fa-sm mr-2 text-secondary"></i>
                            Logout
                        </a>
                    </div>
                </li>

            </ul>
        </nav>
        <!-- End of Topbar -->