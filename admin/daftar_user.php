<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style>
        h3{
            color: #000;
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
                        <h3>Daftar User</h3>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th scope="col">No.</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Foto</th>
                                            <th scope="col">No HP</th>
                                            <th scope="col">Email</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        include("../db/koneksi.php");
                                        $cari=mysqli_query($konek,"select * from users") or die (mysqli_error($konek));
                                    
                                            $no = 1;
                                            while($data=mysqli_fetch_array($cari)) {
                                        ?>
                                        <tr>
                                            <th scope="row"><?php echo $no; ?></th>
                                            <td><?php echo $data['nama_lengkap']; ?></td>
                                            <td>
                                            <?php if (!empty($data['foto'])): ?>
                                                <a href="#" data-toggle="modal" data-target="#buktiModal">
        <img src="../user/uploads/<?php echo $data['foto']; ?>" alt="Foto User" class="card-img-top" style="width: 100px;">
    <?php else: ?> </a>
        <img src="img/default.jpg" alt="Tidak ada foto" class="card-img-top" style="width: 100px;">
    <?php endif; ?>
                                            </td>
                                            <td><?php echo $data['nomor_hp']; ?></td>
                                            <td><?php echo $data['email']; ?></td>
                                            <td>
                                                <a href="?x=huser&id=<?php echo $data['id_user']; ?>" class="btn btn-danger" title="Hapus"><i class="fas fa-trash-alt"></i></a>
                                                <a href="?x=euser&id=<?php echo $data['id_user']; ?>" class="btn btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
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