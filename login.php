<?php
session_start();
require 'db/koneksi.php'; // Pastikan path ini sesuai

$error = ""; // Inisialisasi variabel error

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Periksa apakah input sudah diisi
    if (!empty($_POST['username_or_email']) && !empty($_POST['password'])) {
        $usernameOrEmail = $_POST['username_or_email'];
        $password = $_POST['password'];

        // Cek apakah pengguna ada di database berdasarkan username atau email
        $stmt = $konek->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param('ss', $usernameOrEmail, $usernameOrEmail);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            // Jika password benar, simpan informasi pengguna dalam sesi
            $_SESSION['id'] = $user['id']; // Ganti 'user_id' dengan 'id' sesuai struktur tabel Anda
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Alihkan pengguna sesuai dengan role mereka
            if ($user['role'] === 'admin') {
                header("Location: admin/dashbord_admin.php"); // Ganti dengan nama file dashboard admin Anda
                exit();
            } elseif ($user['role'] === 'user') {
                header("Location: user/dashboard_user.php"); // Ganti dengan nama file dashboard user Anda
                exit();
            }
        } else {
            $error = "Username, email, atau password salah.";
        }
    } else {
        $error = "Harap isi semua kolom.";
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Sistem</title>
  <!-- Bootstrap -->
  <link rel="icon" type="../image/png" href="../img/icon-login.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/cyborg/bootstrap.min.css"
    integrity="sha384-nEnU7Ae+3lD52AK+RGNzgieBWMnEfgTbRHIwEvp1XXPdqdO6uLTd/NwXbzboqjc2" crossorigin="anonymous">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <style>
    body {
      background-image: url('img/bg-log.png');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      background-color: #fff;
      height: 100vh;
      color: #fff;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      align-items: center;
    }


    .navbar {
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 1000;
    }



    .clock {
      position: absolute;
      top: 20px;
      left: 20px;
      font-size: 26px;
      animation: fadeIn 1s;
    }

    .login-container {
      margin-top: 100px;
      /* Atur sesuai kebutuhan */
      border-radius: 20px;
      background-color: rgba(50, 50, 50, 0.5);
      box-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
      animation: slideIn 0.5s forwards;
      padding: 20px;
      max-width: 1000px;
      color: black;
    }

    .title {
      text-align: center;
      font-size: 36px;
      font-weight: 800;
      animation: fadeIn 1s;
      color: black;
      text-shadow: 2px 2px 0px white;
    }

    .card {
      background-color: rgba(200, 200, 200, 0.5);
    }

    label {
      color: white;
    }
    i {
      color: #000;
    }

    @keyframes slideIn {
      from {
        transform: translateY(-200%);
      }

      to {
        transform: translateY(0);
      }
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }
    @media (max-width: 768px) {
    h3 {
        font-size: 24px; /* Ukuran font lebih kecil untuk judul */
    }

    .container {
        padding: 10px; /* Padding lebih kecil */
    }

    .table {
        font-size: 14px; /* Ukuran font tabel lebih kecil */
    }

    img {
        width: 100%; /* Gambar akan menyesuaikan lebar kontainer */
        height: auto; /* Tinggi otomatis untuk menjaga rasio aspek */
    }

    .btn {
        width: 100%; /* Tombol akan mengambil lebar penuh */
        margin-bottom: 10px; /* Jarak antar tombol */
    }
}

/* Gaya untuk perangkat dengan lebar maksimum 480px (ponsel kecil) */
@media (max-width: 480px) {
    h3 {
        font-size: 20px; /* Ukuran font lebih kecil untuk judul */
    }

    .table {
        font-size: 12px; /* Ukuran font tabel lebih kecil */
    }

    .form-control {
        font-size: 14px; /* Ukuran font input lebih kecil */
    }

    .form-control-file {
        font-size: 12px; /* Ukuran font input file lebih kecil */
    }
}
  </style>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-primary w-100">
    <a class="navbar-brand" href="#"><i class="fa-solid fa-car"></i> Lucky Rent Car</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php"><i class="fas fa-house" title="Home"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="user/register.php"><i class="fas fa-sign-in" title="Regidter"></i></a>
        </li>
      </ul>
    </div>
  </nav>

  <div class="login-container">
    <div class="card">
      <div class="card-header text-center">
        <h4 class="text-white">Login</h4>
      </div>
      <!-- Tampilkan pesan sukses atau error jika ada -->
      <div class="text-center">
        <?php
        if (!empty($error)) {
          echo "<div class='alert alert-danger'>$error</div>";
        }
        ?>
      </div>

      <div class="card-body">
        <form method="post" action="aplikasi/masuk.php">
          <div class="form-group">
            <label>Username</label>
              <input type="text" class="form-control" name="textUsername">
          </div>
          <div class="form-group">
            <label>Password</label>
              <input type="Password" class="form-control" name="textPassword">
          </div>
            <button type="submit" class="btn btn-primary">Masuk</button>
            <div class="text-center mt-3">
              <p>Belum memiliki akun? <b><a href="user/register.php" class="btn btn-warning">Daftar disini</a></b></p>
            </div>
        </form>
      </div>
    </div>
  </div>

  <div class="container text-center py-4">
      <p class="mb-0">&copy; 2024 Lucky Rent Car. All Rights Reserved.</p>
      <div class="social-icons mt-3">
        <a href="https://www.facebook.com/luki.asluki?mibextid=ZbWKwL" class="mx-2"><i class="fab fa-facebook-f"></i></a>
        <a href="#" class="mx-2"><i class="fab fa-twitter"></i></a>
        <a href="#" class="mx-2"><i class="fab fa-instagram"></i></a>
        <a href="#" class="mx-2"><i class="fab fa-linkedin-in"></i></a>
      </div>
    </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>


