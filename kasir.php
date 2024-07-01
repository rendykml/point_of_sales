<?php
include 'config.php';
session_start();

include 'auth_kasircheck.php';

$produk = mysqli_query($dbconnect, "SELECT * FROM produk");
// print_r($_SESSION);
$sum = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $key => $value) {
        $sum += $value['harga'] * (int)$value['jumlah'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kasir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="style/admin.js"></script>
</head>

<body>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg shadow bg-light">
            <div class="container">
                <a class="navbar-brand text-black" href="index.php"><h4><i>Point Of Sales</i></h4></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-black" href="#" id="profileDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-user me-2 "></i><?= $_SESSION['username']; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                <li><a class="dropdown-item" href="index.php">Nama Asli :</a></li>
                                <li><a class="dropdown-item" href="index.php"><?= $_SESSION['nama_user']; ?></a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container mt-4">
            <div class="row">
                <div class="col-md-8">
                    <h1>Kasir</h1>
                    <h2>Hi <?= $_SESSION['nama_user'] ?></h2>
                    <form method="post" action="keranjang_action.php" class="mt-4">
                        <div class="input-group mb-3 w-50 ">
                            <select class="form-select shadow-sm " required name="id_produk">
                                <option value="">Pilih Produk</option>
                                <?php while ($row = mysqli_fetch_array($produk)) { ?>
                                    <option value="<?= $row['id_produk'] ?>"><?= $row['nama_produk'] ?></option>
                                <?php } ?>
                            </select >
                            <input type="number" name="jumlah" class="form-control shadow-sm" placeholder="Jumlah" required>
                            <button class="btn btn-primary" type="submit">Tambah</button>
                        </div>
                    </form>
                    <a href="reset_keranjang.php">
                        <button class="btn btn-warning" >Reset</button>
                    </a>
                    
                    <form method="post" action="keranjang_update.php">
                   
                        <table class="table table-bordered shadow-sm mt-4">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Sub Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($_SESSION['cart'])) { ?>
                                    <?php foreach ($_SESSION['cart'] as $key => $value) { ?>
                                        <tr>
                                            <td><?= $value['nama'] ?></td>
                                            <td align="right"><?= number_format($value['harga']) ?></td>
                                            <td><input type="number" name="jumlah[]" value="<?= (int)$value['jumlah'] ?>"
                                                    class="form-control"></td>
                                            <td align="right"><?= number_format((int)$value['jumlah'] * $value['harga']) ?></td>
                                            <td><a href="keranjang_hapus.php?id=<?= $value['id'] ?>" class="btn btn-danger"><i class="bi bi-trash"></i></a></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-success" action="keranjang_update.php" >Perbaharui</button>
                    </form>
                </div>                     
                <div class="col-md-4">
                    <div class="card my-3" >
                        <div class="card-header text-center ">
                            <h3 class="mt-2">Total <?= number_format($sum) ?></h3>
                        </div>
                        <div class="card-body" >
                        <form class=" " action="transaksi_action.php" method="POST">
                            <input type="hidden" name="total" value="<?= $sum ?>">
                            <div class="mb-3">
                                <label for="bayar" class="form-label">Bayar : </label>
                                <input class="shadow-s form-control " type="text" id="bayar" name="bayar" class="form-control" required >
                            </div>
                                <button type="submit" class="btn btn-primary">Selesai</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var bayar = document.getElementById('bayar');

        bayar.addEventListener('keyup', function (e) {
            bayar.value = formatRupiah(this.value, 'Rp.');
        });

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }
        function cleanRupiah(rupiah) {
            var clean = rupiah.replace(/\D/g, '');
            return clean;
            // console.log(clean);
        }
    </script>
</body>

</html>