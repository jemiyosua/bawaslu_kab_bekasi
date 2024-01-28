<?php

require_once('header.php');

require_once('koneksi.php');

session_start();

$Kecamatan = '';
$Kelurahan = '';
$NomorTPS = '';
$Nama = '';

if (isset($_SESSION['nomor_ktp'])) {
    $NomorKTP = $_SESSION['nomor_ktp'];

    $sql = mysqli_query($conn, "SELECT status_ppwp, status_dpr_ri, status_dpd_ri, status_dprd_prov, status_dprd_kab, dapil_kab FROM db_ptps WHERE no_ktp = '$NomorKTP'");
    $row = mysqli_fetch_assoc($sql);
    $StatusPPWP = $row["status_ppwp"];
    $StatusDPRRI = $row["status_dpr_ri"];
    $StatusDPDRI = $row["status_dpd_ri"];
    $StatusDPRDProv = $row["status_dprd_prov"];
    $StatusDPRDKab = $row["status_dprd_kab"];
    $DapilKab = $row["dapil_kab"];

    $IconPPWP = "";
    $IconDPRRI = "";
    $IconDPDRI = "";
    $IconDPRDProv = "";
    $IconDPRDKab = "";

    if ($StatusPPWP == "1") {
        $IconPPWP = '<img src="assets/img/bawaslu/done.png" class="card-img-top">';
        $width = "37px";
        $ButtonPPWP = "";
    } else {
        $IconPPWP = '<img src="assets/img/bawaslu/x-mark.png" class="card-img-top">';
        $width = "40px";
        $ButtonPPWP = '<a href="form_ppwp.php" name="btn-ppwp" class="btn btn-secondary"><i class="bi bi-pencil-fill"></i> Isi Form</a>';
    }

    if ($StatusDPRRI == "1") {
        $IconDPRRI = '<img src="assets/img/bawaslu/done.png" class="card-img-top">';
        $width = "37px";
        $ButtonDPRRI = "";
    } else {
        $IconDPRRI = '<img src="assets/img/bawaslu/x-mark.png" class="card-img-top">';
        $width = "40px";
        $ButtonDPRRI = '<a href="form-partai.php?kc=DPR-RI" class="btn btn-warning"><i class="bi bi-pencil-fill"></i> Isi Form</a>';
    }

    if ($StatusDPDRI == "1") {
        $IconDPDRI = '<img src="assets/img/bawaslu/done.png" class="card-img-top">';
        $width = "37px";
        $ButtonDPDRI = "";
    } else {
        $IconDPDRI = '<img src="assets/img/bawaslu/x-mark.png" class="card-img-top">';
        $width = "40px";
        $ButtonDPDRI = '<a href="#" class="btn btn-danger"><i class="bi bi-pencil-fill"></i> Isi Form</a>';
    }

    if ($StatusDPRDProv == "1") {
        $IconDPRDProv = '<img src="assets/img/bawaslu/done.png" class="card-img-top">';
        $width = "37px";
        $ButtonDPRDProv = "";
    } else {
        $IconDPRDProv = '<img src="assets/img/bawaslu/x-mark.png" class="card-img-top">';
        $width = "40px";
        $ButtonDPRDProv = '<a href="#" class="btn btn-primary"><i class="bi bi-pencil-fill"></i> Isi Form</a>';
    }

    if ($StatusDPRDKab == "1") {
        $IconDPRDKab = '<img src="assets/img/bawaslu/done.png" class="card-img-top">';
        $width = "37px";
        $ButtonDPRDKab = "";
    } else {
        $IconDPRDKab = '<img src="assets/img/bawaslu/x-mark.png" class="card-img-top">';
        $width = "40px";
        $ButtonDPRDKab = '<a href="#" class="btn btn-success"><i class="bi bi-pencil-fill"></i> Isi Form</a>';
    }
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
                                            <div style="width:<?= $width ?>">
                                                <?= $IconPPWP ?>
                                            </div>
                                        </div>
                                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                        <?= $ButtonPPWP ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="card-title">DPR - RI</h5>
                                            <div style="width:<?= $width ?>">
                                                <?= $IconDPRRI ?>
                                            </div>
                                        </div>
                                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                        <?= $ButtonDPRRI ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="card-title">DPD - RI</h5>
                                            <div style="width:<?= $width ?>">
                                                <?= $IconDPDRI ?>
                                            </div>
                                        </div>
                                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                        <?= $ButtonDPDRI ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="card-title">DPRD - PROVINSI</h5>
                                            <div style="width:<?= $width ?>">
                                                <?= $IconDPRDProv ?>
                                            </div>
                                        </div>
                                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                        <?= $ButtonDPRDProv ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="card-title">DAPIL BEKASI <?= $DapilKab ?></h5>
                                            <div style="width:<?= $width ?>">
                                                <?= $IconDPRDKab ?>
                                            </div>
                                        </div>
                                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                        <?= $ButtonDPRDKab ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">BACK</h5>
                                        <a href="input-ktp.php" class="btn btn-danger"><i class="bi bi-arrow-left-circle-fill"></i> Back</a>
                                    </div>
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

?>