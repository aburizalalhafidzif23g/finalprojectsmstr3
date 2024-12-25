<?php
if (isset($_GET['x'])) {
    switch($_GET['x']) {
        case 'keluar':
            include("keluar.php");
            break;
        case 'admin':
            include("admin.php");
            break;
        case 'tadmin' :
            include("tadmin.php");
            break;
        case 'sadmin':
            include("sadmin.php");
            break;
        case 'hadmin':
            include("hadmin.php");
            break;
        case 'eadmin':
            include("eadmin.php");
            break;
        case 'uadmin':
            include("uadmin.php");
            break;
        case 'mobil':
            include("mobil.php");
            break;
        case 'tmobil':
            include("tmobil.php");
            break;
        case 'smobil':
            include("smobil.php");
            break;
        case 'hmobil':
            include("hmobil.php");
            break;
        case 'emobil':
            include("emobil.php");
            break;
        case 'umobil':
            include("umobil.php");
            break;
        case 'order':
            include("order.php");
            break;
        case 'torder':
            include("torder.php");
            break;
        case 'sorder':
            include("sorder.php");
            break;
        case 'horder':
            include("horder.php");
            break;
        case 'rmobil':
            include("rmobil.php");
            break;
        case 'rorder':
            include("rorder.php");
            break;
        case 'badmin':
            include("branda_admin.php");
            break;
        case 'user':
            include("daftar_user.php");
            break;
        case 'huser':
            include("huser.php");
            break;
        case 'euser':
            include("euser.php");
            break;
        case 'suser':
            include("suser.php");
            break;
    }
} else {
    echo "<h3>Halaman Dalam Proses Pembangunan! </h3>";
}