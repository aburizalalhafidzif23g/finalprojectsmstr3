<?php
include("../../db/koneksi.php");
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

// Mengambil data pembayaran
$pembayaran_sql = "SELECT * FROM pembayaran WHERE id_sewa = ?";
$pembayaran_stmt = $konek->prepare($pembayaran_sql);
$pembayaran_stmt->bind_param("i", $id_sewa);
$pembayaran_stmt->execute();
$pembayaran_result = $pembayaran_stmt->get_result();
$pembayaran_data = $pembayaran_result->fetch_assoc();

/// Proses perubahan status pembayaran
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Cek apakah status ada dalam POST
    if (isset($_POST['status'])) {
        $status = $_POST['status'];

        // Update status pembayaran di database
        $update_sql = "UPDATE sewa SET konf_pembayaran = ? WHERE id_sewa = ?";
        $update_stmt = $konek->prepare($update_sql);
        $update_stmt->bind_param("si", $status, $id_sewa);
        
        if ($update_stmt->execute()) {
            // Redirect atau tampilkan pesan sukses
            header("Location: bayar.php?id_sewa=" . $id_sewa);
            exit();
        } else {
            echo "Error updating record: " . $mysqli_connect_error;
        }
    } else {
        echo "Status pembayaran tidak ditemukan.";
    }
}

