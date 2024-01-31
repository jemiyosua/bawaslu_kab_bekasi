<?php

require_once('koneksi.php');

session_start();

if (isset($_POST['update-ptps'])) {

    $Id = $_POST['vID'];
    $Kecamatan = $_POST['vKecamatan'];
    $Kelurahan = $_POST['vKelurahan'];
    $NomorTPS = $_POST['vNoTPS'];
    $NomorKTP = $_POST['vNoKTP'];
    $Nama = $_POST['vNama'];
    $Dapil = substr($_POST['vDapil'], strlen($_POST['vDapil'])-1);

    $sql = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_ptps WHERE no_tps = $NomorTPS");
    $row = mysqli_fetch_assoc($sql);
    $CountTPS = $row["cnt"];

    if ($CountTPS > 0) {
        $_SESSION['pesanError'] = "Sudah ada PTPS untuk TPS No. !" . $NomorTPS;
        header('location: master-ptps.php');
    } else {
        $sql2 = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_ptps WHERE no_ktp = '$NomorKTP' AND no_tps = '$NomorTPS' AND UPPER(nama) = UPPER('$Nama') AND UPPER(kecamatan) = UPPER('$Kecamatan') AND UPPER(kelurahan) = UPPER('$Kelurahan') AND dapil_kab = '$Dapil' AND id <> '$Id'");
        $row2 = mysqli_fetch_assoc($sql2);
        $CountData = $row2["cnt"];
        if ($CountTPS > 0) {
            $_SESSION['pesanError'] = "Terdapat Data yang Sama!";
            header('location: master-ptps.php');
        } else {
            $sql = mysqli_query($conn, "UPDATE db_ptps SET no_ktp = '$NomorKTP', no_tps = $NomorTPS, nama = UPPER('$Nama'), kecamatan = UPPER('$Kecamatan'), kelurahan = UPPER('$Kelurahan'), dapil_kab = '$Dapil' WHERE id = '$Id'");
            header('location: master-ptps.php');
        }
    }
} else if (isset($_GET['delete-ptps'])) {
    $IdDelete = $_GET['deleteID'];

    $query = "DELETE FROM db_ptps WHERE id = '$IdDelete'";
    

    if (!$results = mysqli_query($conn, $query)) {
        $_SESSION['pesanError'] = "Terjadi Kesalahan Saat Menghapus Data!";
        header('location: master-ptps.php');
    } else {
        $_SESSION['pesan'] = "Data Berhasil Dihapu!";
        header('location: master-ptps.php');
    }

} 

