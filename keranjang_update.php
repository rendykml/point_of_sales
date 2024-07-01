<?php
include 'config.php';
session_start();
include "auth_kasircheck.php";
$jumlah = $_POST['jumlah'];
// print_r($_SESSION['cart'][1]);
// print_r($jumlah);

foreach ($_SESSION['cart'] as $key => $value) {
    $_SESSION['cart'][$key]['jumlah'] = $jumlah[$key];
}
header('location:kasir.php');
