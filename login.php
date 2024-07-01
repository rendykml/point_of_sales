<?php
include "config.php";
session_start();

if (isset($_POST['masuk'])) {

        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = mysqli_query($dbconnect, "SELECT * FROM user_pengguna WHERE username='$username' AND password='$password'");

        // Fetch the result
        $data = mysqli_fetch_assoc($query);

        // Check the number of rows
        if (mysqli_num_rows($query) == 0) {
            $_SESSION['error'] = 'Username dan password salah';
        } else {
            $_SESSION['userid'] = $data['id_user'];
            $_SESSION['nama_user'] = $data['nama_user'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['role_id'] = $data['role_id'];

            header("location:index.php");
            exit;
        }
    }


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style/hal-login.css">
</head>

<body class="bg-dark" >
    <div class="container-fluid">
        <form  method="post" class="mx-auto shadow-lg ">
            <h1 class="text-center">Login</h1>
            <div class="mb-3 mt-5">
                <label for="exampleInputEmail1" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" required >
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1" required >
            </div>

            <!-- Alert -->
            <?php if (isset($_SESSION['error']) && $_SESSION['error'] != '') { ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php } ?>
            <button type="submit" name="masuk" value="Masuk" class="btn btn-primary  ">Masuk</button>
        </form>
    </div>
</body>

</html>