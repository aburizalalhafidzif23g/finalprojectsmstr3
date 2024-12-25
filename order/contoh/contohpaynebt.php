<?php
include("../db/koneksi.php"); // Pastikan ini mengarah ke file koneksi yang benar

// Memeriksa apakah data payment ada di POST
if (!isset($_POST['ktp']) || !isset($_POST['nama']) || !isset($_POST['jenkel']) || 
    !isset($_POST['alamat']) || !isset($_POST['no_tlp']) || !isset($_POST['textTujuan']) || 
    !isset($_POST['textMulai']) || !isset($_POST['textSelesai']) || !isset($_POST['id_mobil']) || 
    !isset($_POST['total_harga'])) {
    die("Data payment tidak ditemukan.");
}

// Mengambil data payment dari POST
$ktp = $_POST['ktp'];
$nama = $_POST['nama'];
$jenkel = $_POST['jenkel'];
$alamat = $_POST['alamat'];
$no_tlp = $_POST['no_tlp'];
$tujuan = $_POST['textTujuan'];
$tanggal_pinjam = $_POST['textMulai'];
$tanggal_selesai = $_POST['textSelesai'];
$id_mobil = $_POST['id_mobil'];
$total_harga = $_POST['total_harga'];
