<?php

require_once('koneksi.php');

$Kecamatan = $_GET['kecamatan'];

$Dropdown = "";
$Dropdownlist = "";

// ------ get data kelurahan ------
$sql = mysqli_query($conn, "SELECT kelurahan FROM db_ptps WHERE kecamatan = '$Kecamatan' GROUP BY kelurahan");
while ($row = mysqli_fetch_assoc($sql)) {
    $Kelurahan = strtoupper($row['kelurahan']);
    $Dropdownlist .= "<option value='$Kelurahan'>$Kelurahan</option>";
}

// ------ get data dapil ------
$sql = mysqli_query($conn, "SELECT dapil FROM db_master_dapil WHERE kecamatan = '$Kecamatan'");
$row = mysqli_fetch_assoc($sql);
$Dapil = $row['dapil'];

$DapilSplit = explode(" ", $Dapil);
$DapilNumber = $DapilSplit[1];

echo "<label class='form-label'>Daerah Pilihan (Pilihan Bekasi)</label>";
echo "<input type='text' name='dapil' class='form-control' readonly value=".$DapilNumber."></input>";
echo "//";
echo "<label class='form-label'>Kelurahan</label><select class='form-select' name='kelurahan' id='kelurahan' required>" . $Dropdownlist . "</select>";