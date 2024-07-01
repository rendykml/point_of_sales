<?php
session_start();

include 'auth_admincheck.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>List Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="style/admin.js" ></script>
    <link rel="stylesheet" href="style/admin-flex.css">
    <link rel="stylesheet" href="style/admin.css">
   
  
    </style>
</head>

<body>
    <div class="main-container">
        <div class="sidebar bg-dark text-white" id="side_nav">
            <div class="header-box text-center">
                <h1 class="fs-4">
                    <span class="text-dark rounded shadow px-2 me-1" id="orange">POS</span>
                    <span class="text-white"><i>Menu Admin</i></span>
                </h1>
            </div>
            <ul class="list-unstyled px-2">
                <li><a class="text-decoration-none" href="index.php" id="dashboard-link"><i class="fa-solid fa-house"></i> Dashboard</a></li>
                <li><a class="text-decoration-none" href="user.php" id="user-link"><i class="fa-solid fa-users"></i> Users</a></li>
                <li><a class="text-decoration-none" href="produk.php" id="produk-link"><i class="fa-solid fa-list-check"></i> Produk</a></li>
                <li><a class="text-decoration-none" href="history.php" id="produk-link"><i class="fa-solid fa-box"></i> transaksi</a></li>
            </ul>
        </div>

        <div class="content">
            <nav class="navbar navbar-expand-lg bg-light " id="top_nav">
                <div class="container-fluid pt-2 ps-4 " >
                    <a class="navbar-brand text-black" href="index.php"><h4><i>Point Of Sales</i></h4></a>
                    <div class="collapse navbar-collapse justify-content-end">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item dropdown profile-dropdown p-1 me-2">
                                <a class="nav-link dropdown-toggle d-flex align-items-center p-2 text-black" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-user"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                    <li><a class="dropdown-item" href="index.php"><?= $_SESSION['nama_user']; ?></a></li>
                                    <li><a class="dropdown-item" href="index.php">user : <?= $_SESSION['username']; ?></a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        <!-- New container for welcome message and actions -->
            <div class="container mt-4">
                <div class="row">
                    <div class="col-12">
                        <div class="p-4 bg-light rounded">
                            <h2>Selamat datang</h2>
                            <h2><?= $_SESSION['nama_user']; ?>! <i class="fa-solid fa-hands fa-bounce"></i></h2>
                            <p>Silakan tambahkan pengguna atau produk:</p>
                            <div class="d-flex">
                                <a href="user_add.php" class="btn btn-primary ms-2 me-2">Tambah User</a>
                                <a href="produk_add.php" class="btn btn-success">Tambah Produk</a>
                                <a href="logout.php" class="btn btn-danger ms-auto ">Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of new container -->
            
            
    </div>
</body>

</html>