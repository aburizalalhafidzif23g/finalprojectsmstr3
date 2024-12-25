<?php
ob_start();
include("../db/koneksi.php");
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: dashbord_admin.php?x=badmin");
  exit; // Tambahkan exit untuk menghentikan eksekusi lebih lanjut
}
// Ambil data user dari database jika diperlukan
$username = $_SESSION['username'];
// Misalnya, ambil data user dari database
$query = mysqli_query($konek, "SELECT * FROM users WHERE username='$username'");
$userData = mysqli_fetch_array($query);
?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="icon" type="../image/png" href="../img/icon_rent.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">


  <title>Dashboard | Admin</title>
  <style>
    html,
    body {
      height: 100%;
      margin: 0;
      display: flex;
      flex-direction: column;
      color: #fff;
    }

    /* Konten utama */
    .container {
      flex: 1;
      /* Memastikan bagian konten utama mengambil ruang fleksibel */
    }

    /* Footer dinamis */
    .footer {
      background-color: black;
      color: white;
      text-align: center;
    }

    a {
      color: #fff !important;
    }

    i {
      color: black;
    }

    table {
      background-color: #ffff;
    }

    .navbar-nav .nav-item .nav-link {
      transition: background-color 0.3s ease, color 0.3s ease;
      /* Transisi untuk efek hover */
    }

    .navbar-nav .nav-item .nav-link:hover {
      background-color: rgba(255, 255, 255, 0.2);
      /* Ubah warna latar belakang saat hover */
      color: #f0ad4e;
      /* Ubah warna teks saat hover */
    }

    .carousel-caption h5 {
      background-color: rgba(255, 255, 255, 0.7);
      border-radius: 20px;
      padding: 10px 20px;
      display: inline-block;
    }

    h5 {
      color: black;
    }

    /* Gaya untuk foto pengguna */
    .user-photo {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      object-fit: cover;
      margin-right: 10px;
      cursor: pointer;
    }

    .navbar .user-info {
      display: flex;
      align-items: center;
    }

    /* Sidebar Styles */
    .sidebar {
      width: 200px;
      background-color: rgba(42, 159, 214);
      color: #fff;
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      padding-top: 80px;
      z-index: 1000;
    }

    .sidebar img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
    }

    .sidebar h5,
    .sidebar p {
      margin: 0px 0;
    }
    #notificationList .dropdown-item {
    color: black !important;
    }

    #notificationList .dropdown-item:hover {
        background-color: rgba(0, 0, 0, 0.1); /* Menambahkan efek hover jika diinginkan */
    }

    /* Content Styles */
    .content {
      margin-left: 200px;
      padding: 40px 10px 10px;
    }

    /* Responsive Styles */
    @media (max-width: 992px) {
      .sidebar {
        display: none;
      }

      .content {
        margin-left: 0;
        padding-top: 20px;
      }
    }
  </style>
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: rgba(42, 159, 214);">
    <a class="navbar-brand" href="#"><i class="fas fa-car"></i> Dashboard Admin</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <!-- Tombol Logout (Muncul hanya pada layar besar) -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-bell"></i>
              <span class="badge badge-light" id="notificationCount">0</span>
          </a>
            <div class="dropdown-menu" aria-labelledby="notificationDropdown" id="notificationList">
                <a class="dropdown-item" href="#" style="color: black;" id="noNotification">Tidak ada notifikasi</a>
            </div>
        </li>
          <li class="nav-item d-none d-lg-block">
              <a href="../aplikasi/keluar.php" class="btn btn-danger mt-1 col-md-12">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
        </li>

        <!-- Menu Dropdown (Hanya muncul pada layar kecil) -->
        <li class="nav-item dropdown d-lg-none">
          <a class="nav-link dropdown-toggle text-black" href="#" id="sidebarDropdown" role="button"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="bi bi-list"></i> Menu
          </a>
          <div class="dropdown-menu dropdown-menu-right alert-secondary" aria-labelledby="sidebarDropdown">
            <a class="dropdown-item text-dark" href="?x=badmin"><i class="fas fa-home"></i> Home</a>
            <a class="dropdown-item text-dark" href="?x=admin"><i class="fas fa-user"></i> Admin</a>
            <a class="dropdown-item text-dark" href="?x=user"><i class="fas fa-users"></i> User</a>
            <a class="dropdown-item text-dark" href="?x=mobil"><i class="fas fa-car"></i> Mobil</a>
            <a class="dropdown-item text-dark" href="?x=order"><i class="fas fa-shopping-cart"></i> Order</a>
            <button class="dropdown-item dropdown-toggle text-dark" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-file-alt"></i> Laporan
            </button>
            <div class="dropdown-menu " aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="?x=rmobil"><i>Laporan Mobil</i></a>
              <a class="dropdown-item" href="?x=rorder"><i>Laporan Order</i></a>
            </div>
            
            <a class="dropdown-item text-danger" href="../aplikasi/keluar.php">
              <i class="fas fa-sign-out-alt"></i> Logout
            </a>
          </div>
        </li>
      </ul>
    </div>
  </nav>


  <!-- Sidebar (untuk layar besar saja) -->
  <div class="sidebar d-none d-lg-block" style="background-color: rgba(42, 159, 214);">
    <div class="container text-center text-light">
      <a href="?x=badmin" class="btn btn-primary mt-1 col-md-12 text-left"><i class="fas fa-home"></i> Home</a>
      <a href="?x=admin" class="btn btn-info mt-1 col-md-12 text-left"><i class="fas fa-user"></i> Admin</a>
      <a href="?x=user" class="btn btn-primary mt-1 col-md-12 text-left"><i class="fas fa-users"></i> User</a>
      <a href="?x=mobil" class="btn btn-success mt-1 col-md-12 text-left"><i class="fas fa-car"></i> Mobil</a>
      <a href="?x=order" class="btn btn-warning mt-1 col-md-12 text-left"><i class="fas fa-shopping-cart"></i> Order</a>

      <!-- Tombol Laporan -->
      <div class="dropdown mt-1">
        <button class="btn btn-secondary dropdown-toggle text-left btn-block" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-file-alt"></i> Laporan
        </button>
        <div class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
          <a class="dropdown-item" href="?x=rmobil"><i>Laporan Mobil</i></a>
          <a class="dropdown-item" href="?x=rorder"><i>Laporan Order</i></a>
        </div>
      </div>
    </div>
  </div>

  <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #ffffff;">
    <a class="navbar-brand" href="#"><i class=""></i> </a>

  </nav>
  <?php include("../aplikasi/kontrol.php"); ?>
