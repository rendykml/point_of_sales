<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'auth_admincheck.php';


include 'config.php';

if (isset($_POST['simpan'])) {
    // echo var_dump($_POST);
    echo "Form subbmitted<br>";
    $nama = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $jumlah = $_POST['jumlah'];

    mysqli_query($dbconnect, "INSERT INTO produk VALUES ('','$nama','$harga','$jumlah')");
    $_SESSION['success'] = "Berhasil menambahkan Produk";
    header("location:produk.php");
    exit();
}
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
                <li><a class="text-decoration-none" href="history.php" id="history-link"><i class="fa-solid fa-box"></i> transaksi</a></li>
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
            <div class="container">
                <div class="card my-4">
                    <div class="card-header text-center">
                        <h1>Tambah Produk</h1>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="nama_produk" class="form-label">Nama Produk:</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-box"></i></span>
                                    <input type="text" name="nama_produk" class="form-control" id="nama_produk" placeholder="Nama Produk" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="harga" class="form-label">Harga:</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-money-bill"></i></span>
                                    <input type="number" name="harga" class="form-control" id="harga" placeholder="Harga Produk" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="jumlah" class="form-label">Jumlah Stock:</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-cubes"></i></span>
                                    <input type="number" name="jumlah" class="form-control" id="jumlah" placeholder="Jumlah Stock" required>
                                </div>
                            </div>
                            <div class="d-flex ">
                                <button type="submit" name="simpan" class="btn btn-primary me-2 ">Simpan</button>
                                <a href="produk.php" class="btn btn-warning">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </div>
</body>

</html>