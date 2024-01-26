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
    $sql = mysqli_query($conn, "SELECT kecamatan, kelurahan, no_tps, nama FROM db_ptps WHERE no_ktp = '$NomorKTP'");
    $row = mysqli_fetch_assoc($sql);
    $Kecamatan = $row["kecamatan"];
    $Kelurahan = $row["kelurahan"];
    $NomorTPS = $row["no_tps"];
    $Nama = $row["nama"];
}


?>

<main>
    <div class="container">

        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                        <div class="card">
                            <h5 class="card-header">Detail Data PTPS</h5>
                            <div class="card-body">
                                <h5 class="card-title"><?= $Nama ?></h5>
                                <p class="card-text"></p>
                                <a href="#" class="btn btn-primary"></a>
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