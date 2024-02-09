<?php

session_start();

require_once('koneksi.php');

require_once('validasi-batch.php');

$KecamatanSession = strtoupper($_SESSION['kecamatan_session']);
$Status = validasi_batch($conn, $KecamatanSession);
if ($Status == "0") {
    $_SESSION['nomor_ktp'] = '';
    $_SESSION['pesanError'] = "Anda Belum Diperbolehkan Mengkases Pengisian Form!";
    header('location: input-ktp.php');
    exit;
}

$NomorKTP = $_SESSION['nomor_ktp'];
$KategoriCapil = $_SESSION['kc'];

$sql = mysqli_query($conn, "SELECT nama FROM db_ptps WHERE no_ktp = '$NomorKTP'");
$row = mysqli_fetch_assoc($sql);
$Nama = $row['nama'];

?>

<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="#" class="logo d-flex align-items-center">
            <span class="d-none d-lg-block">Form Rekapitulasi <?= $KategoriCapil ?></span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="form-main.php">
                    <span class="d-none d-md-block ps-2" style="font-weight: bold;font-size: 20px;">
                        <span class="badge rounded-pill text-bg-warning">INPUTOR</span> : <?= $Nama ?> | <img src="assets/img/bawaslu/home-page.png" style="width: 20px;" />
                    </span>
                </a>

            </li>

        </ul>
    </nav>

</header>