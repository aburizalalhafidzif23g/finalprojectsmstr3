<?php
// koneksi.php
$host = "localhost"; // Ganti dengan host database Anda
$user = "root"; // Ganti dengan username database Anda
$password = "Aburizalif23g#"; // Ganti dengan password database Anda
$dbname = "rental3"; // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($host, $user, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengambil data jumlah kendaraan yang disewa (s_mobil = 1)
$sql = "SELECT COUNT(*) as total_sewa FROM mobil WHERE s_mobil = 'TIDAK AKTIF'";
$result = $conn->query($sql);
$total_sewa = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_sewa = $row['total_sewa'];
}

// Mengambil data jumlah kendaraan total
$sql = "SELECT COUNT(*) as total_mobil FROM mobil";
$result = $conn->query($sql);
$total_mobil = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_mobil = $row['total_mobil'];
}

// Menghitung kendaraan yang tersedia (s_mobil = 0)
$kendaraan_tersedia = $total_mobil - $total_sewa;

$conn->close();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <title>Dashboard Admin</title>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .welcome {
            margin-top: 20px;
            text-align: center;
        }

        .chart-container {
            position: relative;
            height: 40vh;
            width: 100%;
        }

        @media (max-width: 768px) {
            .content {
                margin-left: 0;
                padding: 20px;
            }
        }
    </style>
</head>

<body>

    <!-- Main Content -->
    <div class="content" style="padding: 80px;">
        <div class="welcome">
            <h1>Selamat Datang <?php echo $_SESSION['username'] ?? 'Admin'; ?></h1>
            <p>Berikut adalah ringkasan penjualan dan statistik kendaraan.</p>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Persentase Kendaraan</h5>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="salesChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Statistik Kendaraan</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Keterangan</th>
                                            <th>Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Total Kendaraan</td>
                                            <td><?php echo $total_mobil; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Kendaraan Tersedia</td>
                                            <td><?php echo $kendaraan_tersedia; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Kendaraan Disewa</td>
                                            <td><?php echo $total_sewa; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data untuk grafik
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Kendaraan Tersedia', 'Kendaraan Disewa'],
                datasets: [{
                    label: 'Jumlah Kendaraan',
                    data: [<?php echo $kendaraan_tersedia; ?>, <?php echo $total_sewa; ?>],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(255, 99, 132, 0.2)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Grafik Kendaraan Tersedia vs Disewa'
                    }
                }
            }
        });
    </script>
</body>

</html>
