<?php

function validasi_batch($conn, $Kecamatan) {

    $sql = mysqli_query($conn, "SELECT status FROM db_batch_kecamatan WHERE kecamatan = '$Kecamatan'");
    $row = mysqli_fetch_assoc($sql);
    $Status = $row['status'];

    return $Status;

    mysqli_close($conn);
}
