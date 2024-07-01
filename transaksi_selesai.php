<?php
include 'config.php';
session_start();
include 'auth_kasircheck.php';

$id_trx = $_GET['id_trx'];

$data = mysqli_query($dbconnect, "SELECT * FROM transaksi WHERE id_transaksi='$id_trx'");
$trx = mysqli_fetch_assoc($data);
$detail = mysqli_query($dbconnect, "SELECT transaksi_detail.*, produk.nama_produk FROM `transaksi_detail` INNER JOIN produk ON transaksi_detail.id_produk= produk.id_produk WHERE transaksi_detail.id_transaksi='$id_trx'");


// if ($data) {
//     $trx = mysqli_fetch_assoc($data);
//     if (!$trx) {
//         // Jika transaksi tidak ditemukan
//         echo "Transaksi tidak ditemukan.";
//     }
// } else {
//     // Jika query gagal
//     echo "Query gagal.";
// }
// print_r($data);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Kasir</title>
    
    <style type="text/css">
        body {
            color: #a7a7a7;
        }
        a {
            
            color: #a7a7a7;
        }
    </style>
    
</head>

<body>
    <div align="center">
        <table width="500" border="0" cellpadding="1" cellspacing="0">
            <tr>
                <th>Toko YR
                    Jl Pasir Impun 10 <br>
                    Cikadut, Jawa Barat, 40121
                </th>
            </tr>
            <tr align="center">
                <td>
                    <hr>
                </td>
            </tr>
            <tr> <!-- mengambil no transaksi, date time & nama username kasir -->
                <td>No.#<?= $trx['nomor_transaksi'] ?> ||<?= date('d-m-Y H:i:s', strtotime($trx['tanggal_waktu'])) ?> <?= $trx['nama_user'] ?>
                </td>
            </tr>
            <tr>
                <td>
                    <hr>
                </td>
            </tr>
        </table>
        <table width="500" border="0" cellpadding="3" cellspacing="0">
            <?php while ($row = mysqli_fetch_array($detail)) { ?>
                <tr>
                    <td><?= $row['nama_produk'] ?></td>
                    <td><?= $row['jumlah'] ?> item</td>
                    <td align="right">harga satuan <?= number_format($row['harga']) ?></td>
                    <td align="right"><?= number_format($row['total']) ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="4">
                    <hr>
                </td>
            </tr>
            <tr>
                <td align="right" colspan="3">Total Harga</td>
                <td align="right"><?= number_format($trx['total']) ?></td>
            </tr>
            <tr>
                <td align="right" colspan="3">Bayar</td>
                <td align="right"><?= number_format($trx['bayar']) ?></td>
            </tr>
            <tr>
                <td align="right" colspan="3">Kembalian</td>
                <td align="right"><?= number_format($trx['kembali']) ?></td>
            </tr>
        </table>
        <table width="500" border="0" cellpadding="1" cellspacing="0">
            <tr>
                <td>
                    <hr>
                </td>
            </tr>
            <tr>
                <th><a class="text-decoration-none" href="kasir.php">Terimakasih, Selamat Belanja Kembali</a></th>
            </tr>
            <tr>
                <th>===== Layanan Konsumen =====</th>
            </tr>
            <tr>
                <th>SMS/CALL 085640391721</th>
            </tr>
        </table>
    </div>
    <script type="text/javascript">
        window.onload = function() {
            window.print();
        };
    </script>
</body>

</html>