<?php
// Include file koneksi database
include("../db/koneksi.php");

// Memeriksa apakah data payment ada di POST
if (!isset($_POST['id_mobil']) || !isset($_POST['tanggal_pinjam']) || !isset($_POST['tanggal_selesai']) || !isset($_POST['payment_method'])) {
    die("Data payment tidak ditemukan.");
}

// Mengambil data payment dari POST
$id_mobil = $_POST['id_mobil'];
$tanggal_pinjam = $_POST['tanggal_pinjam'];
$tanggal_selesai = $_POST['tanggal_selesai'];
$payment_method = $_POST['payment_method'];

// Mengalihkan ke file konfirmasi_pembayaran.php
header("Location: contohkonfirmasi.php?id_mobil=$id_mobil&tanggal_pinjam=$tanggal_pinjam&tanggal_selesai=$tanggal_selesai&payment_method=$payment_method");
exit;
?>