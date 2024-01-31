<?php

session_start();

$NomorKTP = $_SESSION['nomor_ktp'];
$KategoriCapil = $_GET['kc'];
$KodePartaiPage = $_GET['kp'];
$Dapil = $_GET['dapil'];
$_SESSION['kc'] = $KategoriCapil;
$_SESSION['dapil'] = $Dapil;

require_once('header.php');

require_once('navbar-form.php');

require_once('sidebar-form.php');

require_once('koneksi.php');

?>

<main id="main" class="main">

    <?php
    
    if ($KodePartaiPage != "") {

        if ($KategoriCapil == "DPRD-KAB") {
            $sql = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_master_capil WHERE kategori_capil = '$KategoriCapil' AND kode_partai = '$KodePartaiPage' AND dapil = '$Dapil'");
        } else {
            $sql = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_master_capil WHERE kategori_capil = '$KategoriCapil' AND kode_partai = '$KodePartaiPage'");
        }
        
        $row = mysqli_fetch_assoc($sql);
        $TotalPengisianData = $row['cnt'];

        ?>

        <div class="pagetitle">
            <h1>Partai <?= $KodePartaiPage ?> <span class="badge rounded-pill text-bg-warning"><?= $TotalPengisianData ?> Data</span></h1>
        </div>

        <hr/>

        <?php
        
        if ($TotalPengisianData == 0) {

            ?>
            
            <div class="alert alert-danger" role="alert">
                <div style="font-weight: bold;">Tidak Ada Calon Pilihan Dari Partai Ini!</div>
            </div>

            <?php
            
        } else {
            
            ?>
            
            <div class="alert alert-info" role="alert">
                <div style="font-weight: bold;">Silahkan Melakukan Pengisian Total Suara Dengan Melakukan Klik Pada Tombol : Mulai Mengisi Berwarna Merah</div>
            </div>
            
            <?php

        }

    } else {

        if ($KategoriCapil == "DPRD-PROV") {

            $sql = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_master_capil WHERE kategori_capil = '$KategoriCapil'");
            $row = mysqli_fetch_assoc($sql);
            $TotalPengisianData = $row['cnt'];

            ?>
            
            <div class="pagetitle">
                <h1><?= $KategoriCapil ?> <span class="badge rounded-pill text-bg-warning"><?= $TotalPengisianData ?> Data</span></h1>
            </div>

            <hr/>

            <?php

        } else {

            ?>
        
            <div class="pagetitle">
                <div class="alert alert-success" role="alert">
                    <div style="font-weight: bold;">Silahkan Melakukan Pengisian Total Suara Dengan Melakukan Klik Pada Sidebar Menu</div>
                </div>
            </div>

            <?php

        }
    }

    if (isset($_SESSION['pesan'])) {
        echo "<script>
        Swal.fire({
            allowEnterKey: false,
            allowOutsideClick: false,
            icon: 'success',
            title: 'Good Job :)',
            text: '" . $_SESSION['pesan'] . "'
        }).then(function() {
        });
        </script>";
        unset($_SESSION['pesan']);
    } else if (isset($_SESSION['pesanError'])) {
        echo "<script>
        Swal.fire({
            allowEnterKey: false,
            allowOutsideClick: false,
            icon: 'error',
            title: 'Sorry :(',
            text: '" . $_SESSION['pesanError'] . "'
        }).then(function() {
        });
        </script>";
        unset($_SESSION['pesanError']);
    }
    
    ?>

	<section class="section dashboard">
		<div class="row">
			
			<div class="col-lg-12">
                <div class="row">

                <?php


                if ($KodePartaiPage != "") {

                    if ($KategoriCapil == "DPRD-KAB") {
                        $sql = mysqli_query($conn, "SELECT id, no_urut, nama_capil, dapil FROM db_master_capil WHERE kategori_capil = '$KategoriCapil' AND kode_partai = '$KodePartaiPage' AND dapil = '$Dapil'");
                    } else {
                        $sql = mysqli_query($conn, "SELECT id, no_urut, nama_capil, dapil FROM db_master_capil WHERE kategori_capil = '$KategoriCapil' AND kode_partai = '$KodePartaiPage'");
                    }
        
                    while ($row = mysqli_fetch_assoc($sql)) {
    
                        $Id = $row['id'];
                        $NomorUrut = $row['no_urut'];
                        $NamaCapil = $row['nama_capil'];
                        $Dapil = $row['dapil'];
    
                        ?>
                        
                        <div class="col-sm-3 mb-3 mb-sm-0">
                            <div class="card" style="height: auto;">
                                <div class="card-body">
                                    <h5 class="card-title" style="font-size: 20px;"><?= $NomorUrut ?>. <?= $NamaCapil ?></h5> 
                                    <p class="card-text" style="font-weight: bold;"><i class="bi bi-geo-alt-fill"></i> <?= $KategoriCapil ?> | <?= $Dapil ?></p>
                                    <hr/>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <?php

                                        if ($KategoriCapil == "DPRD-KAB") {
                                            $sql2 = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_hasil_rekap_hdr WHERE no_ktp = '$NomorKTP' AND kategori_capil = '$KategoriCapil' AND kode_partai = '$KodePartaiPage' AND id_mst_capil = '$Id'");
                                        } else {
                                            $sql2 = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_hasil_rekap_hdr WHERE no_ktp = '$NomorKTP' AND kategori_capil = '$KategoriCapil' AND kode_partai = '$KodePartaiPage' AND id_mst_capil = '$Id'");
                                        }

                                        $row2 = mysqli_fetch_assoc($sql2);
                                        $CountIsi = $row2['cnt'];
    
                                        if ($CountIsi > 0) {
                                            ?>
                                                <span class="badge rounded-pill text-bg-success">DONE</span>
                                                <!-- <div style="font-weight: bold;"><i class="bi bi-megaphone-fill"></i> : <?=$JumlahSuara?></div> -->
                                            <?php
                                        } else {
                                            ?>
                                                <a href="form-partai-submit.php?kc=<?=$KategoriCapil?>&id=<?=$Id?>&kp=<?=$KodePartaiPage?>&nc=<?=$NamaCapil?>&dapil=<?=$Dapil?>"><span class="badge rounded-pill text-bg-danger">Mulai Mengisi</span></a>
                                            <?php
                                        }
                                        
                                        ?>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
    
                        <?php
                    }

                } else {

                    if ($KategoriCapil == "DPRD-PROV") {

                        $sql = mysqli_query($conn, "SELECT id, no_urut, nama_capil, dapil FROM db_master_capil WHERE kategori_capil = '$KategoriCapil'");
        
                        while ($row = mysqli_fetch_assoc($sql)) {
        
                            $Id = $row['id'];
                            $NomorUrut = $row['no_urut'];
                            $NamaCapil = $row['nama_capil'];
                            $Dapil = $row['dapil'];
        
                            ?>
                            
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title" style="font-size: 20px;"><?= $NomorUrut ?>. <?= $NamaCapil ?></h5> 
                                        <p class="card-text" style="font-weight: bold;"><i class="bi bi-geo-alt-fill"></i> <?= $KategoriCapil ?> | <?= $Dapil ?></p>
                                        <hr/>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <?php                                    
                                            
                                            $sql2 = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_hasil_rekap_hdr WHERE no_ktp = '$NomorKTP' AND kategori_capil = '$KategoriCapil' AND id_mst_capil = '$Id'");
                                            $row2 = mysqli_fetch_assoc($sql2);
                                            $CountIsi = $row2['cnt'];
        
                                            if ($CountIsi > 0) {
                                                ?>
                                                    <span class="badge rounded-pill text-bg-success">DONE</span>
                                                    <!-- <div style="font-weight: bold;"><i class="bi bi-megaphone-fill"></i> : <?=$JumlahSuara?></div> -->
                                                <?php
                                            } else {
                                                ?>
                                                    <a href="form-partai-submit.php?kc=<?=$KategoriCapil?>&id=<?=$Id?>&nc=<?=$NamaCapil?>"><span class="badge rounded-pill text-bg-danger">Mulai Mengisi</span></a>
                                                <?php
                                            }
                                            
                                            ?>
                                            
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
        
                            <?php
                        }
                    }
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