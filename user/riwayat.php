<?php
ob_start();
include("../db/koneksi.php");
session_start();
$id_user = $_SESSION['id_user'];
$query = "SELECT s.*, m.merk, m.no_polisi FROM sewa s JOIN mobil m ON s.id_mobil = m.id_mobil WHERE s.id_user = ? ORDER BY s.tgl_sewa DESC";
$stmt = $konek->prepare($query);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();

$booking_history = [];
while ($row = $result->fetch_assoc()) {
    $booking_history[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lucky Rent Car</title>

    <link rel="icon" type="image/png" href="../img/icon_rent.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/cyborg/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../asset/style-indexu.css">
    <style>
        h3 {
            color: #000;
            text-align: center;
        }
        .table td, .table th {
            white-space: nowrap; /* Mencegah teks membungkus */
            overflow: hidden; /* Menyembunyikan teks yang melampaui batas */
            text-overflow: ellipsis; /* Menambahkan elipsis (...) untuk teks yang terpotong */
        }
        .table-responsive {
            overflow-x: auto; /* Menambahkan scroll horizontal */
        }
        .card {
            background-color: white; /* Menjadikan latar belakang putih */
        }
        .table {
            background-color: white; /* Latar belakang tabel putih */
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <a class="navbar-brand" href="#"><i class="fa-solid fa-car"></i> Lucky Rent Car</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="javascript:history.back()">Kembali</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../index.php"><i class="fas fa-user-edit"></i></i> LogOut</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row mt-5">
            <div class="col-md-12">    
                <div class="card m-3">
                    <div class="card-body">
                        <div class="table-responsive">
                        <h2 class="text-center mb-4" style="color: black;">Histori Booking Anda</h2>
                            <table class="table table-striped tabel-hover table-bordered table-sm">
                                <thead>
                                    <tr>
                                    <th><i>ID Sewa</i></th>
                                        <th><i>Mobil</i></th>
                                        <th><i>No Polisi</i></th>
                                        <th><i>Tanggal Sewa</i></th>
                                        <th><i>Tanggal Kembali</i></th>
                                        <th><i>Lama Sewa (Hari)</i></th>
                                        <th><i>Total Harga</i></th>
                                        <th><i>Status Pembayaran</i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($booking_history) > 0): ?>
                                        <?php foreach ($booking_history as $booking): ?>
                                            <tr>
                                                <td><i><?php echo htmlspecialchars($booking['id_sewa']); ?></i></td>
                                                <td><i><?php echo htmlspecialchars($booking['merk']); ?></i></td>
                                                <td><i><?php echo htmlspecialchars($booking['no_polisi']); ?></i></td>
                                                <td><i><?php echo htmlspecialchars($booking['tgl_sewa']); ?></i></td>
                                                <td><i><?php echo htmlspecialchars($booking['tgl_kembali']); ?></i></td>
                                                <td><i><?php echo htmlspecialchars($booking['lama']); ?></i></td>
                                                <td><i>Rp. <?php echo number_format($booking['harga_total'], 0, ',', '.'); ?></i></td>
                                                <td><i><?php echo htmlspecialchars($booking['konf_pembayaran']); ?></i></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center">Tidak ada histori booking.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>  
    <!-- Footer -->
  <footer class="bg-primary">
    <div class="container text-center">
      <p>&copy; 2024 Lucky Rent Car. All Rights Reserved.</p>
      <div>
        <a href="https://www.facebook.com/luki.asluki?mibextid=ZbWKwL" class="mx-2"><i class="fab fa-facebook-f"></i></a>
        <a href="#" class="mx-2"><i class="fab fa-twitter"></i></a>
        <a href="#" class="mx-2"><i class="fab fa-instagram"></i></a>
        <a href="#" class="mx-2"><i class="fab fa-linkedin-in"></i></a>
      </div>
    </div>
  </footer>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="path/to/your/script.js" defer></script>    
</body>
</html>
