<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'config.php';

session_start();
include 'auth_admincheck.php';


$view = $dbconnect->query("SELECT * FROM produk");

if (!$view) {
    die("Error menjalankan query: " . $dbconnect->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/admin-flex.css">
    <link rel="stylesheet" href="style/admin.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="style/admin.js"></script>
</head>

<body>
    <div class="main-container">
        <!-- Sidebar -->
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
                <li><a class="text-decoration-none" href="history.php" id="history-link"><i class="fa-solid fa-box"></i> transaksi</a></li>
            </ul>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg bg-light" id="top_nav">
                <div class="container-fluid pt-2 ps-4">
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

            <!-- Main Content -->
            <div class="container mt-4">
                <div class="row">
                    <div class="col-12">
                        <div class="p-1 py-4 bg-light rounded">
                            <div class="container ms-1 mt-1">
                                <h1>List Produk</h1>
                                <a href="produk_add.php" class="btn btn-primary ms-2">Tambah data</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container mt-3 table-responsive">
                <table class="table align-middle">
                    <?php if (isset($_SESSION['success']) && $_SESSION['success'] != '') { ?>
                        <div class="alert alert-success ps-4" role="alert">
                            <?= $_SESSION['success'] ?>
                        </div>
                    <?php }
                    $_SESSION['success'] = "";
                    ?>
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">ID Produk</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $view->fetch_array()) { ?>
                            <tr>
                                <th class="ps-5"><?= $row['id_produk'] ?></th>
                                <td><?= $row['nama_produk'] ?></td>
                                <td><?= $row['harga'] ?></td>
                                <td><?= $row['jumlah'] ?></td>
                                <td>
                                    <!-- Link Edit dan Hapus -->
                                    <a class="btn btn-warning" href="produk_edit.php?id=<?= $row['id_produk']; ?>">Edit</a>
                                    <a class="btn btn-danger" href="produk_hapus.php?id=<?= $row['id_produk'] ?>">Hapus</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>