<?php
include "../db/koneksi.php";
$polisi = $_POST['polisi'];
$nama = $_POST['textNama'];
$jenkel = $_POST['jenkel'];
$ktp = $_POST['textKTP'];
$alamat = $_POST['textAlamat'];
$tlp = $_POST['textTlp'];
$tujuan = $_POST['textTujuan'];
$mulai = new DateTime($_POST['textMulai']);
$selesai = new DateTime($_POST['textSelesai']);
$selisih = $selesai->diff($mulai);
$x = $selisih->d;
$cari = mysqli_query($konek, "select * from mobil where id_mobil='$polisi'");
$data = mysqli_fetch_array($cari);
$harga = $x * $data['harga'];
$kode_booking = "BK" .random_int(10,99).date("dmyHis");
$simpan = mysqli_query($konek, "insert into sewa(id_mobil,id_admin,nama_sewa,ktp,jenkel_sewa,alamat,tlp_sewa,tujuan,tgl_sewa,tgl_kembali,lama,harga_total) values ('$polisi','$_SESSION[id_admin]','$nama','$ktp','$jenkel','$alamat','$tlp','$tujuan','$_POST[textMulai]','$_POST[textSelesai]','$x','$harga','$kode_booking')") or die(mysqli_error($konek));
if ($simpan) {
    header("Location:dashbord_admin.php?x=order");
}
