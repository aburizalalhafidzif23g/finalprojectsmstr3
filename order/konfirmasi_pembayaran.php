<?php
include("../db/koneksi.php"); // Pastikan ini mengarah ke file koneksi yang benar
session_start();

// Memeriksa apakah ID booking ada di URL
if (!isset($_GET['id'])) {
    die("ID booking tidak ditemukan. Parameter URL: " . htmlspecialchars($_SERVER['QUERY_STRING']));
}

$id_sewa = $_GET['id']; // Ambil ID sewa dari URL

// Mengambil data booking berdasarkan ID
$sql = "SELECT * FROM sewa WHERE id_sewa = ?";
$stmt = $konek->prepare($sql);
$stmt->bind_param("i", $id_sewa);
$stmt->execute();
$result = $stmt->get_result();

// Memeriksa apakah booking ditemukan
if ($result->num_rows == 0) {
    die("Booking tidak ditemukan.");
}

$hasil = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Lucky Rent Car</title>
    <link rel="icon" type="image/png" href="../img/icon_rent.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/cyborg/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        body {
            background-color: white;
            /* Mengatur latar belakang halaman menjadi putih */
        }

        .card {
            background-color: white;
            /* Mengatur latar belakang card menjadi putih */
            border: 1px solid #ddd;
            /* Menambahkan border pada card */
        }

        .text-with-border {
            border-bottom: 1px solid #ccc;
            /* Menambahkan garis di bawah teks */
            padding: 5px 0;
            /* Menambahkan padding vertikal */
        }

        p {
            color: #000;
        }
        i {
            color: #000;
        }
        
    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <a class="navbar-brand" href="#"><i class="fa-solid fa-car"></i> Lucky Rent Car</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../user/dashboard_user.php"><i class="fas fa-home"></i>Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"><i class="fas fa-user"></i><?php echo $_SESSION['username']; ?></a>
                </li>
            </ul>
        </div>
    </nav>
    <br>
    <br>
    
    <div class="container py-5">
        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                <div class="card border" style="background-color:rgb(11, 4, 3);">
                        <div class="card-header bg-white text-black">
                            <h5 class="card-title" style="color:#000">Pembayaran Dapat Melalui :</h5>
                            <hr />
                            <p>BRI A/N LUKI ASLUKI 1234567</p>
                            <p>BCA A/N LUKI ASLUKI7654321</p>
                            <p>MANDIRI A/N LUKI ASLUKI 1324657</p>
                            <p>DANA A/N LUKI ASLUKI 085456337678</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="card border" style="background-color: #DCDCDC;">
                    <div class="card-body"> 
                        <div class="card-header bg-primary text-center" style="color: white">
                        <h2>Konfirmasi Pembayaran</h2>
                        </div>
                        <form method="post" action="proses_konfir.php?id=<?php echo $id_sewa;?>" enctype="multipart/form-data">
                        <table class="table" style="color: #000;">
                                <tr>
                                    <td>Kode Booking</td>
                                    <td>:</td>
                                    <td><?php echo $hasil['id_sewa']; ?></td>
                                </tr>
                                <tr>
                                    <td>No Rekening</td>
                                    <td>:</td>
                                    <td><input type="text" name="no_rek" required class="form-control"></td>
                                </tr>
                                <tr>
                                    <td>Atas Nama</td>
                                    <td>:</td>
                                    <td><input type="text" name="nama" required class="form-control"></td>
                                </tr>
                                <tr>
                                    <td>Nominal</td>
                                    <td>:</td>
                                    <td><input type="text" name="total_harga" required class="form-control"></td>
                                </tr>
                                <tr>
                                    <td>Tanggal Transfer</td>
                                    <td>:</td>
                                    <td><input type="date" name="tanggal_pembayaran" required class="form-control"></td>
                                </tr>
                                <tr>
                                    <td><label>Total yang Harus Dibayar</label></td>
                                    <td>:</td>
                                    <td>Rp. <?php echo number_format($hasil['harga_total']); ?></td>
                                </tr>
                                <tr>
                                    <td><label for="payment_method" style="color:#000">Metode Pembayaran </label></td>
                                    <td>:</td>
                                    <td>
                                        <select name="metode_pembayaran" id="metode_pembayaran" required>
                                            <option value="">--Pilih Metode Pembayaran--</option>
                                            <option value="transfer">Transfer BRI</option>
                                            <option value="transfer">Transfer BCA</option>
                                            <option value="transfer">Transfer MANDIRI</option>
                                            <option value="transfer">Transfer DANA</option>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Bukti Pembayaran</td>
                                    <td>:</td>
                                    <td><input type="file" name="bukti_pembayaran" required class="form-control-file" accept="image/*"></td>
                                </tr>
                            </table>
                            <button type="submit" name="submit" class="btn btn-primary float-right">Kirim</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="bg-primary text-white text-center py-3">
        <p>&copy; 2024 Lucky Rent Car. All Rights Reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>