</body>
<footer>
  <style>
    footer {
      background-color: rgba(42, 159, 214);
      /* Warna latar belakang footer */
      padding: 0.5px;
      /* Tambahkan padding untuk footer */
    }

    .container {
      color: #ffff;
    }
    a {
      color: #000;
    }
  </style>

  <div class="container text-center py-4">
    <p class="mb-0">&copy; 2024 Lucky Rent Car. All Rights Reserved.</p>
    <div class="social-icons mt-3">
      <a href="https://www.facebook.com/luki.asluki?mibextid=ZbWKwL" class="mx-2"><i class="fab fa-facebook-f"></i></a>
      <a href="#" class="mx-2"><i class="fab fa-twitter"></i></a>
      <a href="#" class="mx-2"><i class="fab fa-instagram"></i></a>
      <a href="#" class="mx-2"><i class="fab fa-linkedin-in"></i></a>
    </div>
  </div>
</footer>



<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script>
    function checkNotifications() {
    fetch('get_notifications.php')
        .then(response => response.json())
        .then(data => {
            const notificationCount = document.getElementById('notificationCount');
            const notificationList = document.getElementById('notificationList');
            const noNotification = document.getElementById('noNotification');

            notificationCount.textContent = data.count;

            // Clear previous notifications
            notificationList.innerHTML = '';

            if (data.count > 0) {
                // Menampilkan notifikasi untuk setiap booking baru
                for (let i = 0; i < data.count; i++) {
                    const notificationItem = document.createElement('a');
                    notificationItem.className = 'dropdown-item';
                    notificationItem.style.color = 'black';
                    notificationItem.href = `order/bayar.php?id_sewa=${data.booking_ids[i]}`; // Ganti dengan ID booking yang sesuai
                    notificationItem.textContent = `Ada ${data.count} booking baru!`;
                    notificationList.appendChild(notificationItem);
                }
            } else {
                noNotification.textContent = "Tidak ada notifikasi";
            }
        })
        .catch(error => console.error('Error fetching notifications:', error));
}

// Cek notifikasi setiap 5 detik
setInterval(checkNotifications, 5000);
</script>
</body>

</html>