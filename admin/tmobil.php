<!doctype html>
<html lang="en">
<head>
    <style>
        label {
            color: black;
        }
        h5 {
            color: black;
        }
    </style>
    <script>
        function updateFileName() {
            const fileInput = document.getElementById('foto');
            const fileNameDisplay = document.getElementById('file-name');
            // Ambil nama file
            const fileName = fileInput.files[0] ? fileInput.files[0].name : 'Tidak ada file yang dipilih';
            // Tampilkan nama file
            fileNameDisplay.textContent = fileName;
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">    
                <div class="card m-3">
                    <div class="card-body">
                        <table class="table table-striped">
                            <div class="card">
                                <h5 class="card-header">Tambah Data Mobil</h5>
                                <div class="card-body">
                                    <form method="post" action="?x=smobil" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label>No Polisi</label>
                                            <input type="text" class="form-control" name="textPolisi">
                                        </div>
                                        <div class="form-group">
                                            <label>Merk Mobil</label>
                                            <input type="text" class="form-control" name="textMerk">
                                        </div>
                                        <div class="form-group">
                                            <label>Tahun Keluaran</label>
                                            <input type="text" class="form-control" name="textTahun">
                                        </div>
                                        <div class="form-group">
                                            <label>Harga</label>
                                            <input type="text" class="form-control" name="textHarga">
                                        </div>
                                        <div class="form-grup">
                                            <label>Status</label>
                                            <input type="text" class="form-control" name="s_mobil">
                                        </div>
                                        <div class="form-group">
                                            <label>Foto</label>
                                            <input type="file" id="foto" name="foto" class="form-control-file" accept="image/*" onchange="updateFileName()">
                                            <small id="file-name" class="form-text text-muted">Tidak ada file yang dipilih</small>
                                        </div>
                                        <div class="form-group">
                                            <label>Deskripsi</label>
                                            <textarea class="form-control" name="textDeskripsi"></textarea>
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