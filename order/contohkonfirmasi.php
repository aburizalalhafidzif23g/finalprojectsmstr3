<?php
// Include file koneksi database
include("../db/koneksi.php");

// Memeriksa apakah data konfirmasi pembayaran ada di GET
if (!isset($_GET['id_sewa']) || !isset($_GET['tanggal_pinjam']) || !isset($_GET['tanggal_selesai']) || !isset($_GET['payment_method'])) {
    die("Data konfirmasi pembayaran tidak ditemukan.");
}

// Mengambil data konfirmasi pembayaran dari GET
$id_mobil = $_GET['id_mobil'];
$tanggal_pinjam = $_GET['tanggal_pinjam'];
$tanggal_selesai = $_GET['tanggal_selesai'];
$payment_method = $_GET['payment_method'];

// Menampilkan form upload bukti pembayaran jika metode pembayaran adalah transfer atau ATM
if ($payment_method == "transfer" || $payment_method == "atm") {
    ?>
    <h2>Konfirmasi Pembayaran</h2>
    <form method="post" action="contohupload.php" enctype="multipart/form-data">
        <input type="hidden" name="id_mobil" value="<?php echo $id_mobil; ?>">
        <input type="hidden" name="tanggal_pinjam" value="<?php echo $tanggal_pinjam; ?>">
        <input type="hidden" name="tanggal_selesai" value="<?php echo $tanggal_selesai; ?>">
        <label for="bukti_pembayaran">Upload Bukti Pembayaran:</label>
        <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" required>
        <button type="submit">Kirim Bukti Pembayaran</button>
    </form>
    <?php
} else {
    echo "<h2>Pembayaran berhasil!</h2>";
    echo "<p>Metode pembayaran: $payment_method</p>";
    echo "<p>Status: Sedang diproses</p>";
}
?>