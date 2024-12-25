<?php
include("../db/koneksi.php");
session_start();

// Pastikan user sudah login
if (!isset($_SESSION['id_user'])) {
    die("User  tidak terautentikasi.");
}

$id_user = $_SESSION['id_user'];

// Ambil histori booking untuk user ini
$query = "SELECT s.*, m.merk, m.no_polisi FROM sewa s JOIN mobil m ON s.id_mobil = m.id_mobil WHERE s.id_user = ? ORDER BY s.tgl_sewa DESC";
$stmt = $konek->prepare($query);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();

$booking_history = [];
while ($row = $result->fetch_assoc()) {
    $booking_history[] = $row;
}

echo json_encode($booking_history);
?>