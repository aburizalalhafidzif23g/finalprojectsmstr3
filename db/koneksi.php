<?php
$konek = mysqli_connect("localhost", "root", "Aburizalif23g#", "rental3");

if (mysqli_connect_errno()) {
    echo "Koneksi Gagal: " . mysqli_connect_error();
    exit(); // Menghentikan eksekusi jika koneksi gagal
}
?>