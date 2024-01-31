<?php
require_once('koneksi.php');

session_start();

$dapil = $_POST['dapil'];
$sql = mysqli_query($conn,"SELECT kecamatan FROM db_master_dapil where dapil like '%$dapil%'");


while($row = mysqli_fetch_assoc($sql)) {
    echo "<option value='".strtoupper($row['kecamatan'])."'>".strtoupper($row['kecamatan'])."</option>";
}

?>