<?php
include 'config.php';
session_start();
include 'auth_admincheck.php';

$role = mysqli_query($dbconnect, "SELECT * FROM role");

if (isset($_POST['simpan'])) {
    // Ambil data dari form
    $nama = $_POST['nama_user'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role_id = $_POST['role_id'];
    $nomor_handphone = $_POST['nomor_handphone'];
    $alamat = $_POST['alamat'];

    // Siapkan query untuk menambahkan pengguna baru
    $query = "INSERT INTO user_pengguna (nama_user, username, password, role_id, nomor_handphone, alamat) 
              VALUES ('$nama', '$username', '$password', '$role_id', '$nomor_handphone', '$alamat')";

    try {
        // Coba eksekusi query
        if (mysqli_query($dbconnect, $query)) {
            $_SESSION['success'] = "Berhasil menambahkan user";
        } else {
            throw new Exception(mysqli_error($dbconnect));
        }
    } catch (Exception $e) {
        // Tangkap pesan error dan tampilkan sesuai jenis error
        if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
            $_SESSION['error'] = "Gagal menambahkan user (username sudah ada)";
        } else {
            $_SESSION['error'] = "Gagal menambahkan user (".$e->getMessage().")";
        }
    }

    // Redirect ke halaman user
    header("location:user.php");
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
            <div class="container px-auto w-50 ">
                <div class="card my-4 border-none ">
                    <div class="card-header text-center">
                        <h1>Tambah User</h1>
                    </div>
                    <div class="card-body">
                    <form action="" method="post">
                        <div class="form-group mb-4">
                            <label>Nama User :</label>
                            <input type="text" name="nama_user" class="form-control" placeholder="" required>
                        </div>
                        <div class="input-group mb-4">
                            <span class="input-group-text" id="basic-addon1">@</span>
                            <input type="text" name="username" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                            <span class="input-group-text" id="basic-addon2"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="masukan password" aria-label="Recipient's username" aria-describedby="basic-addon2" required >
                           
                        </div>   
                        
                        <div class="input-group mb-4">
                            <label class="input-group-text" for="inputGroupSelect01"><i class="fa-solid fa-key fa-fade"></i></label>
                            <select class="form-select" id="inputGroupSelect01" name="role_id" required>
                                <option value="">Pilih Role</option>
                                <?php
                                while ($row = mysqli_fetch_array($role)) { ?>
                                    <option value="<?= $row['id_role'] ?>"><?= $row['nama']?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group mb-4">
                            <label><i class="fa-solid fa-phone ms-2 me-1"></i> Nomor HP :</label>
                            <input type="text" name="nomor_handphone" class="form-control" placeholder="(+62)8" pattern="\+62[0-9]{8,12}" required>
                            <small class="form-text text-muted">*harus 8-12 digit</small>
                        </div>
                        <div class="form-group mb-4">
                            <label><i class="fa-solid fa-location-dot ms-2 fa-"></i> Alamat :</label>
                            <input type="text" name="alamat" class="form-control" placeholder="" required>
                        </div>
                        <div class="d-flex">
                            <input type="submit" name="simpan" value="Simpan" class="btn btn-primary me-2">
                            <a href="user.php" class="btn btn-warning">Kembali</a>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
            
            
    </div>
</body>

</html>