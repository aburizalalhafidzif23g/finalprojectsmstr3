<?php
include("../db/koneksi.php");
$id=$_GET['id'];
$hapus=mysqli_query($konek,"delete from sewa where id_sewa='$id'") or die (mysqli_error($konek));
if($hapus){
    header("Location:dashbord_admin.php?x=order");
}