<?php

require_once('header.php');

require_once('koneksi.php');

include 'validasi-batch.php';

session_start();

if (!isset($_SESSION['nomor_ktp'])) {

    header('location:input-ktp.php');
}

$KecamatanSession = strtoupper($_SESSION['kecamatan_session']);
$Status = validasi_batch($conn, $KecamatanSession);
if ($Status == "0") {
    $_SESSION['nomor_ktp'] = '';
    $_SESSION['pesanError'] = "Anda Belum Diperbolehkan Mengkases Pengisian Form!";
    header('location: input-ktp.php');
    exit;
}

$Kecamatan = '';
$Kelurahan = '';
$NomorTPS = '';
$Nama = '';

if (isset($_SESSION['nomor_ktp'])) {
    $NomorKTP = $_SESSION['nomor_ktp'];

    // query get dapil kab
    $sql = mysqli_query($conn, "SELECT dapil_kab FROM db_ptps WHERE no_ktp = '$NomorKTP'");
    $row = mysqli_fetch_assoc($sql);
    $DapilKab = $row["dapil_kab"];

    $IconPPWP = "";
    $IconDPRRI = "";
    $IconDPDRI = "";
    $IconDPRDProv = "";
    $IconDPRDKab = "";

    $width = "";
    $ButtonPPWP = "";

    // $CountPPWP = get_count_rekap_hdr($NomorKTP, "PPWP");
    $sql = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_hasil_rekap_hdr WHERE no_ktp = '$NomorKTP' AND kategori_capil = 'PPWP'");
    $row = mysqli_fetch_assoc($sql);
    $CountPPWP = $row["cnt"];

    if ($CountPPWP > 0) {
        $AlertPPWP = '<span class="badge rounded-pill text-bg-success">Completed</span>';
        $IconPPWP = '<img src="assets/img/bawaslu/done.png" class="card-img-top">';
        $width = "37px";
        $ButtonPPWP = '<a href="form-ppwp.php?kc=PPWP" class="btn btn-secondary"><i class="bi bi-pencil-fill"></i> Isi Form</a>';
    } else {
        $AlertPPWP = '<span class="badge rounded-pill text-bg-danger">Belum Diisi</span>';
        $IconPPWP = '<img src="assets/img/bawaslu/x-mark.png" class="card-img-top">';
        $width = "40px";
        $ButtonPPWP = '<a href="form-ppwp.php?kc=PPWP" class="btn btn-secondary"><i class="bi bi-pencil-fill"></i> Isi Form</a>';
    }

    // query get count DPR-RI form
    $sql = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_master_capil WHERE kategori_capil = 'DPR-RI'");
    $row = mysqli_fetch_assoc($sql);
    $CountDPRRIMaster = $row["cnt"];

    $sql2 = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_hasil_rekap_hdr WHERE no_ktp = '$NomorKTP' AND kategori_capil = 'DPR-RI'");
    $row2 = mysqli_fetch_assoc($sql2);
    $CountDPRRI = $row2["cnt"];

    if ($CountDPRRI == $CountDPRRIMaster) {
        $AlertDPRRI = '<span class="badge rounded-pill text-bg-success">Completed</span>';
        $IconDPRRI = '<img src="assets/img/bawaslu/done.png" class="card-img-top">';
        $width = "37px";
        $ButtonDPRRI = '<a href="form-partai.php?kc=DPR-RI" class="btn btn-warning"><i class="bi bi-pencil-fill"></i> Isi Form</a>';
    } else {
        $AlertDPRRI = '<span class="badge rounded-pill text-bg-danger">Belum Diisi</span>';
        $IconDPRRI = '<img src="assets/img/bawaslu/x-mark.png" class="card-img-top">';
        $width = "40px";
        $ButtonDPRRI = '<a href="form-partai.php?kc=DPR-RI" class="btn btn-warning"><i class="bi bi-pencil-fill"></i> Isi Form</a>';
    }

    // query get count DPD-RI form
    $sql = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_master_capil WHERE kategori_capil = 'DPD-RI'");
    $row = mysqli_fetch_assoc($sql);
    $CountDPDRIMaster = $row["cnt"];

    $sql2 = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_hasil_rekap_hdr WHERE no_ktp = '$NomorKTP' AND kategori_capil = 'DPD'");
    $row2 = mysqli_fetch_assoc($sql2);
    $CountDPDRI = $row2["cnt"];

    if ($CountDPDRI == $CountDPDRIMaster) {
        $AlertDPDRI = '<span class="badge rounded-pill text-bg-success">Completed</span>';
        $IconDPDRI = '<img src="assets/img/bawaslu/done.png" class="card-img-top">';
        $width = "37px";
        $ButtonDPDRI = '<a href="form-partai.php?kc=DPD-RI" class="btn btn-danger"><i class="bi bi-pencil-fill"></i> Isi Form</a>';
    } else {
        $AlertDPDRI = '<span class="badge rounded-pill text-bg-danger">Belum Diisi</span>';
        $IconDPDRI = '<img src="assets/img/bawaslu/x-mark.png" class="card-img-top">';
        $width = "40px";
        $ButtonDPDRI = '<a href="form-partai.php?kc=DPD-RI" class="btn btn-danger"><i class="bi bi-pencil-fill"></i> Isi Form</a>';
    }

    // query get count DPRD-PROV form
    $sql = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_master_capil WHERE kategori_capil = 'DPRD-PROV'");
    $row = mysqli_fetch_assoc($sql);
    $CountDPRDProvMaster = $row["cnt"];

    $sql2 = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_hasil_rekap_hdr WHERE no_ktp = '$NomorKTP' AND kategori_capil = 'DPRD-PROV'");
    $row2 = mysqli_fetch_assoc($sql2);
    $CountDPRDProv = $row2["cnt"];

    if ($CountDPRDProv == $CountDPRDProvMaster) {
        $AlertDPRDProv = '<span class="badge rounded-pill text-bg-success">Completed</span>';
        $IconDPRDProv = '<img src="assets/img/bawaslu/done.png" class="card-img-top">';
        $width = "37px";
        $ButtonDPRDProv = '<a href="form-partai.php?kc=DPRD-PROV" class="btn btn-primary"><i class="bi bi-pencil-fill"></i> Isi Form</a>';
    } else {
        $AlertDPRDProv = '<span class="badge rounded-pill text-bg-danger">Belum Diisi</span>';
        $IconDPRDProv = '<img src="assets/img/bawaslu/x-mark.png" class="card-img-top">';
        $width = "40px";
        $ButtonDPRDProv = '<a href="form-partai.php?kc=DPRD-PROV" class="btn btn-primary"><i class="bi bi-pencil-fill"></i> Isi Form</a>';
    }

    // query get count DPRD-KAB form
    $Dapil = "BEKASI " . $DapilKab;
    $sql = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_master_capil WHERE kategori_capil = 'DPRD-KAB' AND dapil = '$Dapil' ");
    $row = mysqli_fetch_assoc($sql);
    $CountDPRDKabMaster = $row["cnt"];

    $sql2 = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_hasil_rekap_hdr WHERE no_ktp = '$NomorKTP' AND kategori_capil = 'DPRD-KAB'");
    $row2 = mysqli_fetch_assoc($sql2);
    $CountDPRDKab = $row2["cnt"];

    if ($CountDPRDKab == $CountDPRDKabMaster) {
        $AlertDPRDKab = '<span class="badge rounded-pill text-bg-success">Completed</span>';
        $IconDPRDKab = '<img src="assets/img/bawaslu/done.png" class="card-img-top">';
        $width = "37px";
        $ButtonDPRDKab = '<a href="form-partai.php?kc=DPRD-KAB&dapil='.$Dapil.'" class="btn btn-success"><i class="bi bi-pencil-fill"></i> Isi Form</a>';
    } else {
        $AlertDPRDKab = '<span class="badge rounded-pill text-bg-danger">Belum Diisi</span>';
        $IconDPRDKab = '<img src="assets/img/bawaslu/x-mark.png" class="card-img-top">';
        $width = "40px";
        $ButtonDPRDKab = '<a href="form-partai.php?kc=DPRD-KAB&dapil='.$Dapil.'" class="btn btn-success"><i class="bi bi-pencil-fill"></i> Isi Form</a>';
    }

    // if ($StatusDPRDKab == "1") {
    //     $IconDPRDKab = '<img src="assets/img/bawaslu/done.png" class="card-img-top">';
    //     $width = "37px";
    //     $ButtonDPRDKab = "";
    // } else {
    //     $IconDPRDKab = '<img src="assets/img/bawaslu/x-mark.png" class="card-img-top">';
    //     $width = "40px";
    //     $ButtonDPRDKab = '<a href="#" class="btn btn-success"><i class="bi bi-pencil-fill"></i> Isi Form</a>';
    // }
}

