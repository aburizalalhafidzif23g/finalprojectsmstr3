<?php
include("koneksi.php");
$nama = $_POST['textNama'];
$kelamin = $_POST['kelamin'];
$username = $_POST['textUsername'];
$password = $_POST['textPassword'];
$level = $_POST['level'];
$simpan = mysqli_query($konek,"insert into admin(nama_admin,jenkel_admin,username,password,level)
values ('$nama','$kelamin','$username','$password','$level')") or die (mysqli_error());
if($simpan){
    header("Location:index.php?x=admin");
}