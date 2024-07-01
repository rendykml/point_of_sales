<?php
include 'config.php';

session_start();
include 'auth_admincheck.php';

$role = mysqli_query($dbconnect, "SELECT * FROM role");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $result = mysqli_query($dbconnect, "SELECT * FROM user_pengguna WHERE id_user='$id'");
    $data = mysqli_fetch_assoc($result);

    if (mysqli_num_rows($result) === 0) { // Jika data user tidak ditemukan
        $_SESSION['error'] = "Data user tidak ditemukan!";
        header("location:user.php");
        exit;
    }
} else { // Jika parameter ID user tidak ditemukan dalam URL
    $_SESSION['error'] = "ID user tidak ditemukan!";
    header("location:user.php");
    exit;
}

if (isset($_POST['update'])) { // Jika form disubmit dengan tombol "Update"
    // Mengambil nilai yang dikirimkan melalui form
    $id = $_POST['id_user'];
    $nama = $_POST['nama_user'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role_id = $_POST['role_id'];
    $nomor_handphone = $_POST['nomor_handphone'];
    $alamat = $_POST['alamat'];

    // Pengecekan apakah username sudah digunakan oleh pengguna lain
    $sql_check_username = "SELECT * FROM user_pengguna WHERE username = ? AND id_user != ?";
    $stmt_check_username = $dbconnect->prepare($sql_check_username);
    $stmt_check_username->bind_param("si", $username, $id);
    $stmt_check_username->execute();
    $result_check_username = $stmt_check_username->get_result();

    if ($result_check_username->num_rows > 0) { // Jika username sudah digunakan
        $_SESSION['error'] = "Gagal mengubah user (username sudah digunakan)";
        $stmt_check_username->close();
        header("location:user_edit.php?id=$id");
        exit();
    } else {
        // Melakukan update data user ke dalam database
        $sql_update_user = "UPDATE user_pengguna SET nama_user=?, username=?, password=?, role_id=?, nomor_handphone=?, alamat=? WHERE id_user=?";
        $stmt_update_user = $dbconnect->prepare($sql_update_user);
        $stmt_update_user->bind_param("ssssssi", $nama, $username, $password, $role_id, $nomor_handphone, $alamat, $id);

        if ($stmt_update_user->execute()) { // Eksekusi statement dan cek apakah berhasil
            $_SESSION['success'] = 'berhasil mengubah user';
        } else {
            $_SESSION['error'] = 'Gagal mengubah user';
        }
        $stmt_update_user->close();
        header("location:user.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perbaharui User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1>Perbaharui User</h1>

        <form method="post">
        <?php if (isset($_SESSION['error']) && $_SESSION['error'] != '') { ?>
        <div class="alert alert-danger" role="alert">
            <?= $_SESSION['error'] ?>
        </div>
        <?php } ?>
            <input type="hidden" name="id_user" value="<?= isset($data['id_user']) ? $data['id_user'] : '' ?>">
            <div class="form-group">
                <label>Nama User</label>
                <input type="text" name="nama_user" class="form-control" placeholder="Nama User" value="<?= isset($data['nama_user']) ? $data['nama_user'] : '' ?>" required>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" placeholder="Username" value="<?= isset($data['username']) ? $data['username'] : '' ?>" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="text" name="password" class="form-control" placeholder="Password" value="<?= isset($data['password']) ? $data['password'] : '' ?>" required>
            </div>
            <div class="form-group">
                <label>Role Akses</label>
                <select class="form-control" name="role_id" required>
                    <option value="">Pilih Role Akses</option>
                    <?php
                    while ($row = mysqli_fetch_array($role)) { ?>
                        <option value="<?= $row['id_role'] ?>" <?= $row['id_role'] == $data['role_id'] ? 'selected' : '' ?>><?= $row['nama'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label>Nomor HP</label>
                <input type="text" name="nomor_handphone" class="form-control" pattern="(\+62[0-9]{8,12}" required value="<?= isset($data['nomor_handphone']) ? $data['nomor_handphone'] : '' ?>">
                <small>Format: (+62) berisi 8-12 digit. Misalnya: +62812345678</small>
                <br><br>
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <input type="text" name="alamat" class="form-control" placeholder="alamat" value="<?= isset($data['alamat']) ? $data['alamat'] : '' ?>" required>
            </div>
            <input type="submit" name="update" value="Perbaharui" class="btn btn-primary">
            <a href="user.php" class="btn btn-warning">Kembali</a>
        </form>
    </div>
</body>

</html>
<?php
// Hapus pesan error setelah ditampilkan
unset($_SESSION['error']);
?>