<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style>
        h3 {
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
                            <?php
                            if ($_SESSION['level'] == "SUPER") {
                                include("../db/koneksi.php");
                                $cari = mysqli_query($konek, "select * from admin") or die(mysqli_error($konek));
                            ?>
                                <h3 class="text-center">Data Admin</h3>
                                <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th scope="col">No.</th>
                                            <th scope="col">Nama Admin</th>
                                            <th scope="col">Jenis Kelamin</th>
                                            <th scope="col">Level</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        while ($data = mysqli_fetch_array($cari)) {
                                        ?>
                                            <tr>
                                                <th scope="row"><?php echo $no; ?></th>
                                                <td><?php echo $data['nama_admin']; ?></td>
                                                <td><?php echo $data['jenkel_admin']; ?></td>
                                                <td><?php echo $data['level']; ?></td>
                                                <td>
                                                    <a href="?x=hadmin&id=<?php echo $data['id_admin']; ?>" class="btn btn-danger" title="Hapus">
                                                    <i class="fas fa-trash-alt"></i></a>
                                                    <a href="?x=eadmin&id=<?php echo $data['id_admin']; ?>" class="btn btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i></a>
                                                </td>
                                            </tr>
                                        <?php
                                            $no++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <a href="?x=tadmin" class="btn btn-primary">Tambah</a>
                            <?php
                            } else { ?>
                                <script type="text/JavaScript">
                                    alert("level ADMIN tidak boleh masuk!");
                                window.location="dashbord_admin.php?x=badmin"
                            </script>
                            <?php

                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>