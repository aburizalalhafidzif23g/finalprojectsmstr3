<?php
include("../db/koneksi.php");
$nama = $_POST['textNama'];
$kelamin = $_POST['kelamin'];
$username = $_POST['textUsername'];
$password = $_POST['textPassword'];
$level = $_POST['level'];
$simpan = mysqli_query($konek,"insert into admin(nama_admin,jenkel_admin,username,password,level)
values ('$nama','$kelamin','$username','$password','$level')") or die (mysqli_error($konek));
if($simpan){
    header("Location:dashbord_admin.php?x=admin");
}