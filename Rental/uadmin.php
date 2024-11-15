<?php
include("koneksi.php");
$kode = $_POST['kode'];
$nama = $_POST['textNama'];
$kelamin = $_POST['kelamin'];
$username = $_POST['textUsername'];
$password = $_POST['textPassword'];
$level = $_POST['level'];
$simpan = mysqli_query($konek, "update admin set nama_admin='$nama', jenkel_admin='$kelamin',
username='$username', password='$password', level='$level' where id_admin='$kode' ") or die (mysqli_error());
if($simpan){
    header("Location:index.php?x=admin");
}