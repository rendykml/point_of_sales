<?php

// membatasi hak akses
if (isset($_SESSION['userid']))
// if ($_SESSION['auth'] == 'Yes') 
{
    if ($_SESSION['role_id'] == 1) {
        header("location:kasir.php");
    }
} else {
    $_SESSION['error'] = '<i>*Login terlebih dahulu!</i>';
    header("location:login.php");
}
