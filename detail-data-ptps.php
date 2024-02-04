<?php

session_start();

require_once('header.php');

require_once('koneksi.php');

$Kecamatan = '';
$Kelurahan = '';
$NomorTPS = '';
$Nama = '';

if (isset($_SESSION['nomor_ktp'])) {
    $NomorKTP = $_SESSION['nomor_ktp'];
    $sql = mysqli_query($conn, "SELECT kecamatan, kelurahan, no_tps, nama FROM db_ptps WHERE no_ktp = '$NomorKTP'");
    $row = mysqli_fetch_assoc($sql);
    $Kecamatan = $row["kecamatan"];
    $Kelurahan = $row["kelurahan"];
    $NomorTPS = $row["no_tps"];
    $NomorTPS2 = "";
    if (strlen($NomorTPS) == 2) {
        $NomorTPS2 = "0" . $NomorTPS;
    } else {
        $NomorTPS2 = "00" . $NomorTPS;
    }
    $Nama = $row["nama"];
    $NIKSubString = substr($NomorKTP, 0, 6);
    $NIK = $NIKSubString . "**********";
}

function filterData(&$str) { 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
}

$NavPage = $_SESSION['nav-page'];

?>

<main>
    <div class="container">

        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-6 d-flex flex-column align-items-center justify-content-center">

                        <div class="card" style="width: 20rem;">
                            <div style="padding:10px;text-align:center;margin-top:20px">
                                <img src="assets/img/bawaslu/verify.png" style="width: 75px;" class="card-img-top" alt="...">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title" style="text-align:center;font-size: 25px;"><?= $Nama ?></h5>
                                <h5 style="text-align:center;font-size: 20px;"><?= $NIK ?></h5>
                                <hr />
                                <div class="row">
                                    <div class="col-sm-6 mb-6 mb-sm-0">
                                        <div>
                                            <div class="card-text">Kecamatan</div>
                                            <div class="card-text" style="font-weight: bold;"><?= $Kecamatan ?></div>
                                            <br/>
                                            <div class="card-text">Kelurahan</div>
                                            <div class="card-text" style="font-weight: bold;"><?= $Kelurahan ?></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mb-6 mb-sm-0">
                                        <div style="text-align: right;">TPS / <text style="font-weight: bold;">DPT</text></div>
                                        <h1 style="font-weight: bold;text-align: right;"><?= $NomorTPS2 ?></h1>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="card-body">
                                <a href="form-main.php" class="btn btn-success w-100">Next</a>
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