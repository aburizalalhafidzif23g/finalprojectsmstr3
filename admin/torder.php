<!doctype html>
<html lang="en">
  <head>
  <style>
        label{
            color: black;
        }
        h5{
            color: black;
        }
    </style>
   

  </head>
  <body>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">    
                <div class="card m-3">
                    <div class="card-body">
                        <table class="table table-striped">  
                            <div class="card">
                                <h5 class="card-header">Tambah Data Order</h5>
                                <div class="card-body">
                                <?php
                                        include("../db/koneksi.php");
                                        $cari=mysqli_query($konek,"select * from mobil");
                                        ?>
                                    <form method="post" action="?x=sorder">
                                        <div class="form-group">
                                            <label>No polisi</label>
                                            <select name="polisi" class="form-control">
                                                <option value="">--Pilih--</option>
                                                <?php
                                                while($data = mysqli_fetch_array($cari)){
                                                    ?>
                                                    <option value="<?php echo $data['id_mobil']; ?>"><?php echo $data['no_polisi']." - ".
                                                    $data['merk'];?></option> 
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Nomor KTP</label>
                                            <input type="text" class="form-control" name="textKTP">
                                        </div>
                                        <div class="form-group">
                                            <label>Nama Peminjam</label>
                                            <input type="text" class="form-control" name="textNama">
                                        </div>
                                        <div class="form-group">
                                            <label>Jenis Kelamin</label>
                                            <select name="jenkel" class="form-control">
                                            <option value="">--Pilih--</option>
                                            <option value="Laki-Laki">Laki-Laki</option>
                                            <option value="Perempuan">Perempuan</option>  
                                            
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Alamat Lengkap</label>
                                            <input type="text" class="form-control" name="textAlamat">
                                        </div>
                                        <div class="form-group">
                                            <label>Tlp/HP</label>
                                            <input type="text" class="form-control" name="textTlp">
                                        </div>
                                        <div class="form-group">
                                            <label>tujuan</label>
                                            <input type="text" class="form-control" name="textTujuan">
                                        </div>
                                        <div class="form-group">
                                            <label>Tanggal Pinjam</label>
                                            <input type="date" class="form-control" name="textMulai">
                                        </div>
                                        <div class="form-group">
                                            <label>Tanggal Selesai</label>
                                            <input type="date" class="form-control" name="textSelesai">
                                        </div>
                                        
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </form>
                                </div>
                            </div>
                        </table>
                    </div>
                </div> 
            </div>
        </div>
    </div>   
</body>
</html>