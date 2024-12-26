<?php
require '../db/koneksi.php'; // Pastikan path ini sesuai dengan lokasi koneksi.php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mendapatkan data form
    $nama_lengkap = $_POST['nama_lengkap'];
    $nomor_hp = $_POST['nomor_hp'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Enkripsi password
    $maxFileSize = 50 * 1024 * 1024; // 50MB in bytes
    $foto = null; // Inisialisasi variabel foto

    // Cek duplikasi username, email, atau nomor_hp
    $stmt = mysqli_prepare($konek, "SELECT * FROM users WHERE username = ? OR email = ? OR nomor_hp = ?");
    mysqli_stmt_bind_param($stmt, 'sss', $username, $email, $nomor_hp);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $existing_user = mysqli_fetch_assoc($result);

    if ($existing_user) {
        if ($existing_user['username'] === $username) {
            $error = "Username sudah terdaftar. Silakan gunakan username lain.";
        } elseif ($existing_user['email'] === $email) {
            $error = "Email sudah terdaftar. Silakan gunakan email lain.";
        } elseif ($existing_user['nomor_hp'] === $nomor_hp) {
            $error = "Nomor HP sudah terdaftar. Silakan gunakan nomor HP lain.";
        }
    } else {
        // Proses upload foto
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
            // Periksa ukuran file
            if ($_FILES['foto']['size'] > $maxFileSize) {
                $error = "Ukuran file terlalu besar. Maksimal ukuran file adalah 100MB.";
            } else {
                $foto_name = $_FILES['foto']['name'];
                $foto_tmp = $_FILES['foto']['tmp_name'];
                $foto_extension = pathinfo($foto_name, PATHINFO_EXTENSION);
                $foto_new_name = uniqid() . '.' . $foto_extension;
                $foto_path = 'uploads/' . $foto_new_name;

                // Memindahkan file ke folder upload
                if (move_uploaded_file($foto_tmp, $foto_path)) {
                    $foto = $foto_new_name;
                } else {
                    $foto = null;
                    echo "<script>alert('Gagal mengunggah foto.'); window.location.href = 'register.php';</script>";
                }
            }
        }

        if (!isset($error)) {
            // Menyimpan data pengguna ke database
            $stmt = mysqli_prepare($konek, "INSERT INTO users (nama_lengkap, nomor_hp, username, email, password, foto) VALUES (?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, 'ssssss', $nama_lengkap, $nomor_hp, $username, $email, $password, $foto);

            if (mysqli_stmt_execute($stmt)) {
                $success = "Pendaftaran berhasil! Silakan <a href='../login.php' class='btn btn-warning'>LOGIN</a>.";
            } else {
                $error = "Terjadi kesalahan saat mendaftar.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>

  <link rel="icon" type="image/png" href="../img/icon-login.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/cyborg/bootstrap.min.css"
    integrity="sha384-nEnU7Ae+3lD52AK+RGNzgieBWMnEfgTbRHIwEvp1XXPdqdO6uLTd/NwXbzboqjc2" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body {
      background-image: url('../img/bg-log.png');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      color: #ffffff;
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
      border-radius: 20px;
      background-color: rgba(50, 50, 50, 0.5);
      box-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
      animation: slideIn 0.5s forwards;
      padding: 20px;
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

    .container {
      padding-top: 100px;
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

  <!-- Alert Scripts -->
  <?php if (isset($success) && $success): ?>
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Registrasi Berhasil',
        text: 'Pendaftaran berhasil! Silakan login.',
        confirmButtonText: '<a href="../login.php" style="color: white; text-decoration: none;">Login</a>'
      });
    </script>
  <?php elseif (isset($error)): ?>
    <script>
      Swal.fire({
        icon: 'error',
        title: 'Registrasi Gagal',
        text: '<?php echo $error; ?>'
      });
    </script>
  <?php endif; ?>

  <nav class="navbar navbar-expand-lg navbar-dark bg-primary w-100">
  <a class="navbar-brand" href="#"><i class="fa-solid fa-car" style="color: black;"></i> Lucky Rent Car</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="../index.php"><i class="fas fa-house"></i> Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../login.php"><i class="fas fa-sign-in"></i> Login</a>
        </li>
      </ul>
    </div>
  </nav>

  <div class="clock py-5" id="clock"></div>
  <script>
    function updateClock() {
      const now = new Date();
      const hours = String(now.getHours()).padStart(2, '0');
      const minutes = String(now.getMinutes()).padStart(2, '0');
      const seconds = String(now.getSeconds()).padStart(2, '0');
      document.getElementById('clock').innerText = `${hours}:${minutes}:${seconds}`;
    }
    setInterval(updateClock, 1000);
    updateClock();
  </script>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="login-container">
          <div class="card">
            <div class="card-header text-center">
              <h4 class="text-white">Register</h4>
            </div>

            <!-- Tampilkan pesan sukses atau error jika ada -->
            <div class="d-flex justify-content-center">
              <div class="text-center col-md-8">
                <?php
                if (isset($success)) {
                  echo "<div class='alert alert-success'>$success</div>";
                }
                if (isset($error)) {
                  echo "<div class='alert alert-danger'>$error</div>";
                }
                ?>
              </div>
            </div>

            <div class="card-body">
              <form method="POST" action="" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="foto" class="form-label">Foto</label>
                  <input type="file" class="form-control" id="foto" name="foto" accept="image/*" required>
                </div>
                <div class="form-group">
                  <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                  <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                    placeholder="Nama Lengkap" required>
                </div>
                <div class="form-group">
                  <label for="nomor_hp" class="form-label">Nomor HP</label>
                  <input type="number" class="form-control" id="nomor_hp" name="nomor_hp" placeholder="Nomor HP"
                    required>
                </div>
                <div class="form-group">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                </div>
                <div class="form-group">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                    required>
                </div>
                <!--<div class="form-group">
                  <label for="role" class="form-label">Role</label>
                  <select class="form-control" id="role" name="role" required>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                  </select>
                </div>-->
                <button type="submit" class="btn btn-primary w-100">Register</button>
              </form>
              <div class="text-center mt-3">
                <p>Sudah memiliki akun? <b><a href="../login.php" class="btn btn-success">Login</a></b></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container text-center mb-5">
    <p>&copy; 2024 Lucky Rent Car. All Rights Reserved.</p>
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