<?php
include("../db/koneksi.php");
$id=$_GET['id'];
$hapus=mysqli_query($konek,"delete from users where id_user='$id'") or die (mysqli_error($konek));
if($hapus){
    header("Location:dashbord_admin.php?x=user");
}