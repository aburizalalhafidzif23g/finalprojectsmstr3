<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    </style>
</head>
<body>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">    
                <div class="card m-3">
                    <div class="card-body">
                        <h3>Laporan Order Mobil</h3>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>No Polisi</th>
                                        <th>Merk</th>
                                        <th>Nama Peminjam</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Tujuan</th>
                                        <th>Tgl Mulai Order</th>
                                        <th>Tgl Selesai Order</th>
                                        <th>Lama Sewa</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include("../db/koneksi.php");
                                    $cari = mysqli_query($konek, "SELECT * FROM mobil, sewa WHERE mobil.id_mobil = sewa.id_mobil") or die(mysqli_error($konek));
                                    
                                    $no = 1;
                                    while ($data = mysqli_fetch_array($cari)) {
                                        ?>
                                        <tr>
                                            <th scope="row"><?php echo $no; ?></th>
                                            <td><?php echo $data['no_polisi']; ?></td>
                                            <td><?php echo $data['merk']; ?></td>
                                            <td><?php echo $data['nama_sewa']; ?></td>
                                            <td><?php echo $data['alamat']; ?></td>
                                            <td><?php echo $data['tujuan']; ?></td>
                                            <td><?php echo $data['tgl_sewa']; ?></td>
                                            <td><?php echo $data['tgl_kembali']; ?></td>
                                            <td><?php echo $data['lama']; ?></td>
                                            <td><?php echo $data['harga_total']; ?></td>
                                        </tr>
                                        <?php
                                        $no++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <a href="crorder.php" class="btn btn-primary">Cetak</a>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</body>
</html>