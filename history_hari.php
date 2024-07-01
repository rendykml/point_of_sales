<?php
include 'config.php';

session_start();

include 'auth_admincheck.php';

if (!isset($_GET['date'])) {
    die("Tanggal tidak tersedia.");
}

$date = $_GET['date'];

$view = $dbconnect->query("SELECT * FROM transaksi WHERE DATE(tanggal_waktu) = '$date' ORDER BY id_transaksi");

if (!$view) {
    die("Error menjalankan query: " . $dbconnect->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Print Riwayat Transaksi - <?= date('d M Y', strtotime($date)) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style/admin.css">
    <style>
        a {
            
            color: black;
        }
    </style>
</head>

<body onload="window.print()">
    <div class="container">
        <div class="table-responsive mt-4 ">
            <a class="text-center" href="history.php"><h2>Riwayat Transaksi - <?= date('d M Y', strtotime($date)) ?></h2></a>
            <table class="table align-middle mt-3">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">ID Transaksi</th>
                        <th>Waktu Transaksi</th>
                        <th>Nomor Transaksi</th>
                        <th>Total Harga</th>
                        <th>Nama Kasir</th>
                        <th>Jumlah Bayar</th>
                        <th>Kembalian</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $view->fetch_array()) { ?>
                        <tr>
                            <th class="ps-5"><?= $row['id_transaksi'] ?></th>
                            <td><?= $row['tanggal_waktu'] ?></td>
                            <td><?= $row['nomor_transaksi'] ?></td>
                            <td><?= $row['total'] ?></td>
                            <td><?= $row['nama_user'] ?></td>
                            <td><?= $row['bayar'] ?></td>
                            <td><?= $row['kembali'] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>