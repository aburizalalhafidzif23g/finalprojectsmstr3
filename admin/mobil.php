<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        h3 {
            color: #000;
            text-align: center;
        }
        .aksi-col {
            width: 100px;
        }
        th {
            text-align: center; 
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">    
                <div class="card m-3">
                    <div class="card-body">
                        <h3>Data Mobil</h3>
                        <a href="?x=tmobil" class="btn btn-primary">Tambah</a>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Polisi</th>
                                        <th>Merk</th>
                                        <th>Tahun</th>
                                        <th>Harga/Hari</th>
                                        <th>Status</th>
                                        <th>Foto</th>
                                        <th>Deskripsi</th>
                                        <th>Waktu</th>
                                        <th class="aksi-col">Aksi</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    include("../db/koneksi.php");
                                    $cari = mysqli_query($konek, "SELECT * FROM mobil") or die(mysqli_error($konek));

                                    $no = 1;
                                    while ($data = mysqli_fetch_array($cari)) {
                                        ?>
                                        <tr>
                                            <th scope="row"><?php echo $no; ?></th>
                                            <td><?php echo $data['no_polisi']; ?></td>
                                            <td><?php echo $data['merk']; ?></td>
                                            <td><?php echo $data['tahun']; ?></td>
                                            <td><?php echo $data['harga']; ?></td>
                                            <td><?php echo $data['s_mobil']; ?></td>
                                            <td>
                                                <?php if (!empty($data['poto'])): ?>
                                                    <img src="<?php echo $data['poto']; ?>" alt="Foto Mobil" style="width: 100px;">
                                                <?php else: ?>
                                                    Tidak ada foto
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo $data['deskripsi']; ?></td>
                                            <td><?php echo $data['created_at']; ?></td>
                                            <td>
                                                <!-- Tombol Aksi dengan Ikon -->
                                                <a href="?x=hmobil&id=<?php echo $data['id_mobil']; ?>" class="btn btn-danger" title="Hapus">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                                <a href="?x=emobil&id=<?php echo $data['id_mobil']; ?>" class="btn btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                        $no++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                         
                    </div>
                </div> 
            </div>
        </div>
    </div>      
</body>
</html>