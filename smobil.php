<?php
include("koneksi.php");
$nopolisi=$_POST['textPolisi'];
$merk=$_POST['textMerk'];
$tahun=$_POST['textTahun'];
$harga=$_POST['textHarga'];
$simpan=mysqli_query($konek,"insert into mobil(no_polisi,merk,tahun,harga,s_mobil) values('$nopolisi','$merk',
'$tahun','$harga','AKTIF')");
if($simpan){
    header("Location:index.php?x=mobil");
}