<?php
// Include file koneksi database
include("../db/koneksi.php");

// Memeriksa apakah data upload ada di POST
if (!isset($_POST['id_mobil']) || !isset($_POST['tanggal_pinjam']) || !isset($_POST['tanggal_selesai']) || !isset($_FILES['bukti_pembayaran'])) {
    die("Data upload tidak ditemukan.");
}

// Mengambil data dari POST
$id_mobil = $_POST['id_mobil'];
$tanggal_pinjam = $_POST['tanggal_pinjam'];
$tanggal_selesai = $_POST['tanggal_selesai'];

// Mengatur direktori untuk menyimpan bukti pembayaran
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["bukti_pembayaran"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Cek apakah file adalah gambar
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["bukti_pembayaran"]["tmp_name"]);
    if ($check !== false) {
        echo "File adalah gambar - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File bukan gambar.";
        $uploadOk = 0;
    }
}

// Cek apakah file sudah ada
if (file_exists($target_file)) {
    echo "Maaf, file sudah ada.";
    $uploadOk = 0;
}

// Cek ukuran file
if ($_FILES["bukti_pembayaran"]["size"] > 500000) {
    echo "Maaf, ukuran file terlalu besar.";
    $uploadOk = 0;
}

// Hanya izinkan format file tertentu
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    echo "Maaf, hanya file JPG, JPEG, PNG & GIF yang diizinkan.";
    $uploadOk = 0;
}

// Cek apakah $uploadOk diatur ke 0 oleh kesalahan
if ($uploadOk == 0) {
    echo "Maaf, file Anda tidak dapat diupload.";
} else {
    if (move_uploaded_file($_FILES["bukti_pembayaran"]["tmp_name"], $target_file)) {
        // Simpan informasi pembayaran ke database
        $sql = "UPDATE pemesanan SET status_pembayaran = 'sedang diproses', bukti_pembayaran = ? WHERE id_mobil = ? AND tanggal_pinjam = ? AND tanggal_selesai = ?";
        $stmt = $konek->prepare($sql);
        $stmt->bind_param("ssss", $target_file, $id_mobil, $tanggal_pinjam, $tanggal_selesai);
        
        if ($stmt->execute()) {
            echo "Bukti pembayaran berhasil diupload dan status pembayaran telah diperbarui.";
            echo "<br><a href='dashboard_user.php'>Kembali ke Dashboard</a>";
        } else {
            echo "Terjadi kesalahan saat memperbarui status pembayaran: " . $stmt->error;
        }

        // Tutup statement
        $stmt->close();
    } else {
        echo "Maaf, terjadi kesalahan saat mengupload file.";
    }
}

// Tutup koneksi database
$konek->close();
?>