<?php

require_once('koneksi.php');

$IdImage = $_GET['id'];

$sql = mysqli_query($conn, "SELECT imagebase64 AS dataImage FROM db_master_image WHERE image_id = '$IdImage' GROUP BY dataImage");
$row = mysqli_fetch_assoc($sql);

$ImageBase64 = $row['dataImage'];

?>

<!-- <img src='data:image/png;base64,<?= $ImageBase64 ?>'> -->
<img src='<?= $ImageBase64 ?>'>