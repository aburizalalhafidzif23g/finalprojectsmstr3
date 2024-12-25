<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                    <h3>Laporan Data Mobil</h3>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Polisi</th>
                                        <th>Merk</th>
                                        <th>Tahun</th>
                                        <th>Harga/Hari</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    include("../db/koneksi.php");
                                    $cari=mysqli_query($konek,"select * from mobil") or die (mysqli_error($konek));

                                    $no = 1;
                                    while($data=mysqli_fetch_array($cari)) {
                                        ?>
                                        <tr>
                                            <th scope="row"><?php echo $no; ?></th>
                                            <td><?php echo $data['no_polisi']; ?></td>
                                            <td><?php echo $data['merk']; ?></td>
                                            <td><?php echo $data['tahun']; ?></td>
                                            <td><?php echo $data['harga']; ?></td>
                                        </tr>
                                        <?php
                                        $no++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <a href="crmobil.php" class="btn btn-primary">Cetak</a>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</body>
</html>