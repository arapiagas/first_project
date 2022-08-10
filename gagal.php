<?php session_start(); ?>
<?php 
if (isset($_SESSION['admin'])) {
    echo "
    <script>
        alert('Kamu Tidak Memiliki Akses ke Halaman yang Dituju');
        alert('Sistem Akan Mengembalikan Kamu ke Halaman Home Admin');
        alert('Terima Kasih');
        window.location.href = 'new_admin/home.php';
    </script>";
} 
elseif (isset($_SESSION['petugas'])) {
    echo "
    <script>
        alert('Kamu Tidak Memiliki Akses ke Halaman yang Dituju');
        alert('Sistem Akan Mengembalikan Kamu ke Halaman Home Petugas');
        alert('Terima Kasih');
        window.location.href = 'new_petugas/home.php';
    </script>";
} 
elseif (isset($_SESSION['siswa'])) {
    echo "
    <script>
        alert('Kamu Tidak Memiliki Akses ke Halaman yang Dituju');
        alert('Sistem Akan Mengembalikan Kamu ke Halaman Home Siswa');
        alert('Terima Kasih');
        window.location.href = 'new_siswa/home.php';
    </script>";
} else {
    echo "
    <script>
        alert('Maaf URL yang Kamu Inginkan Tidak Ditemukan');
        window.location.href = 'kembali.php';
    </script>";
}
?>