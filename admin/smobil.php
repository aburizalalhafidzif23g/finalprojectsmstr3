<?php
include("../db/koneksi.php");

// Ambil data dari form
$nopolisi = $_POST['textPolisi'];
$merk = $_POST['textMerk'];
$tahun = $_POST['textTahun'];
$harga = $_POST['textHarga'];
$deskripsi = $_POST['textDeskripsi'];


// Proses unggah file
$poto = '';
if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
    $target_dir = "../uploads/"; // Direktori penyimpanan
    $poto = $target_dir . basename($_FILES['foto']['name']);
    move_uploaded_file($_FILES['foto']['tmp_name'], $poto);
}
$s_mobil = $_POST['s_mobil'];

// Simpan data ke database
$simpan = mysqli_query($konek, "INSERT INTO mobil (no_polisi, merk, tahun, harga, s_mobil, poto, deskripsi, created_at) 
    VALUES ('$nopolisi', '$merk', '$tahun', '$harga', '$s_mobil', '$poto', '$deskripsi', NOW())");

// Cek apakah berhasil
if ($simpan) {
    header("Location: dashbord_admin.php?x=mobil");
} else {
    die("Error: " . mysqli_error($konek));
}

?>
