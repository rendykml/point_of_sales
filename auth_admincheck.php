<?php
// membatasi hak akses
if (isset($_SESSION['userid']))
// if ($_SESSION['auth'] == 'Yes')
{
    if ($_SESSION['role_id'] == 2) {
        header("location:kasir.php");
    }
} else {
    $_SESSION['error'] = 'Login sebagai admin terlebih dahulu!';
    header("location:login.php");
}
