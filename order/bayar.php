<?php
include("../db/koneksi.php");
session_start();

if (!isset($_GET['id_sewa'])) {
    die("ID sewa tidak ditemukan.");
}

$id_sewa = $_GET['id_sewa'];




// Mengambil data sewa dan mobil
$sql = "SELECT s.*, m.merk, m.harga, m.no_polisi, m.s_mobil FROM sewa s JOIN mobil m ON s.id_mobil = m.id_mobil WHERE s.id_sewa = ?";
$stmt = $konek->prepare($sql);
$stmt->bind_param("i", $id_sewa);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Data sewa tidak ditemukan.");
}

$row = $result->fetch_assoc();
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary ">
        <a class="navbar-brand" href="#"><i class="fa-solid fa-car"></i> Lucky Rent Car</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
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
                    <br />
                    <div class="card">
                        <div class="card-body" style="background:#ddd">
                            <h5 class="card-title text-center" style="color: black"><?php echo $row['merk']; ?></h5>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-dark text-white">

                                <p class="card-text" style="color: black"><strong>No Polisi:</strong> <?php echo $row['no_polisi']; ?></p>
                            <li class="list-group-item bg-dark text-white">
                                <p class="card-text" style="color: black"><strong>Harga Sewa:</strong> Rp. <?php echo number_format($row['harga'], 0, ',', '.'); ?> / hari</p>
                            </li>
                            <li class="list-group-item bg-dark text-white">
                            <p class="card-text" style="color: black">
                                <strong>Status:</strong> 
                                <span class="badge <?php echo $row['s_mobil'] === 'AKTIF' ? 'badge-success' : 'badge-danger'; ?>">
                                    <?php echo $row['s_mobil']; ?>
                                </span>
                            </p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="card border" style="background-color: #DCDCDC;">
                    <div class="card-body">
                        <div class="card-header bg-primary text-center" style="color: white">
                            <h2>Detail Pemesanan</h2>
                        </div>
                        <table class="table" style="color: #000;">
                            <tr>
                                <td>ID SEWA </td>
                                <td> :</td>
                                <td><?php echo $row['id_sewa']; ?></td>
                            </tr>
                            <tr>
                                <td>KTP </td>
                                <td> :</td>
                                <td><?php echo $row['ktp']; ?></td>
                            </tr>
                            <tr>
                                <td>Nama </td>
                                <td> :</td>
                                <td><?php echo $row['nama_sewa']; ?></td>
                            </tr>
                            <tr>
                                <td>telepon </td>
                                <td> :</td>
                                <td><?php echo $row['tlp_sewa']; ?></td>
                            </tr>
                            <tr>
                                <td>Tanggal Sewa </td>
                                <td> :</td>
                                <td><?php echo $row['tgl_sewa']; ?></td>
                            </tr>
                            <tr>
                                <td>Tanggal Selesai </td>
                                <td> :</td>
                                <td><?php echo $row['tgl_kembali']; ?></td>
                            </tr>
                            <tr>
                                <td>Lama Sewa </td>
                                <td> :</td>
                                <td><?php echo $row['lama']; ?></td>
                            </tr>
                            <tr>
                                <td>Total Harga </td>

                                <td> :</td>
                                <td>Rp. <?php echo number_format($row['harga_total'], 0, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <td>Status </td>
                                <td> :</td>
                                <td><?php echo $row['konf_pembayaran']; ?></td>
                            </tr>
                            
                        </table>
                        <?php if($row['konf_pembayaran'] == 'Belum Bayar'){?>
                        <a href="konfirmasi_pembayaran.php?id=<?php echo $id_sewa;?>" 
                        class="btn btn-primary float-right">Konfirmasi Pembayaran</a>
                    <?php }?>
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

<?php
$stmt->close();
$konek->close();
?>