<?php
include("../db/koneksi.php");
session_start();

// Ambil jumlah booking baru
$query = "SELECT id_sewa FROM sewa WHERE konf_pembayaran = 'Sedang Diproses'";
$result = mysqli_query($konek, $query);

$booking_ids = [];
while ($row = mysqli_fetch_assoc($result)) {
    $booking_ids[] = $row['id_sewa'];
}

echo json_encode([
    'count' => count($booking_ids),
    'booking_ids' => $booking_ids
]);
?>
