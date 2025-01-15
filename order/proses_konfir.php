<?php
include("../db/koneksi.php");
session_start();

if (!isset($_GET['id'])) {
    echo "<script>alert('ID sewa tidak ditemukan.'); window.history.back();</script>";
    exit;
}

$id_sewa = $_GET['id'];

$nama = isset($_POST['nama']) ? $_POST['nama'] : null;
$no_rek = isset($_POST['no_rek']) ? $_POST['no_rek'] : null;
$total_harga = isset($_POST['total_harga']) ? floatval($_POST['total_harga']) : 0;
$metode_pembayaran = isset($_POST['metode_pembayaran']) ? $_POST['metode_pembayaran'] : null;
$tanggal_pembayaran = isset($_POST['tanggal_pembayaran']) ? $_POST['tanggal_pembayaran'] : null;
$bukti_pembayaran = isset($_FILES['bukti_pembayaran']) ? $_FILES['bukti_pembayaran'] : null;

if (!$nama || !$no_rek || $total_harga <= 0 || !$metode_pembayaran || !$tanggal_pembayaran || !$bukti_pembayaran) {
    echo "<script>alert('Semua filed harus di isi dengan benar.'); window.history.back();</script>";
    exit;
}
if (!preg_match('/^\d+$/', $_POST['no_rek'])) {
    die("Nomor rekening hanya boleh berisi angka.");
}


$target_dir = "../uploads/";
$target_file = $target_dir . basename($bukti_pembayaran['name']);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

if (getimagesize($bukti_pembayaran["tmp_name"]) === false) {
    echo "<script>alert('File bukan gambar.'); window.history.back();</script>";
    exit;
}
if (file_exists($target_file)) {
    echo "<script>alert('File sudah ada.'); window.history.back();</script>";
    exit;
}
if ($bukti_pembayaran["size"] > 100000000) {
    echo "<script>alert('Ukuran file terlalu besar.'); window.history.back();</script>";
    exit;
}
if (!in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
    echo "<script>alert('Hanya file JPG, JPEG, PNG & GIF yang diizinkan.'); window.history.back();</script>";
    exit;
}

if (move_uploaded_file($bukti_pembayaran["tmp_name"], $target_file)) {
    $sql = "INSERT INTO pembayaran (id_sewa, nama, total_harga, metode_pembayaran, no_rek, bukti_pembayaran, tanggal_pembayaran) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $konek->prepare($sql);
    $stmt->bind_param("issssss", $id_sewa, $nama, $total_harga, $metode_pembayaran, $no_rek, $target_file, $tanggal_pembayaran);

    if ($stmt->execute()) {
        // Jika insert berhasil, lanjutkan dengan update status
        $sql2 = "UPDATE sewa SET konf_pembayaran = 'Sedang Diproses' WHERE id_sewa = ?";
        $stmt2 = $konek->prepare($sql2);
        $stmt2->bind_param("i", $id_sewa);

        if ($stmt2->execute()) {
            echo "<script>alert('Konfirmasi pembayaran berhasil!'); window.location='bayar.php?id_sewa=" . $id_sewa . "';</script>";
        } else {
            // Jika update gagal, hapus file yang sudah diunggah
            unlink($target_file);
            echo "<script>alert('Error saat memperbarui data. File telah dihapus.'); window.history.back();</script>";
            exit;
        }

        $stmt2->close();
    } else {
        // Jika insert gagal, hapus file yang sudah diunggah
        unlink($target_file);
        echo "<script>alert('Error saat menyimpan data. File telah dihapus.'); window.history.back();</script>";
        exit;
    }

    $stmt->close();
} else {
    echo "<script>alert('Terjadi kesalahan saat mengupload file.'); window.history.back();</script>";
    exit;
}

// Ambil tanggal booking berdasarkan ID sewa
$sql_booking = "SELECT tgl_sewa FROM sewa WHERE id_sewa = ?";
$stmt_booking = $konek->prepare($sql_booking);
$stmt_booking->bind_param("i", $id_sewa);
$stmt_booking->execute();
$result_booking = $stmt_booking->get_result();

if ($result_booking->num_rows == 0) {
    echo "<script>alert('Data booking tidak ditemukan.'); window.history.back();</script>";
    exit;
}

$data_booking = $result_booking->fetch_assoc();
$tanggal_booking = $data_booking['tgl_sewa'];

// Validasi tanggal transfer
if ($tanggal_pembayaran < $tanggal_booking) {
    echo "<script>alert('Tanggal transfer tidak boleh lebih awal dari tanggal booking.'); window.history.back();</script>";
    exit;
}


$konek->close();
?>