// Proses perubahan status mobil
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['status_mobil'])) {
    $status_mobil = $_POST['status_mobil'];

    // Update status mobil di database
    $update_mobil_sql = "UPDATE mobil SET s_mobil = ? WHERE id_mobil = ?";
    $update_mobil_stmt = $konek->prepare($update_mobil_sql);
    $update_mobil_stmt->bind_param("si", $status_mobil, $row['id_mobil']);
    
    if ($update_mobil_stmt->execute()) {
        // Redirect atau tampilkan pesan sukses
        header("Location: bayar.php?id_sewa=" . $id_sewa);
        exit();
    } else {
        echo "Error updating mobil status: " . $mysqli_connect_error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Lucky Rent Car</title>
    <link rel="icon" type="image/png" href="../../img/icon_rent.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/cyborg/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        body {
            background-color: white;
        }

        .card {
            background-color: white;
            border: 1px solid #ddd;
        }

        .text-with-border {
            border-bottom: 1px solid #ccc;
            padding: 5px 0;
        }

        p {
            color: #000;
        }
        i {
            color: #000;
        }
        .text-black {
        color: black;
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <a class="navbar-brand" href="#"><i class="fa-solid fa-car"></i> Lucky Rent Car</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../dashbord_admin.php?x=badmin"><i class="fas fa-home"></i>Home</a>
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
                            <?php if ($pembayaran_data): ?>
                                <table class="table">
                                    <tr>
                                        <td class="text-black">No Rekening</td>
                                        <td class="text-black"> :</td>
                                        <td class="text-black"><?= $pembayaran_data['no_rek']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-black">Atas Nama</td>
                                        <td class="text-black"> :</td>
                                        <td class="text-black"><?= $pembayaran_data['nama']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-black">Nominal</td>
                                        <td class="text-black"> :</td>
                                        <td class="text-black" >Rp. <?= number_format($pembayaran_data['total_harga']); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-black">Tgl Transfer</td>
                                        <td class="text-black"> :</td>
                                        <td class="text-black"><?= $pembayaran_data['tanggal_pembayaran']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-black">Bukti Pembayaran</td>
                                        <td> :</td>
                                        <td>
                                            <?php if (!empty($pembayaran_data['bukti_pembayaran'])): ?>
                                                <a href="#" data-toggle="modal" data-target="#buktiModal">
                                                    <img src="../../uploads/<?= htmlspecialchars($pembayaran_data['bukti_pembayaran']); ?>" alt="Bukti Pembayaran" style="width: 100px; height: auto; cursor: pointer;">
                                                </a>
                                            <?php else: ?>
                                                <p>Tidak ada bukti pembayaran yang diunggah.</p>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </table>
                            <?php else: ?>
                                <h4>Belum dibayar</h4>
                            <?php endif; ?>
                        </div>
                    </div>
                    <br />
                    <div class="card">
                        <div class="card" style="background:#ddd">
                            <h5 class="card-title text-center" style="color: black"><?php echo $row['merk']; ?></h5>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-dark text-white">
                                <p class="card-text" style="color: black"><strong>No Polisi:</strong> <?php echo $row['no_polisi']; ?></p>
                            </li>
                            <li class="list-group-item bg-dark text-white">
                                <p class="card-text" style="color: black"><strong>Harga Sewa:</strong> Rp. <?php echo number_format($row['harga'], 0, ',', '.'); ?> / hari</p>
                            </li>
                            <li class="list-group-item bg-dark text-white">
                                <p class="card-text" style="color: black">
                                    <strong>Status:</strong> 
                                <tr>
                                    <td>Status Mobil</td>
                                    <td> :</td>
                                    <td>
                                        <form method="POST" action="">
                                            <select class="form-control" name="status_mobil">
                                                <option value="AKTIF" <?php if($row['s_mobil'] == 'AKTIF'){echo 'selected';}?>>
                                                    AKTIF
                                                </option>
                                                <option value="TIDAK AKTIF" <?php if($row['s_mobil'] == 'TIDAK AKTIF'){echo 'selected';}?>>
                                                    TIDAK AKTIF
                                                </option>
                                            </select>   
                                            <button type="submit" class="btn btn-primary float-right mt-2">Ubah Status Mobil</button>
                                        </form>
                                    </td>
                                </tr>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="card border" style="background-color: #DCDCDC;">
                    <div class="card-body">
                        <div class="card-header bg-primary text-center" style="color:#000">
                            <h2>Detail Pemesanan</h2>
                        </div>
                        <table class="table" style="color: #000;">
                            <tr>
                                <td>ID SEWA</td>
                                <td> :</td>
                                <td><?php echo $row['id_sewa']; ?></td>
                            </tr>
                            <tr>
                                <td>KTP</td>
                                <td> :</td>
                                <td><?php echo $row['ktp']; ?></td>
                            </tr>
                            <tr>
                                <td>Nama</td>
                                <td> :</td>
                                <td><?php echo $row['nama_sewa']; ?></td>
                            </tr>
                            <tr>
                                <td>Telepon</td>
                                <td> :</td>
                                <td><?php echo $row['tlp_sewa']; ?></td>
                            </tr>
                            <tr>
                                <td>Tanggal Sewa</td>
                                <td> :</td>
                                <td><?php echo $row['tgl_sewa']; ?></td>
                            </tr>
                            <tr>
                                <td>Tanggal Selesai</td>
                                <td> :</td>
                                <td><?php echo $row['tgl_kembali']; ?></td>
                            </tr>
                            <tr>
                                <td>Lama Sewa</td>
                                <td> :</td>
                                <td><?php echo $row['lama']; ?></td>
                            </tr>
                            <tr>
                                <td>Total Harga</td>
                                <td> :</td>
                                <td>Rp. <?php echo number_format($row['harga_total'], 0, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td> :</td>
                                <td>
                                    <form method="POST" action="">
                                        <select class="form-control" name="status">
                                            <option value="Sedang di proses" <?php if($row['konf_pembayaran'] == 'Sedang di proses'){echo 'selected';}?>>
                                                Sedang di proses
                                            </option>
                                            <option value="Pembayaran diterima" <?php if($row['konf_pembayaran'] == 'Pembayaran diterima'){echo 'selected';}?>>
                                                Pembayaran diterima
                                            </option>
                                        </select>   
                                        <button type="submit" class="btn btn-primary float-right mt-2">Ubah Status Pembayaran</button>
                                    </form>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="buktiModal" tabindex="-1" role="dialog" aria-labelledby="buktiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="buktiModalLabel">Bukti Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <?php if (!empty($pembayaran_data['bukti_pembayaran'])): ?>
                        <img src="../../uploads/<?= htmlspecialchars($pembayaran_data['bukti_pembayaran']); ?>" alt="Bukti Pembayaran" style="max-width: 100%; height: auto;">
                        <br><br>
                        <a href="../../uploads/<?= htmlspecialchars($pembayaran_data['bukti_pembayaran']); ?>" download class="btn btn-primary">
                            <i class="fas fa-download"></i> Unduh Gambar
                        </a>
                    <?php else: ?>
                        <p>Bukti pembayaran tidak ditemukan.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>



    <footer class="bg-primary text-white text-center py-3">
        <p>&copy; 2024 Lucky Rent Car. All Rights Reserved.</p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
   <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

<?php
$stmt->close();
$pembayaran_stmt->close();
$konek->close();
?>