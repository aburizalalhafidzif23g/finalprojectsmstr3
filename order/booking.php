<?php
include("../db/koneksi.php"); // Menggunakan koneksi database Anda
session_start();

// Memastikan ID mobil tersedia
if (!isset($_GET['id_mobil'])) {
    die("ID mobil tidak ditemukan.");
}

// Definisi Class Kendaraan dan Mobil
class Kendaraan {
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getKendaraanById($id, $table, $idColumn) {
        $sql = "SELECT * FROM $table WHERE $idColumn = ?";
        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            die("Error prepare statement: " . $this->db->error);
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            return null; // Data tidak ditemukan
        }

        return $result->fetch_assoc();
    }
}

class Mobil extends Kendaraan {
    public function getMobilById($id_mobil) {
        return $this->getKendaraanById($id_mobil, "mobil", "id_mobil");
    }
}


// Buat instance class Mobil
$mobilDb = new Mobil($konek);

// Ambil data mobil berdasarkan ID
$id_mobil = $_GET['id_mobil'];
$row = $mobilDb->getMobilById($id_mobil);

// Memeriksa apakah data mobil ditemukan
if (!$row) {
    die("Mobil tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lucky Rent Car</title>

    <!-- Bootstrap -->
    <link rel="icon" type="image/png" href="../img/icon_rent.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/cyborg/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../asset/style-indexu.css">
    <style>
        .search-bar {
            float: right;
            margin-right: 20px;
        }

        .search-bar input[type="text"] {
            padding: 5px;
            font-size: 14px;
        }

        .search-bar button {
            padding: 5px 10px;
            font-size: 14px;
            background-color: #28a745;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .content {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: px;
            flex-wrap: wrap;
        }

        .car-image,
        .car-info {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            margin: 10px;
        }

        .car-image img {
            max-width: 100%;
            border-radius: px;
        }

        .car-details {
            margin-top: 20px;
        }

        .car-details h2 {
            margin: 0;
            font-size: 24px;
        }

        .car-details p {
            margin: 5px 0;
            font-size: 16px;
        }

        .status {
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            color: #fff;
            font-size: 16px;
        }

        .status.not-available {
            background-color: #dc3545;
        }

        .status.available {
            background-color: #17a2b8;
        }

        .status.price {
            background-color: #343a40;
        }

        .buttons {
            margin-top: 20px;
        }

        .buttons button {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-right: 10px;
        }

        .buttons .booking {
            background-color: #28a745;
            color: #fff;
        }

        .buttons .back {
            background-color: #17a2b8;
            color: #fff;
        }

        .footer {
            background-color: #343a40;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        @media (max-width: 768px) {
            .content {
                flex-direction: column;
            }

            .search-bar,
            .user-info {
                float: none;
                text-align: center;
                margin: 10px 0;
            }
        }
    </style>

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
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
    <div class="row justify-content-center">
        <!-- Informasi Mobil -->
        <div class="col-md-6">
            <div class="card" style="background-color: #DCDCDC">
                <img src="<?php echo (!empty($row['poto'])) ? "../uploads/" . $row['poto'] : "../img/default-car.jpg"; ?>" 
                     class="card-img-top" 
                     alt="Foto Mobil" 
                     style="height: 300px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title text-center" style="color: black"><?php echo $row['merk']; ?></h5>
                    <p class="card-text" style="color: black"><strong>No Polisi:</strong> <?php echo $row['no_polisi']; ?></p>
                    <p class="card-text" style="color: black"><strong>Tahun Keluar:</strong> <?php echo $row['tahun']; ?></p>
                    <p class="card-text" style="color: black"><strong>Harga Sewa:</strong> Rp. <?php echo number_format($row['harga'], 0, ',', '.'); ?> / hari</p>
                    <p class="card-text" style="color: black"><strong>Deskripsi:</strong> <?php echo $row['deskripsi']; ?></p>
                    <p class="card-text" style="color: black">
                        <strong>Status:</strong> 
                        <span class="badge <?php echo $row['s_mobil'] === 'AKTIF' ? 'badge-success' : 'badge-danger'; ?>">
                            <?php echo $row['s_mobil']; ?>
                        </span>
                    </p>
                    <a href="javascript:history.back()" class="btn btn-secondary btn-block btn-sm">Kembali</a>
                </div>
            </div>
        </div>
        <br>

        <!-- Formulir Booking -->
        <div class="col-md-6">
            <div class="card border" style="background-color: #DCDCDC;">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Formulir Pemesanan</h5>
                </div>
                <div class="card-body">
                <form method="post" action="porder.php">
                    <div class="form-group">
                        <label for="ktp">KTP / NIK</label>
                        <input type="text" name="ktp" id="ktp" required class="form-control" placeholder="Masukkan KTP / NIK Anda">
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" id="nama" required class="form-control" placeholder="Masukkan Nama Anda">
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="jenkel" class="form-control" required>
                            <option value="">--Pilih--</option>
                            <option value="Laki-Laki">Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>  
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" name="alamat" id="alamat" required class="form-control" placeholder="Masukkan Alamat Anda">
                    </div>
                    <div class="form-group">
                        <label for="telepon">Telepon</label>
                        <input type="text" name="no_tlp" id="telepon" required class="form-control" placeholder="Masukkan No. Telepon Anda">
                    </div>
                    <div class="form-group">
                        <label>Tujuan</label>
                        <input type="text" class="form-control" name="textTujuan" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Pinjam</label>
                        <input type="date" class="form-control" name="textMulai" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Selesai</label>
                        <input type="date" class="form-control" name="textSelesai" required>
                    </div>
                
                    
                    <!-- Hidden Inputs -->
                    <input type="hidden" name="id_mobil" value="<?php echo $row['id_mobil']; ?>">
                    <input type="hidden" name="total_harga" value="<?php echo $row['harga']; ?>">
                    
                    <button type="submit" class="btn btn-primary">Booking</button>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>

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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const fadeInElements = document.querySelectorAll('.fade-in');

            function checkVisibility() {
                fadeInElements.forEach(element => {
                    const rect = element.getBoundingClientRect();
                    if (rect.top < window.innerHeight && rect.bottom > 0) {
                        element.classList.add('visible');
                    }
                });
            }

            // Cek visibilitas saat halaman di-scroll
            window.addEventListener('scroll', checkVisibility);
            // Cek visibilitas saat halaman dimuat
            checkVisibility();

            // Tambahkan event listener untuk link "Cars"
            const carsLink = document.querySelector('a[href="#mobil"]');
            carsLink.addEventListener('click', function(event) {
                event.preventDefault(); // Mencegah perilaku default
                document.getElementById('mobil').scrollIntoView({
                    behavior: 'smooth'
                }); // Scroll ke bagian mobil

                // Tambahkan kelas visible ke semua elemen fade-in
                fadeInElements.forEach(element => {
                    element.classList.add('visible');
                });
            });
        });
        document.addEventListener("DOMContentLoaded", function() {
            // Mendapatkan tanggal hari ini dalam format YYYY-MM-DD
            const today = new Date().toISOString().split('T')[0];

            // Ambil elemen input tanggal mulai dan selesai
            const tanggalMulaiInput = document.querySelector('input[name="textMulai"]');
            const tanggalSelesaiInput = document.querySelector('input[name="textSelesai"]');

        // Set tanggal minimal untuk input tanggal mulai ke hari ini
        if (tanggalMulaiInput) {
            tanggalMulaiInput.setAttribute('min', today);
        }

        // Tambahkan event listener untuk validasi tanggal selesai
        if (tanggalMulaiInput && tanggalSelesaiInput) {
            tanggalMulaiInput.addEventListener('change', function() {
                const tanggalMulai = tanggalMulaiInput.value;

                // Set tanggal minimal selesai ke tanggal mulai
                tanggalSelesaiInput.setAttribute('min', tanggalMulai);

                // Validasi jika tanggal selesai lebih kecil dari tanggal mulai
                if (tanggalSelesaiInput.value && tanggalSelesaiInput.value < tanggalMulai) {
                    alert('Tanggal selesai tidak boleh lebih kecil dari tanggal mulai.');
                    tanggalSelesaiInput.value = ''; // Reset input tanggal selesai
                }
            });

                // Validasi tambahan untuk tanggal selesai
                tanggalSelesaiInput.addEventListener('change', function() {
                    const tanggalMulai = tanggalMulaiInput.value;
                    const tanggalSelesai = tanggalSelesaiInput.value;

                if (tanggalSelesai < tanggalMulai) {
                    alert('Tanggal selesai tidak boleh lebih kecil dari tanggal mulai.');
                    tanggalSelesaiInput.value = ''; // Reset input tanggal selesai
                }
            });
        }
    });
    </script>
</body>

</html>

<?php

$konek->close();
?>