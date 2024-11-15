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
    }
} else {
    echo "<h3>Halaman Dalam Proses Pembangunan! </h3>";
}