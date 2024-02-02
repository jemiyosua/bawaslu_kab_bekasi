<?php

require_once('koneksi.php');

$NomorKTP = $_GET['nomor_ktp'];
$queryID = '';
if (isset($_GET['id'])) {
    $Id = $_GET['id'];
    $queryID = "AND id <> '" . $Id . "' ";
}


$query = "SELECT COUNT(1) AS cnt FROM db_ptps WHERE no_ktp = '$NomorKTP' " .$queryID;
$sql = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($sql);
$CountKTP = $row['cnt'];

if ($CountKTP > 0) {
    echo "1";
} else {
    echo "0";
}