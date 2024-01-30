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

$KategoriCapil = $_GET['kc'];

?>

<main id="main" class="main">

	<div class="pagetitle">
        <div class="d-flex align-items-center justify-content-between">
	        <h1><a href="master-suara-detail.php?id=<?=$IdPTPS?>&nav=master-suara&nav-page=<?=$KecamatanPage?>&kel=<?=$KelurahanPage?>"><i class="bi bi-arrow-left-circle-fill"></i></a> Dashboard Detail Master Suara : <?= $KecamatanPage ?> / <?= $KelurahanPage ?></h1>
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
                <?php

                $q = "SELECT kode_partai FROM db_master_capil WHERE kategori_capil = '$KategoriCapil' GROUP BY kode_partai";
                $sql = mysqli_query($conn, $q);
                while($row = mysqli_fetch_assoc($sql)) {

                    $KodePartai = $row['kode_partai'];

                    ?>
                    
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title"><i class="bi bi-flag-fill"></i> PARTAI <?= $KodePartai ?></h5>
                                    <!-- <a href="master-suara-detail-partai-capil.php?kc=<?=$KategoriCapil?>&id=<?=$IdPTPS?>&nav=master-suara&nav-page=<?=$KecamatanPage?>&kel=<?=$KelurahanPage?>"><span class="badge rounded-pill text-bg-dark"><i class="bi bi-eye-fill"></i> Lihat Suara Partai</span></a> -->
                                </div>

                                <ul class="list-group">

                                <?php
                                
                                $q2 = "SELECT no_urut, nama_capil, jumlah_suara FROM db_master_capil a LEFT JOIN db_hasil_rekap_dtl b ON a.id = b.id_mst_capil WHERE a.kategori_capil = '$KategoriCapil' AND a.kode_partai = '$KodePartai'";
                                $sql2 = mysqli_query($conn, $q2);
                                while($row2 = mysqli_fetch_assoc($sql2)) {

                                    $NomorUrut = $row2['no_urut'];
                                    $NamaCapil = $row2['nama_capil'];
                                    $JumlahSuara = $row2['jumlah_suara'];

                                    $vJumlahSuara = 0;
                                    if ($JumlahSuara != "") {
                                        $vJumlahSuara = $JumlahSuara;
                                    }

                                    ?>
                                    
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex justify-content align-items-center">
                                                    <div style="font-weight: bold;"><?= $NomorUrut ?></div>.
                                                    <div style="margin-right: 5px;"></div>
                                                    <div><?= $NamaCapil ?></div>
                                                </div>
                                                <div style="font-weight: bold;color:<?= $JumlahSuara == "" ? 'red' : '' ?>"><i class="bi bi-megaphone-fill"></i> : <?= $vJumlahSuara ?></div>
                                            </div>
                                        </li>

                                    <?php

                                }
                                
                                ?>
                                
                                </ul>
                            </div>
                        </div>
                    </div>

                    <?php
                }

                ?>

            </div>

		</div>
	</div>
	</section>

</main>

<?php

require_once('footer.php');

?>