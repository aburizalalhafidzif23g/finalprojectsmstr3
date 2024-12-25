<!doctype html>
<html lang="en">
<head>
</head>
<body>
<div class="container">
    <div class="row mt-5">
        <div class="col-md-12">    
            <div class="card m-3">
                <div class="card-body">
                    <table class="table table-striped">
                        <?php
                        include("../db/koneksi.php");
                        $id = $_GET['id'];
                        $cari = mysqli_query($konek, "SELECT * FROM mobil WHERE id_mobil='$id'");
                        $data = mysqli_fetch_array($cari);
                        ?>
                        <div class="card">
                            <h5 class="card-header">Ubah Data Mobil</h5>
                            <div class="card-body">
                                <form method="post" action="?x=umobil" enctype="multipart/form-data">
                                    <input type="hidden" name="kode" value="<?php echo $data['id_mobil']; ?>">
                                    <div class="form-group">
                                        <label><i>No polisi</i></label>
                                        <input type="text" class="form-control" name="textPolisi" value="<?php echo $data['no_polisi']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label><i>Merk Mobil</i></label>
                                        <input type="text" class="form-control" name="textMerk" value="<?php echo $data['merk']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label><i>Tahun Keluran</i></label>
                                        <input type="text" class="form-control" name="textTahun" value="<?php echo $data['tahun']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label><i>Harga</i></label>
                                        <input type="text" class="form-control" name="textHarga" value="<?php echo $data['harga']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label><i>Status</i></label>
                                        <select class="form-control" name="textS_mobil">
                                            <option value="AKTIF" <?php echo ($data['s_mobil'] == 'AKTIF') ? 'selected' : ''; ?>>AKTIF</option>
                                            <option value="TIDAK AKTIF" <?php echo ($data['s_mobil'] == 'TIDAK AKTIF') ? 'selected' : ''; ?>>TIDAK AKTIF</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label><i>Foto</i></label>
                                        <input type="file" class="form-control-file" name="foto" accept="image/*">
                                        <?php if (!empty($data['poto'])): ?>
                                            <img src="<?php echo $data['poto']; ?>" alt="Foto Mobil" style="width: 100px; height: auto; margin-top: 10px;">
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label><i>Deskripsi</i></label>
                                        <textarea class="form-control" name="textDeskripsi"><?php echo $data['deskripsi']; ?></textarea>
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