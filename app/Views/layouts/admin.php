<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin | Panel</title>
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/dist/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.3.8/css/dataTables.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url('css/main.css') ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet"/>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-expand navbar-light border bg-light px-3">

    <!-- Sidebar Toggle -->
    <button class="btn btn-primary btn-sm" id="toggleSidebar">
        <i id="icons" class="fas fa-bars"></i>
    </button>

    <!-- Dashboard Title -->

    <!-- Push Right -->
    <div class="ml-auto">

        <!-- Profile Dropdown -->
        <div class="dropdown">
            <button class="btn btn-light dropdown-toggle d-flex align-items-center"
                    type="button"
                    id="profileDropdown"
                    data-toggle="dropdown"
                    aria-expanded="false">

                <!-- Profile Image -->
                <img src="/uploads/system/avatar.png"
                     class="rounded-circle border mr-2"
                     width="35"
                     height="35">

                <!-- Session Name -->
                <span class="font-weight-semibold text-dark text-uppercase">
                    <?= session()->get('full_name') ?>
                </span>
            </button>

            <div class="dropdown-menu dropdown-menu-right shadow border-0">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user mr-2"></i> Profile
                </a>

                <a class="dropdown-item" href="#">
                    <i class="fas fa-cog mr-2"></i> Settings
                </a>

                <div class="dropdown-divider"></div>

                <a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </a>
            </div>
        </div>

    </div>

</nav>
<!-- Sidebar -->
<div id="sidebar" class="border bg-light">
    <br>
        <h4 class="ml-3 font-weight-bold text-dark">
        POS Admin Panel
    </h4>

    <a class="nav-link" href="<?= base_url('admin/pos_terminal') ?>"><i class="fa fa-shopping-cart"></i> POS</a>
     <a class="nav-link" href="<?= base_url('admin/dashboard') ?>"><i class="fa fa-home"></i> Dashboard <span class="sr-only">(current)</span></a>
     <a class="nav-link" href="<?= base_url('admin/products') ?>"><i class="fa fa-box"></i> Products</a>
     <a class="nav-link" href="<?= base_url('admin/category') ?>"><i class="fa fa-dice"></i> Categories</a>
     <a class="nav-link" href="<?= base_url('admin/users') ?>"><i class="fa fa-users"></i> Users</a>
    <a class="nav-link" href="<?= base_url('logout') ?>"><i class="fa fa-sign-out"></i> Logout</a>
</div>

<!-- Content -->
<div id="content">
    <div class="container-fluid" style="margin-top:70px;">


        <?= $this->renderSection('content') ?>

    </div>
</div>



<script src="<?= base_url('jquery/jquery.js') ?>"> </script>
<script src="<?= base_url('assets/dist/js/bootstrap.bundle.min.js') ?>"> </script>
<script src="<?= base_url('js/products.js') ?>"></script>
<script src="https://cdn.datatables.net/2.3.8/js/dataTables.min.js"></script>
<script src="<?= base_url('js/users.js') ?>"></script>
<script src="<?= base_url('js/category.js') ?>"></script>
<script src="<?= base_url('js/pos.js') ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function () {
   $("#toggleSidebar").on("click", function () {

    $("#sidebar").toggleClass("collapsed");
    $("#content").toggleClass("expanded");

    // Toggle icon
    $("#icons").toggleClass("fa-bars fa-times");
});
});


</script>

</body>
</html>