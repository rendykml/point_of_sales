document.addEventListener("DOMContentLoaded", function () {
    // Ambil semua link dalam sidebar
    const links = document.querySelectorAll('.sidebar ul a');

    // Tambahkan event listener untuk setiap link
    links.forEach(link => {
        link.addEventListener('click', function () {
            // Hapus kelas active dari semua link
            links.forEach(link => link.classList.remove('active'));

            // Tambahkan kelas active ke link yang diklik
            this.classList.add('active');
        });
    });

    // Tambahkan logika untuk mempertahankan status aktif pada muatan halaman
    const currentPage = window.location.pathname.split('/').pop();
    if (currentPage === 'index.php') {
        document.getElementById('dashboard-link').classList.add('active');
    } else if (currentPage === 'user.php') {
        document.getElementById('user-link').classList.add('active');
    } else if (currentPage === 'produk.php') {
        document.getElementById('produk-link').classList.add('active');
    }else if (currentPage === 'history.php') {
        document.getElementById('history-link').classList.add('active');
    }
});