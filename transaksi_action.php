<?php
include 'config.php';
session_start();
include 'auth_kasircheck.php';

$bayar = preg_replace('/\D/', '', $_POST['bayar']);
$tanggal_waktu = date('Y-m-d H:i:s');
$nomor_transaksi = rand(111111, 999999);
$total = $_POST['total'];
$nama_user = $_SESSION['nama_user'];
$kembali = (int)$bayar - (int)$total;

// Insert ke tabel transaksi
$query_transaksi = "INSERT INTO transaksi (
    id_transaksi, tanggal_waktu, nomor_transaksi, total, nama_user, bayar, kembali
) VALUES (
    '', '$tanggal_waktu', '$nomor_transaksi', '$total', '$nama_user', '$bayar', '$kembali'
)";

// Eksekusi query dan cek hasilnya
if (mysqli_query($dbconnect, $query_transaksi)) {
    // Dapatkan ID transaksi yang baru dimasukkan
    $id_transaksi = mysqli_insert_id($dbconnect);

    // Insert ke tabel transaksi_detail
    foreach ($_SESSION['cart'] as $key => $value) {
        $id_produk = $value['id'];
        $harga = $value['harga'];
        $jumlah = $value['jumlah'];
        $total_transaksi = $harga * $jumlah;

        $query_detail = "INSERT INTO transaksi_detail (
            id_transaksi_detail, id_transaksi, id_produk, harga, jumlah, total
        ) VALUES (
            NULL, '$id_transaksi', '$id_produk', '$harga','$jumlah' , '$total_transaksi'
        )";

        mysqli_query($dbconnect, $query_detail);
    }

    $_SESSION['cart'] = [];
    header("location: transaksi_selesai.php?id_trx= $id_transaksi");
    exit();
} else {
    // Tangani error, misalnya log pesan error
    echo "Error: " . mysqli_error($dbconnect);
}
