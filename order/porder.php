<?php
include("../db/koneksi.php");
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['id_user'])) {
    die("Anda harus login untuk melakukan pemesanan.");
}

// Ambil data dari POST
$id_mobil = isset($_POST['id_mobil']) ? intval($_POST['id_mobil']) : null;
$id_user = $_SESSION['id_user']; // Ambil dari session
$nama_sewa = isset($_POST['nama']) ? $_POST['nama'] : null;
$ktp = isset($_POST['ktp']) ? $_POST['ktp'] : null;
$jenkel_sewa = isset($_POST['jenkel']) ? $_POST['jenkel'] : null;
$alamat = isset($_POST['alamat']) ? $_POST['alamat'] : null;
$tlp_sewa = isset($_POST['no_tlp']) ? $_POST['no_tlp'] : null;
$tujuan = isset($_POST['textTujuan']) ? $_POST['textTujuan'] : null;
$tgl_sewa = isset($_POST['textMulai']) ? $_POST['textMulai'] : null;
$tgl_kembali = isset($_POST['textSelesai']) ? $_POST['textSelesai'] : null;

// Validasi tanggal
if (!$tgl_sewa || !$tgl_kembali) {
    echo "<script>alert('Tanggal sewa dan tanggal kembali harus diisi.'); window.history.back();</script>";
    exit;
}

$lama = (strtotime($tgl_kembali) - strtotime($tgl_sewa)) / (60 * 60 * 24);
if ($lama <= 0) {
    echo "<script>alert('Tanggal kembali harus lebih besar dari tanggal sewa.'); window.history.back();</script>";
    exit;
}

// Validasi total harga
$total_harga = isset($_POST['total_harga']) ? floatval($_POST['total_harga']) : 0; // Pastikan berupa float
$harga_total = $total_harga * $lama;

// Masukkan data ke tabel `sewa`
$sql = "INSERT INTO sewa (id_mobil, id_user, nama_sewa, ktp, jenkel_sewa, alamat, tlp_sewa, tujuan, tgl_sewa, tgl_kembali, lama, harga_total, konf_pembayaran) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Belum Bayar')"; // Menambahkan 'Belum Bayar' untuk konf_pembayaran

$stmt = $konek->prepare($sql);
if ($stmt === false) {
    die("Error prepare statement: " . $mysqli_connect_error);
}

if (!$stmt->bind_param("iissssssssii", $id_mobil, $id_user, $nama_sewa, $ktp, $jenkel_sewa, $alamat, $tlp_sewa, $tujuan, $tgl_sewa, $tgl_kembali, $lama, $harga_total)) {
    die("Error bind parameter: " . $stmt->error);
}

// Eksekusi dan cek hasil
if ($stmt->execute()) {
    $id_sewa = $stmt->insert_id; // Mendapatkan ID sewa yang baru dimasukkan
    echo '<script>alert("Anda Sukses Booking, silahkan Melakukan Pembayaran.");
    window.location="bayar.php?id_sewa=' . $id_sewa . '&harga_total=' . $harga_total . '";</script>';
} else {
    // Menampilkan error MySQL jika terjadi kegagalan
    die("Error execute statement: " . $stmt->error);
}

// Tutup statement dan koneksi
$stmt->close();
$konek->close();
?>