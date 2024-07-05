<?php
include 'config.php';

session_start();

include 'auth_admincheck.php';

if (!isset($_GET['id'])) {
    die("ID transaksi tidak ditemukan.");
}

$id_transaksi = $_GET['id'];

// Mengambil detail transaksi dari tabel transaksi
$query = $dbconnect->prepare("SELECT * FROM transaksi WHERE id_transaksi = ?");
$query->bind_param("i", $id_transaksi);
$query->execute();
$result = $query->get_result();

if ($result->num_rows == 0) {
    die("Transaksi tidak ditemukan.");
}

$transaksi = $result->fetch_assoc();

// Mengambil detail produk dari tabel transaksi_detail
$query_detail = $dbconnect->prepare("SELECT td.*, p.nama_produk FROM transaksi_detail td JOIN produk p ON td.id_produk = p.id_produk WHERE td.id_transaksi = ?");
$query_detail->bind_param("i", $id_transaksi);
$query_detail->execute();
$result_detail = $query_detail->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Detail Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="style/admin.js" ></script>
    <link rel="stylesheet" href="style/admin-flex.css">
    <link rel="stylesheet" href="style/admin.css">
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
        <div class="container mt-3 ms-2 ">
        <h1>Detail Transaksi</h1>
        <table class="table table-bordered">
            <tr>
                <th>ID Transaksi</th>
                <td><?= $transaksi['id_transaksi'] ?></td>
            </tr>
            <tr>
                <th>Tanggal Waktu</th>
                <td><?= $transaksi['tanggal_waktu'] ?></td>
            </tr>
            <tr>
                <th>Nomor Transaksi</th>
                <td><?= $transaksi['nomor_transaksi'] ?></td>
            </tr>
            <tr>
                <th>Nomor Customer</th>
                <td><?= $transaksi['no_customer'] ?></td>
            </tr>
            <tr>
                <th>Total</th>
                <td><?= $transaksi['total'] ?></td>
            </tr>
            <tr>
                <th>Nama Kasir</th>
                <td><?= $transaksi['nama_user'] ?></td>
            </tr>
            <tr>
                <th>Bayar</th>
                <td><?= $transaksi['bayar'] ?></td>
            </tr>
            <tr>
                <th>Kembali</th>
                <td><?= $transaksi['kembali'] ?></td>
            </tr>
        </table>

        <h2>Detail Produk</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Produk</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($detail = $result_detail->fetch_assoc()): ?>
                <tr>
                    <td><?= $detail['id_produk'] ?></td>
                    <td><?= $detail['nama_produk'] ?></td>
                    <td><?= $detail['harga'] ?></td>
                    <td><?= $detail['jumlah'] ?></td>
                    <td><?= $detail['total'] ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="history.php" class="btn btn-primary">Kembali</a>
    </div>
</div>
            
</body>

</html>
