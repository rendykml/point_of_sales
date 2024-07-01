<?php
include 'config.php';
session_start();
include 'auth_kasircheck.php';

$id = $_GET['id'];

$cart = $_SESSION['cart'];
//      print_r($cart);
$k = array_filter($cart, function ($var) use ($id) {
    return ($var['id'] == $id);
});
print_r($k);


foreach ($k as $key => $value) {
    if ($value['id'] == $id) {
        unset($_SESSION['cart'][$key]);
    }
    $_SESSION['cart'] = array_values($_SESSION['cart']);
    break;
}


header('location:kasir.php');
