<?php
include 'config.php';
session_start();
include 'auth_admincheck.php';

$view = $dbconnect->query("SELECT * FROM transaksi ORDER BY tanggal_waktu DESC, id_transaksi");

if (!$view) {
    die("Error menjalankan query: " . $dbconnect->error);
}

$total_per_day_query = $dbconnect->query("SELECT DATE(tanggal_waktu) as tanggal, SUM(total) as total_pemasukan FROM transaksi GROUP BY DATE(tanggal_waktu) ORDER BY tanggal DESC");

if (!$total_per_day_query) {
    die("Error menjalankan query: " . $dbconnect->error);
}

$total_per_day = [];
while ($row = $total_per_day_query->fetch_assoc()) {
    $total_per_day[$row['tanggal']] = $row['total_pemasukan'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Riwayat Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="style/admin.js"></script>
    <link rel="stylesheet" href="style/admin-flex.css">
    <link rel="stylesheet" href="style/admin.css">
</head>

<body>
    <div class="main-container">
        <div class="sidebar bg-dark text-white" id="side_nav">
            <div class="header-box text-center">
                <h1 class="fs-4">
                    <span class="text-dark rounded shadow px-2 me-1" id="orange">POS</span>
                    <span class="text-white"><i>Menu Admin</i></span>
                </h1>
            </div>
            <ul class="list-unstyled px-2">
                <li><a class="text-decoration-none" href="index.php" id="dashboard-link"><i class="fa-solid fa-house"></i> Dashboard</a></li>
                <li><a class="text-decoration-none" href="user.php" id="user-link"><i class="fa-solid fa-users"></i> Users</a></li>
                <li><a class="text-decoration-none" href="produk.php" id="produk-link"><i class="fa-solid fa-list-check"></i> Produk</a></li>
                <li><a class="text-decoration-none" href="history.php" id="history-link"><i class="fa-solid fa-box"></i> Transaksi</a></li>
            </ul>
        </div>

        <div class="content">
            <nav class="navbar navbar-expand-lg bg-light " id="top_nav">
                <div class="container-fluid pt-2 ps-4">
                    <a class="navbar-brand text-black" href="index.php">
                        <h4><i>Point Of Sales</i></h4>
                    </a>
                    <div class="collapse navbar-collapse justify-content-end">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item dropdown profile-dropdown p-1 me-2">
                                <a class="nav-link dropdown-toggle d-flex align-items-center p-2 text-black" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-user"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                    <li><a class="dropdown-item" href="index.php"><?= $_SESSION['nama_user']; ?></a></li>
                                    <li><a class="dropdown-item" href="index.php">user : <?= $_SESSION['username']; ?></a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- konten riwayat transaksi -->
            <div class="container mt-4">
                <div class="row">
                    <div class="col-12">
                        <div class="p-1 py-4 bg-light rounded">
                            <div class="container ms-1 mt-1">
                                <h1>Riwayat Transaksi</h1>
                                <p>Pilih tanggal transaksi</p>
                                <div class="input-field input-group mb-3 w-50 ">
                                    <button class="btn btn-secondary" onclick="previousDate()">&lt;&lt;</button>
                                    <input type="date" class="border shadow-sm ps-3" id="datePicker" onchange="filterByDate()" />
                                    <button class="btn btn-secondary" onclick="nextDate()"> &gt;&gt;</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container mt-3" id="transaction-container">
                <?php
                $current_date = "";
                while ($row = $view->fetch_array()) {
                    $date = date('Y-m-d', strtotime($row['tanggal_waktu']));
                    if ($date != $current_date) {
                        if ($current_date != "") {
                ?>
                            <tr>
                                <td colspan="5" class="text-end text-success "><b>Total Pemasukan:</b></td>
                                <td class=" text-success " ><b><?= number_format($total_per_day[$current_date], 2); ?></b></td>
                                <td><a href='history_hari.php?date=<?= $current_date; ?>' class='btn btn-primary'>Cetak Data</a></td>
                            </tr>
                            </tbody>
                            </table>
                            </div>
                <?php
                        }
                        $current_date = $date;
                ?>
                        <div class='table-responsive' data-date='<?= $current_date; ?>'>
                            <h2><?= date('d M Y', strtotime($current_date)); ?></h2>
                            <table class='table align-middle'>
                                <thead class='table-light'>
                                    <tr>
                                        <th class='ps-3'>ID Transaksi</th>
                                        <th>Waktu Transaksi</th>
                                        <th>Nomor Transaksi</th>
                                        <th>Nomor Customer</th>
                                        <th>Nama Kasir</th>
                                        <th>Total Harga</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                <?php
                    }
                ?>
                    <tr>
                        <th class='ps-5'><?= $row['id_transaksi']; ?></th>
                        <td><?= $row['tanggal_waktu']; ?></td>
                        <td><?= $row['nomor_transaksi']; ?></td>
                        <td><?= $row['no_customer']; ?></td>
                        <td><?= $row['nama_user']; ?></td>
                        <td><?= number_format($row['total'], 2); ?></td>
                        <td><a href='history_detail.php?id=<?= $row['id_transaksi']; ?>' class='btn btn-info'>Lihat Detail</a></td>
                    </tr>
                <?php
                }
                if ($current_date != "") {
                ?>
                    <tr>
                        <td colspan="5" class="text-end text-success "><b>Total Pemasukan:</b></td>
                        <td ><b class="text-success" ><?= number_format($total_per_day[$current_date], 2); ?></b></td>
                        <td><a href='history_hari.php?date=<?= $current_date; ?>' class='btn btn-primary'>Cetak Data</a></td>
                    </tr>
                    </tbody>
                    </table>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

    <script>
        function filterByDate() {
            var selectedDate = document.getElementById("datePicker").value;
            var tables = document.querySelectorAll("#transaction-container .table-responsive");
            tables.forEach(function(table) {
                if (table.getAttribute("data-date") === selectedDate) {
                    table.style.display = "block";
                } else {
                    table.style.display = "none";
                }
            });
        }

        function previousDate() {
            var datePicker = document.getElementById("datePicker");
            var currentDate = new Date(datePicker.value);
            var previousDate = new Date(currentDate.setDate(currentDate.getDate() - 1)).toISOString().split('T')[0];
            datePicker.value = previousDate;
            filterByDate();
        }

        function nextDate() {
            var datePicker = document.getElementById("datePicker");
            var currentDate = new Date(datePicker.value);
            var nextDate = new Date(currentDate.setDate(currentDate.getDate() + 1)).toISOString().split('T')[0];
            datePicker.value = nextDate;
            filterByDate();
        }
    </script>
</body>

</html>
