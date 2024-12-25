<?php
ob_start();
include("../db/koneksi.php");
session_start();

class Auth {
    public static function checkSession() {
        if (!isset($_SESSION['username'])) {
            header("Location: dashboard_user.php");
            exit();
        }
    }
}

class mobil {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function getActiveCars() {
        $sql = "SELECT * FROM mobil WHERE s_mobil = 'AKTIF'";
        $result = mysqli_query($this->db, $sql);
        return $result;
    }

}

// Cek session
Auth::checkSession();

$mobilManager = new mobil($konek);
$activeCars = $mobilManager->getActiveCars();

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

  <!-- Bootstrap -->
  <link rel="icon" type="image/png" href="../img/icon_rent.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/cyborg/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../asset/style-indexu.css">

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
                <a class="nav-link" href="#home">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#about">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#mobil">Cars</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#contact">Contact</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="riwayat.php">history</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../index.php"><i class="fas fa-user-edit"></i></i> LogOut</a>
            </li>
        </ul>
    </div>
</nav>

  <!-- Home Section -->
  <section id="home" class="banner-section" style="background: url('../img/foto.a.png') center/cover no-repeat; padding-top: 50px;">
    <div class="container py-5">
      <div style="height: 100px;"></div>
      <div class="div_zindex">
        <div class="row">
          <div class="col-md-5 col-md-push-7">
            <div class="banner_content">
              <h1 style="font-family: 'Lobster', cursive; font-size: 70px; color: dark; font-weight: bold; margin-top: -50px;">
                Selamat Datang <span style="color:rgb(255, 196, 0);"><?php echo $_SESSION['username']; ?>!</span> </h1>
              <p class="lead" style="color: white;">Partner penyewaan mobil terpercaya untuk semua kebutuhan Anda.</p>
              <a href="#mobil" class="btn btn-primary btn-lg">Lihat Mobil yang Tersedia</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
  </section>

  <!-- About Section -->
  <div id="about" class="container my-5">
    <div style="height: 50px;"></div>
    <h2 class="text-center mb-4" style="font-family: 'Lobster', cursive; color: #007bff;">About Us</h2>
    <p class="text-center" style="font-size: 18px; line-height: 1.6; color: #333;">
      Lucky Rent Car adalah perusahaan penyewaan mobil terpercaya yang didirikan dengan misi untuk memberikan solusi
      transportasi terbaik bagi pelanggan. Kami menyediakan berbagai jenis kendaraan yang sesuai dengan kebutuhan
      pribadi, bisnis, dan liburan Anda.
    </p>
    <p class="text-center" style="font-size: 18px; line-height: 1.6; color: #333;">
      Dengan pengalaman bertahun-tahun di industri ini, kami berkomitmen untuk memberikan layanan berkualitas tinggi
      yang mengutamakan kenyamanan, keamanan, dan kepuasan pelanggan. Semua kendaraan kami dirawat secara berkala untuk
      memastikan performa maksimal di setiap perjalanan Anda.
    </p>
  </div>
  
  <!-- Vision and Mission Section -->
  <div class="container py-5">
    <h2 class="text-center mb-4" style="font-family: 'Lobster', cursive; color: #007bff;">Visi dan Misi</h2>
    <h5 class="text-center" style="color: #333;"><strong>Visi</strong></h5>
    <p class="text-center" style="font-size: 18px; line-height: 1.6; color: #333;">
      Menjadi perusahaan penyewaan mobil terdepan yang dikenal atas kualitas layanan dan inovasi.
    </p>
    <h5 class="text-center mt-4" style="color: #333;"><strong>Misi</strong></h5>
    <ul class="text-center list-unstyled" style="color: #333;">
      <li style="font-size: 18px; line-height: 1.6;"><i class="fas fa-check-circle" style="color: #007bff;"></i> Memberikan pengalaman penyewaan kendaraan yang mudah dan efisien.</li>
      <li style="font-size: 18px; line-height: 1.6;"><i class="fas fa-check-circle" style="color: #007bff;"></i> Menyediakan kendaraan berkualitas tinggi dengan perawatan terbaik.</li>
      <li style="font-size: 18px; line-height: 1.6;"><i class="fas fa-check-circle" style="color: #007bff;"></i> Menjadikan kepuasan pelanggan sebagai prioritas utama dalam setiap layanan yang kami tawarkan.</li>
    </ul>
  </div>

  <!-- Our Advantages Section -->
  <div id="advantages" class="container my-5" style="background-color: #e6f7ff;">
    <h2 class="text-center mb-4" style="font-family: 'Lobster', cursive; color: #007bff;">Keunggulan Kami</h2>
    <div class="row">
      <div class="col-md-4 text-center">
        <i class="fas fa-car fa-3x mb-3" style="color: #007bff;"></i>
        <h5 style="color: #333;">Pilihan Kendaraan Lengkap</h5>
        <p style="color: #333;">Kami menyediakan kendaraan yang dapat memenuhi berbagai kebutuhan transportasi Anda.</p>
      </div>
      <div class="col-md-4 text-center">
        <i class="fas fa-tags fa-3x mb-3" style="color: #007bff;"></i>
        <h5 style="color: #333;">Harga Kompetitif</h5>
        <p style="color: #333;">Kami menawarkan tarif yang transparan dan terjangkau tanpa biaya tersembunyi, sehingga Anda dapat merencanakan perjalanan dengan mudah.</p>
      </div>
      <div class="col-md-4 text-center">
        <i class="fas fa-user-friends fa-3x mb-3" style="color: #007bff;"></i>
        <h5 style="color: #333;">Pelayanan Ramah dan Profesional</h5>
        <p style="color: #333;">Tim kami siap membantu Anda dalam memilih kendaraan terbaik sesuai kebutuhan, serta memberikan dukungan penuh selama masa sewa.</p>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-md-6 text-center">
        <i class="fas fa-clock fa-3x mb-3" style="color: #007bff;"></i>
        <h5 style="color: #333;">Fleksibilitas Waktu</h5>
        <p style="color: #333;">Kami menyediakan opsi penyewaan harian, mingguan, hingga bulanan yang dapat disesuaikan dengan kebutuhan Anda.</p>
      </div>
      <div class="col-md-6 text-center">
        <i class="fas fa-shield-alt fa-3x mb-3" style="color: #007bff;"></i>
        <h5 style="color: #333;">Keamanan Terjamin</h5>
        <p style="color: #333;">Semua kendaraan kami dilengkapi dengan asuransi, sehingga Anda dapat merasa tenang dan fokus menikmati perjalanan.</p>
      </div>
    </div>
  </div>

  <!-- Cars Section -->
  <div id="mobil" class="my-5" style="background-color: #e6f7ff;">
    <div class="container py-5">
      <h2 class="text-center mb-4" style="color: black;">Mobil yang Tersedia</h2>
      <div class="row">
        <?php
        if ($activeCars->num_rows > 0) {
          while ($row = $activeCars->fetch_assoc()) {
        ?>
            <div class="col-md-4">
              <div class="card mb-4">
                <?php if (!empty($row['poto'])): ?>
                  <img src="../uploads/<?php echo $row['poto']; ?>" alt="Foto Mobil" class="card-img-top" style="height: 200px; object-fit: cover;">
                <?php else: ?>
                  <img src="../img/default-car.jpg" alt="Tidak ada foto" class="card-img-top" style="height: 200px; object-fit: cover;">
                <?php endif; ?>
                <div class="card-body">
                  <h5 class="card-title"><?php echo $row['merk']; ?></h5>
                  <p class="card-text"><strong>Harga Sewa:</strong> <?php echo $row['harga']; ?></p>
                  <a href="../order/booking.php?id_mobil=<?php echo $row['id_mobil']; ?>" class="btn btn-primary">Booking</a>
                  <a href="../order/detail_mobil.php?id_mobil=<?php echo $row['id_mobil']; ?>" class="btn btn-primary">Detail</a>
                  <a class="btn btn-primary"><strong>Status:</strong> <?php echo $row['s_mobil']; ?></a>
                </div>
              </div>
            </div>
        <?php
          }
        } else {
          echo "<div class='col-12'><div class='alert alert-warning text-center'>Tidak ada mobil tersedia</div></div>";
        }
        ?>
      </div>
    </div>
  </div>
  
  <!-- Contact Section -->
  <section id="contact" class="container my-5">
    <div class="row">
      <div class="col-md-6">
        <h3>Ada Pertanyaan?</h3>
        <h3>Silahkan Isi Form Berikut</h3>
        <div class="card" style="background-color: #d3d3d3; border-radius: 0;"> <!-- Card berwarna abu-abu dengan sudut kotak -->
          <div class="card-body">
            <form id="contactForm">
              <div class="form-group">
                <label>Full Name <span>*</span></label>
                <input type="text" name="fullname" class="form-control" required>
              </div>
              <div class="form-group">
                <label>Email Address <span>*</span></label>
                <input type="email" name="email" class="form-control" required>
              </div>
              <div class="form-group">
                <label>Phone Number <span>*</span></label>
                <input type="text" name="contactno" class="form-control" required>
              </div>
              <div class="form-group">
                <label>Message <span>*</span></label>
                <textarea name="message" rows="4" class="form-control" required></textarea>
              </div>
              <button type="button" class="btn btn-primary" onclick="sendMessage()">Send Message</button>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <h3>Info Kontak</h3>
        <div class="container py-5">
          <p><i class="fas fa-map-marker-alt"></i> Duren, Kec. Klari, Karawang, Jawa Barat 41371</p>
          <div class="embed-responsive embed-responsive-16by9 mb-3">
            <iframe class="embed-responsive-item"
              src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15861.257726235359!2d107.3735266!3d-6.353325400000001!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e697706d0895829%3A0x89c07829d9199d9f!2sRENTAL%20MOBIL%20KOSAMBI%20KARAWANG%20L2TRANS!5e0!3m2!1sid!2sid!4v1732626091554!5m2!1sid!2sid"
              width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
              referrerpolicy="no-referrer-when-downgrade">
            </iframe>
          </div>
          <p><i class="fas fa-envelope"></i> rentalmobil@gmail.com</p>
          <p><i class="fas fa-phone"></i> 08585233222</p>
        </div>
      </div>
  </section>
  <script>
    function sendMessage() {
      const form = document.getElementById('contactForm');
      const fullname = form.fullname.value.trim();
      const email = form.email.value.trim();
      const contactno = form.contactno.value.trim();
      const message = form.message.value.trim();

      // Validasi input
      if (!fullname || !email || !contactno || !message) {
          alert("Semua bidang wajib diisi sebelum mengirim pesan.");
          return;
      }

      const whatsappNumber = '+6281280822481'; // Nomor WhatsApp tujuan (tanpa 0, gunakan kode negara)
      const whatsappUrl = `https://wa.me/${whatsappNumber}?text=` +
        encodeURIComponent(
          `Halo, saya ${fullname}.\n` +
          `Email: ${email}\n` +
          `Nomor Telepon: ${contactno}\n` +
          `Pesan: ${message}`
        );

      window.open(whatsappUrl, '_blank');
    }
  </script>


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
  <script>
    document.addEventListener("DOMContentLoaded", function() {
        const links = document.querySelectorAll('.navbar-nav .nav-link');

        links.forEach(link => {
            link.addEventListener('click', function(e) {
                const targetId = this.getAttribute('href'); // Ambil ID target dari href

                // Cek apakah target adalah ID yang valid (dimulai dengan #)
                if (targetId.startsWith('#')) {
                    e.preventDefault(); // Mencegah perilaku default hanya untuk ID target
                    const targetElement = document.querySelector(targetId); // Temukan elemen target

                    if (targetElement) {
                        targetElement.scrollIntoView({ behavior: 'smooth' }); // Scroll ke elemen target
                    }
                }
                // Jika bukan ID target, biarkan tautan berfungsi seperti biasa
            });
        });
    });
    
  </script>
</body>

</html>