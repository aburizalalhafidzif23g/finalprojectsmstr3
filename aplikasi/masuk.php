<?php
include("../db/koneksi.php");
session_start();

// Mengamankan input dengan mysqli_real_escape_string
$username = mysqli_real_escape_string($konek, $_POST['textUsername']);
$password = mysqli_real_escape_string($konek, $_POST['textPassword']);



// Cek di tabel admin
$cekAdmin = mysqli_query($konek, "SELECT * FROM admin WHERE username='$username'") or die(mysqli_error($konek));
$dataAdmin = mysqli_fetch_array($cekAdmin);

if ($dataAdmin) {
    // Jika username ditemukan, cek password
    if ($dataAdmin['password'] === $password) { // Ganti dengan password_verify jika password di-hash
        $_SESSION['username'] = $dataAdmin['username'];
        $_SESSION['id_admin'] = $dataAdmin['id_admin'];
        $_SESSION['level'] = $dataAdmin['level'];
        echo "<script>alert('Anda telah login sebagai admin!'); window.location='../admin/dashbord_admin.php?x=badmin';</script>";
        exit();
    } else {
        // Password salah
        echo "<script>alert('Password salah!'); window.location='../login.php';</script>";
        exit();
    }
}

// Jika tidak ditemukan di tabel admin, cek di tabel user
$cekUser  = mysqli_query($konek, "SELECT * FROM users WHERE username='$username'") or die(mysqli_error($konek));
$dataUser  = mysqli_fetch_array($cekUser );

if ($dataUser ) {
    // Jika username ditemukan, cek password
    if (password_verify($password, $dataUser ['password'])) {
        // Password benar
        $_SESSION['username'] = $dataUser ['username'];
        $_SESSION['id_user'] = $dataUser['id_user'];
        echo "<script>alert('Anda telah login sebagai user!'); window.location='../user/dashboard_user.php';</script>";
        exit();
    } else {
        // Password salah
        echo "<script>alert('Password salah!'); window.location='../login.php';</script>";
        exit();
    }
} else {
    // Username tidak ditemukan
    echo "<script>alert('Username tidak ditemukan!'); window.location='../admin/login.php';</script>";
    exit();
}


?>
