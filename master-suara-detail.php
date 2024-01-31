<?php

session_start();

if (!isset($_SESSION['username']) && (!isset($_SESSION['password']))) {

    header('location:login.php');
}

$_SESSION['nav'] = "master-suara";
$_SESSION['nav-page'] = $_GET['nav-page'];
$KecamatanPage = strtoupper($_GET['nav-page']);
$KelurahanPage = strtoupper($_GET['kel']);
$IdPTPS = $_GET['id'];

require_once('header.php');

require_once('navbar.php');

require_once('sidebar.php');

require_once('koneksi.php');

$q = "SELECT no_tps, no_ktp FROM db_ptps WHERE id = '$IdPTPS'";
$sql = mysqli_query($conn, $q);
$row = mysqli_fetch_assoc($sql);

$NomorTPS = $row['no_tps'];
$NomorKTP = $row['no_ktp'];

?>

<main id="main" class="main">

	<div class="pagetitle">
        <div class="d-flex align-items-center justify-content-between">
	        <h1><a href="master-suara.php?nav-page=<?= $KecamatanPage ?>"><i class="bi bi-arrow-left-circle-fill"></i></a> Dashboard Detail Master Suara : <?= $KecamatanPage ?> / <?= $KelurahanPage ?></h1>
            <div style="font-weight: bold;font-size: 20px;">
                <span class="badge rounded-pill text-bg-warning">INPUTOR</span> : <?= $NomorKTP ?>
            </div>
        </div>
	</div>

	<hr/>

	<section class="section">
	<div class="row">
		<div class="col-lg-12">

            <div class="row">
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title"><i class="bi bi-person-raised-hand"></i> PPWP</h5>
                                <a href=""><span class="badge rounded-pill text-bg-secondary"><i class="bi bi-eye-fill"></i> Lihat Riwayat Suara</span></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title"><i class="bi bi-person-raised-hand"></i> DPR - RI</h5>
                                <a href="master-suara-detail-partai.php?kc=DPR-RI&id=<?=$IdPTPS?>&nav=master-suara&nav-page=<?=$KecamatanPage?>&kel=<?=$KelurahanPage?>"><span class="badge rounded-pill text-bg-warning"><i class="bi bi-eye-fill"></i> Lihat Riwayat Suara</span></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title"><i class="bi bi-person-raised-hand"></i> DPD - RI</h5>
                                <a href=""><span class="badge rounded-pill text-bg-danger"><i class="bi bi-eye-fill"></i> Lihat Riwayat Suara</span></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title"><i class="bi bi-person-raised-hand"></i> DPRD - PROVINSI</h5>
                                <a href=""><span class="badge rounded-pill text-bg-primary"><i class="bi bi-eye-fill"></i> Lihat Riwayat Suara</span></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title"><i class="bi bi-person-raised-hand"></i> DAPIL BEKASI <?= $DapilKab ?></h5>
                                <a href=""><span class="badge rounded-pill text-bg-success"><i class="bi bi-eye-fill"></i> Lihat Riwayat Suara</span></a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

		</div>
	</div>
	</section>

</main>

<?php

require_once('footer.php');

?>