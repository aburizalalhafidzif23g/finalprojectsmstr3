<?php
include("../db/koneksi.php"); // Pastikan ini mengarah ke file koneksi yang benar
session_start();

// Memeriksa apakah ada pencarian
$search_query = '';
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
}

// Mengambil data mobil berdasarkan ID atau pencarian
if (!empty($search_query)) {
    $sql = "SELECT * FROM mobil WHERE merk LIKE ?"; // Menggunakan LIKE untuk pencarian
    $stmt = $konek->prepare($sql);
    $search_param = "%" . $search_query . "%"; // Menambahkan wildcard untuk pencarian
    $stmt->bind_param("s", $search_param);
} else {
    // Memeriksa apakah ID mobil ada di URL
    if (!isset($_GET['id_mobil'])) {
        die("ID mobil tidak ditemukan.");
    }

    $id_mobil = $_GET['id_mobil'];

    // Mengambil data mobil berdasarkan ID
    $sql = "SELECT * FROM mobil WHERE id_mobil = ?";
    $stmt = $konek->prepare($sql);
    $stmt->bind_param("i", $id_mobil);
}

// Eksekusi query
$stmt->execute();
$result = $stmt->get_result();

// Memeriksa apakah mobil ditemukan
if ($result->num_rows == 0) {
    die("Mobil tidak ditemukan.");
}

// Mengambil data hasil pencarian
$cars = [];
while ($car = $result->fetch_assoc()) {
    $cars[] = $car; // Menyimpan semua hasil pencarian ke dalam array
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
    <link rel="stylesheet" href="../asset/style-dm.css">
    

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
                <div class="search-bar">
                    <form method="GET" action="">
                        <input placeholder="Cari Nama Mobil" type="text" name="search" value="<?php echo htmlspecialchars($search_query); ?>" />
                        <button type="submit">Search</button>
                    </form>
                </div>
            </ul>
        </div>
    </nav>
    

    <div class="container py-5">
        <div class="container py-5">
            <?php if (!empty($search_query)): ?>
                <h1 class="text-center">Hasil Pencarian untuk "<?php echo htmlspecialchars($search_query); ?>"</h1>
                    <div class="row">
                        <?php foreach ($cars as $car): ?>
                            <div class="col-4">
                                <div class="card mb-4">
                                    <div class="car-image-top">
                                        <?php if (!empty($cars[0]['poto'])): ?>
                                            <img src="../uploads/<?php echo $cars[0]['poto']; ?>" alt="Foto Mobil" class="img-fluid">
                                        <?php else: ?>
                                            <img src="../img/default-car.jpg" alt="Tidak ada foto">
                                        <?php endif; ?>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($car['merk']); ?></h5>
                                        <p class="card-text"><strong>No Polisi:</strong> <?php echo htmlspecialchars($car['no_polisi']); ?></p>
                                        <p class="card-text"><strong>Harga:</strong> Rp. <?php echo number_format($car['harga'], 0, ',', '.'); ?> / hari</p>
                                        <a href="?id_mobil=<?php echo $car['id_mobil']; ?>" class="btn btn-primary">Lihat Detail</a>
                                        <a href="javascript:history.back()" class="btn btn-primary back">Back</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                <div class="content py-5">
                    <div class="car-image py-5">
                        <?php if (!empty($cars[0]['poto'])): ?>
                            <img src="../uploads/<?php echo $cars[0]['poto']; ?>" alt="Foto Mobil" class="img-fluid">
                        <?php else: ?>
                            <img src="../img/default-car.jpg" alt="Tidak ada foto">
                        <?php endif; ?>
                    </div>
                    <div class="car-info">
                        <div class="car-details">
                            <h1 class="text-center"><?php echo htmlspecialchars($cars[0]['merk']); ?></h1>
                            <p><strong>No Polisi:</strong> <?php echo htmlspecialchars($cars[0]['no_polisi']); ?></p>
                            <p><strong>Tahun Keluar:</strong> <?php echo htmlspecialchars($cars[0]['tahun']); ?></p>
                            <p><strong>Harga Sewa:</strong> Rp. <?php echo number_format($cars[0]['harga'], 0, ',', '.'); ?> / hari</p>
                            <p><strong>Deskripsi:</strong> <?php echo htmlspecialchars($cars[0]['deskripsi']); ?></p>
                        </div>
                        <div class="buttons">
                            <a href="../order/booking.php?id_mobil=<?php echo $cars[0]['id_mobil']; ?>" class="btn btn-primary booking">Booking</a>
                            <a href="javascript:history.back()" class="btn btn-primary back">Back</a>
                            <a class="btn btn-primary"><strong>Status:</strong> <?php echo htmlspecialchars($cars[0]['s_mobil']); ?></a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
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
        });
    </script>
</body>
</html>
<?php
$stmt->close();
$konek->close();
?>