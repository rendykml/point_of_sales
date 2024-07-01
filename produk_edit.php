<?php
include 'config.php';

session_start();
include 'auth_admincheck.php';

if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];

    $result = mysqli_query($dbconnect, "SELECT * FROM produk WHERE id_produk='$id_produk'");
    $data = mysqli_fetch_assoc($result);

    if (mysqli_num_rows($result) === 0) { // Jika data produk tidak ditemukan
        echo '<script>alert("Data produk tidak ditemukan!"); window.location.href = "produk.php";</script>';
        exit;
    }
} else { // Jika parameter ID tidak ditemukan dalam URL
    echo '<script>alert("ID produk tidak ditemukan!"); window.location.href = "produk.php";</script>';
    exit;
}

if (isset($_POST['update'])) { // Cek apakah form telah disubmit dengan tombol "Update"
    // Mengambil nilai yang dikirimkan melalui form
    $nama = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $jumlah = $_POST['jumlah'];

    // Melakukan update data barang ke dalam database
    mysqli_query($dbconnect, "UPDATE produk SET nama_produk='$nama', harga='$harga', jumlah='$jumlah' WHERE id_produk='$id_produk'");

    $_SESSION['success'] = "Berhasil merubah produk";

    // Mengalihkan halaman kembali ke list barang setelah berhasil melakukan update
    header("location:produk.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perbaruhi Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1>Edit Produk</h1>
        <form method="post">
            <input type="hidden" name="id_produk" value="<?= isset($data['id_produk']) ? $data['id_produk'] : '' ?>">
            <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" name="nama_produk" class="form-control" placeholder="Nama produk" value="<?= isset($data['nama_produk']) ? $data['nama_produk'] : '' ?>">
            </div>
            <div class="form-group">
                <label>Harga</label>
                <input type="text" name="harga" class="form-control" placeholder="Harga Produk" value="<?= isset($data['harga']) ? $data['harga'] : '' ?>">
            </div>
            <div class="form-group">
                <label>Jumlah Stock</label>
                <input type="text" name="jumlah" class="form-control" placeholder="Jumlah Stock" value="<?= isset($data['jumlah']) ? $data['jumlah'] : '' ?>">
            </div>
            <input type="submit" name="update" value="Perbaharu" class="btn btn-primary">
            <a href="produk.php" class="btn btn-warning">Kembali</a>
        </form>
    </div>
</body>

</html>