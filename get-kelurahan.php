<?php

require_once('koneksi.php');

$Kecamatan = $_GET['kecamatan'];
$pilKelurahan = $_GET['kelurahan'];

// echo "kecamatan : " . $Kecamatan;

$Dropdown = "";
$Dropdownlist = "";
$isSelected = "";
// ------ set selected kelurahan for update --------
// if($pilKelurahan  != ""el){
//     $Dropdownlist .= "<option value='$pilKelurahan' selected hidden>$pilKelurahan</option>";
// }

// ------ get data kelurahan ------
$sql = mysqli_query($conn, "SELECT kelurahan FROM db_ptps WHERE upper(kecamatan) = '$Kecamatan' GROUP BY kelurahan");
while ($row = mysqli_fetch_assoc($sql)) {
    $Kelurahan = strtoupper($row['kelurahan']);
    if($pilKelurahan  == $Kelurahan){
        $isSelected = "selected";
    } else {
        $isSelected = "";
    }
    $Dropdownlist .= "<option value='$Kelurahan' $isSelected>$Kelurahan</option>";
}

// ------ get data dapil ------
$sql = mysqli_query($conn, "SELECT dapil FROM db_master_dapil WHERE upper(kecamatan) = '$Kecamatan'");
$row = mysqli_fetch_assoc($sql);
$Dapil = $row['dapil'];

$DapilSplit = explode(" ", $Dapil);
$DapilNumber = $DapilSplit[1];

echo "<label class='form-label'>Daerah Pilihan (Pilihan Bekasi)</label>";
echo "<input type='text' name='dapil' class='form-control' readonly value=".$DapilNumber."></input>";
echo "//";
echo "<label class='form-label'>Kelurahan</label><select class='form-select' name='kelurahan' id='kelurahan' onchange=\"return clearNoTPS()\" required>" . $Dropdownlist . "</select>";