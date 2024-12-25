<?php
include("../db/koneksi.php");
$nama = $_POST['textNama'];
$nohp = $_POST['textNo_hp'];
$email = $_POST['textEmail'];
$simpan = mysqli_query($konek,"insert into users(nama_lengkap,nomor_hp,email)
values ('$nama','$nohp','$email)") or die (mysqli_error($konek));
if($simpan){
    header("Location:dashbord_admin.php?x=user");
}