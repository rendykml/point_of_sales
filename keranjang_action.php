<?php
include 'config.php';
session_start();
include 'auth_kasircheck.php';

if (isset($_POST['id_produk'])) {
    $id_produk = $_POST['id_produk'];
    $jumlah = $_POST['jumlah'];

    $data = mysqli_query($dbconnect, "SELECT * FROM produk WHERE id_produk='$id_produk'");
    $a = mysqli_fetch_assoc($data);

    $barang = [
        'id' => $a['id_produk'],
        'nama' => $a['nama_produk'],
        'harga' => $a['harga'],
        'jumlah' => $jumlah

    ];

    $_SESSION['cart'][] = $barang;
    // krsort($_SESSION['cart']);
    header('location:kasir.php');
}
