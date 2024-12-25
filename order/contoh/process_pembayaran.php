<?php
// Include file koneksi database
include("../db/koneksi.php");

// Memeriksa apakah data pembayaran ada di POST
if (!isset($_POST['id_sewa']) || !isset($_POST['total_harga']) || !isset($_POST['payment_method'])) {
    die("Data pembayaran tidak ditemukan.");
}

// Mengambil data pembayaran dari POST
$id_mobil = $_POST['id_sewa'];
$total_harga = $_POST['total_harga'];
$payment_method = $_POST['payment_method'];

// Mengambil data mobil berdasarkan ID
$sql = "SELECT * FROM sewa WHERE id_sewa = ?";
$stmt = $konek->prepare($sql);
$stmt->bind_param("i", $id_sewa);
$stmt->execute();
$result = $stmt->get_result();

// Memeriksa apakah mobil ditemukan
if ($result->num_rows == 0) {
    die("Mobil tidak ditemukan.");
}

$row = $result->fetch_assoc();

// Proses pembayaran
if ($payment_method == "transfer") {
    // Proses transfer bank
    $sql = "INSERT INTO pembayaran (id_sewa, total_harga, metode_pembayaran, status_pembayaran) VALUES (?, ?, ?, 'pending')";
    $stmt = $konek->prepare($sql);
    $stmt->bind_param("iis", $id_sewa, $total_harga, $payment_method);
    $stmt->execute();

    // Tampilkan pesan konfirmasi
    echo "<script>alert('Pembayaran berhasil! Silakan transfer ke rekening kami.');</script>";
    echo "<script>window.location.href='contohkonfirmasi.php';</script>";
} elseif ($payment_method == "credit_card") {
    // Proses kartu kredit
    $sql = "INSERT INTO pembayaran (id_mobil, total_harga, metode_pembayaran, status_pembayaran) VALUES (?, ?, ?, 'pending')";
    $stmt = $konek->prepare($sql);
    $stmt->bind_param("iis", $id_mobil, $total_harga, $payment_method);
    $stmt->execute();

    // Tampilkan pesan konfirmasi
    echo "<script>alert('Pembayaran berhasil! Silakan konfirmasi pembayaran kartu kredit.');</script>";
    echo "<script>window.location.href='../../user/dashboard_user.php';</script>";
} elseif ($payment_method == "cash") {
    // Proses tunai
    $sql = "INSERT INTO pembayaran (id_mobil, total_harga, metode_pembayaran, status_pembayaran) VALUES (?, ?, ?, 'success')";
    $stmt = $konek->prepare($sql);
    $stmt->bind_param("iis", $id_mobil, $total_harga, $payment_method);
    $stmt->execute();

    // Tampilkan pesan konfirmasi
    echo "<script>alert('Pembayaran berhasil!');</script>";
    echo "<script>window.location.href='../../user/dashboard_user.php';</script>";
}

// Tutup koneksi database
$stmt->close();
$konek->close();
?>