?>

<main>
    <div class="container">
        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12 col-md-12 d-flex flex-column align-items-center justify-content-center">

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="card-title">PPWP</h5>
                                            <div>
                                                <?= $AlertPPWP ?>
                                            </div>
                                        </div>
                                        <hr/>
                                        <!-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
                                        <?= $ButtonPPWP ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="card-title">DPR - RI</h5>
                                            <div>
                                                <?= $AlertDPRRI ?>
                                            </div>
                                        </div>
                                        <hr/>
                                        <!-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
                                        <?= $ButtonDPRRI ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="card-title">DPD - RI</h5>
                                            <div>
                                                <?= $AlertDPDRI ?>
                                            </div>
                                        </div>
                                        <hr/>
                                        <!-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
                                        <?= $ButtonDPDRI ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="card-title">DPRD - PROVINSI</h5>
                                            <div>
                                                <?= $AlertDPRDProv ?>
                                            </div>
                                        </div>
                                        <hr/>
                                        <!-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
                                        <?= $ButtonDPRDProv ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="card-title">DAPIL BEKASI <?= $DapilKab ?></h5>
                                            <div>
                                                <?= $AlertDPRDKab ?>
                                            </div>
                                        </div>
                                        <hr/>
                                        <!-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
                                        <?= $ButtonDPRDKab ?>
                                    </div>
                                </div>
                            </div>

                            <!-- <a href="input-ktp.php" class="btn btn-danger"><i class="bi bi-arrow-left-circle-fill"></i> Back</a> -->

                            <div class="col-sm-4">
                                <div class="d-flex justify-content align-items-center">
                                    <a href="input-ktp.php" class="btn btn-dark"><i class="bi bi-arrow-left-circle-fill"></i> Back</a>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </section>

    </div>
</main>
<!-- End #main -->

<?php

require_once('footer.php');

mysqli_close($conn);

?>