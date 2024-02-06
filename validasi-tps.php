<?php

require_once('koneksi.php');

$NomorTPS = $_GET['nomor_tps'];
$Kecamatan = $_GET['kecamatan'];
$Kelurahan = $_GET['kelurahan'];

$sql = mysqli_query($conn, "SELECT COUNT(1) AS cnt FROM db_ptps WHERE kecamatan = '$Kecamatan' AND kelurahan = '$Kelurahan' AND no_tps = '$NomorTPS'");
$row = mysqli_fetch_assoc($sql);
$CountTPS = $row['cnt'];

if ($CountTPS > 0) {
    echo "1";
} else {
    echo "0";
}

mysqli_close($conn);