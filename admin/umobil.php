<?php
include("../db/koneksi.php");

// Ambil data dari form
$nopolisi = $_POST['textPolisi'];
$merk = $_POST['textMerk'];
$tahun = $_POST['textTahun'];
$harga = $_POST['textHarga'];
$s_mobil = $_POST['textS_mobil'];
$deskripsi = $_POST['textDeskripsi'];
$kode = $_POST['kode'];

// Inisialisasi variabel poto
$poto = '';

// Proses unggah file
if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
    $target_dir = "../uploads/"; // Direktori penyimpanan
    $poto = $target_dir . basename($_FILES['foto']['name']);
    move_uploaded_file($_FILES['foto']['tmp_name'], $poto);
} else {
    // Jika tidak ada foto baru, ambil foto yang sudah ada dari database
    $result = mysqli_query($konek, "SELECT poto FROM mobil WHERE id_mobil='$kode'");
    if ($result) {
        $data = mysqli_fetch_array($result);
        $poto = $data['poto']; // Gunakan foto yang sudah ada
    } else {
        die("Error: " . mysqli_error($konek)); // Cek error jika query gagal
    }
}

// Simpan data ke database
$simpan = mysqli_query($konek, "UPDATE mobil SET 
    no_polisi='$nopolisi', 
    merk='$merk', 
    tahun='$tahun', 
    harga='$harga', 
    s_mobil='$s_mobil', 
    poto='$poto', 
    deskripsi='$deskripsi' 
    WHERE id_mobil='$kode'");

// Cek apakah berhasil
if ($simpan) {
    echo "<script>alert('Data berhasil di simpan'); window.location='dashbord_admin.php?x=mobil';</script>";
    exit();
    
} else {
    die("Error: " . mysqli_error($konek)); // Tampilkan error jika update gagal
}
?>