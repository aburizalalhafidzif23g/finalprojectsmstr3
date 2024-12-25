<?php
include("../db/koneksi.php");
$id=$_GET['id'];
$hapus=mysqli_query($konek,"delete from mobil where id_mobil='$id'");
if($hapus){
    header("Location:dashbord_admin.php?x=mobil");
    exit();
}