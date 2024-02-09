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

$KategoriCapil = $_SESSION['kc'];
$Dapil = $_SESSION['dapil'];

$sql = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_hasil_rekap_hdr WHERE no_ktp = '$NomorKTP' AND kategori_capil = '$KategoriCapil'");
$row = mysqli_fetch_assoc($sql);
$CountIsi = $row['cnt'];

?>

<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-heading">Form Rekapitulasi</li>

            <!-- MENU FORM PARTAI 2 -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="<?= $KategoriCapil != 'PPWP' ? 'form-partai-2.php?kc='.$KategoriCapil : 'form-ppwp.php?kc=PPWP' ?>">
                    <i class="bi bi-person"></i>
                    <span>Form <?=$KategoriCapil?> <?= $CountIsi > 0 ? '<img src="assets/img/bawaslu/done.png" style="width: 20px;" />' : '' ?></span>
                </a>
            </li>

             <!-- <li class="nav-item">
                <a class="nav-link collapsed" href="<?= $KategoriCapil != 'PPWP' ? 'form-partai-image.php?kc='.$KategoriCapil : 'form-ppwp.php?kc=PPWP' ?>">
                    <i class="bi bi-person"></i>
                    <span>Form Image <?=$KategoriCapil?> <?= $CountIsi > 0 ? '<img src="assets/img/bawaslu/done.png" style="width: 20px;" />' : '' ?></span>
                </a>
            </li> -->

            <?php

            if ($KategoriCapil == "DPD-RI") {

                $sql = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_master_capil WHERE kategori_capil = '$KategoriCapil'");
                $row = mysqli_fetch_assoc($sql);
                $JumlahHarusDiisi = $row['cnt'];

                $sql2 = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_hasil_rekap_dtl WHERE no_ktp = '$NomorKTP' AND kategori_capil = '$KategoriCapil'");
                $row2 = mysqli_fetch_assoc($sql2);
                $JumlahDiisi = $row2['cnt'];

                if ($JumlahHarusDiisi == $JumlahDiisi) {

                    ?>
                    
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="form-partai.php?kc=<?=$KategoriCapil?>">
                            <i class="bi bi-person"></i>
                            <span>Form Jumlah Suara <?=$KategoriCapil?> <?= $CountIsi > 0 ? '<img src="assets/img/bawaslu/done.png" style="width: 20px;" />' : '' ?></span>
                        </a>
                    </li>

                    <?php

                } else {

                    ?>
                    
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="form-partai.php?kc=<?=$KategoriCapil?>">
                            <i class="bi bi-person"></i>
                            <span>Form Jumlah Suara <?=$KategoriCapil?></span>
                        </a>
                    </li>

                    <?php

                }

                ?>
                
                

                <?php

            }

            if ($KategoriCapil == "DPRD-KAB") {
                $sql = mysqli_query($conn, "SELECT b.id, a.kode_partai FROM db_master_capil a, db_master_partai b WHERE a.kode_partai = b.kode_partai AND kategori_capil = '$KategoriCapil' AND dapil = '$Dapil' GROUP BY a.kode_partai ORDER BY b.id ASC");
            } else {
                $sql = mysqli_query($conn, "SELECT b.id, a.kode_partai FROM db_master_capil a, db_master_partai b WHERE a.kode_partai = b.kode_partai AND kategori_capil = '$KategoriCapil' GROUP BY a.kode_partai ORDER BY b.id ASC");
            }

            while ($row = mysqli_fetch_assoc($sql)) {

                $NomorPartai = $row['id'];
                $KodePartai = $row['kode_partai'];

            ?>
            
            <!-- MENU FORM PARTAI 1 -->
            <li class="nav-item">

                <?php

                if ($KategoriCapil == "DPD-RI") {
                    
                    ?>

                    <a class="nav-link collapsed" href="form-partai.php?kc=<?= $KategoriCapil ?>">

                    <?php

                } else {

                    ?>
                    
                    <a class="nav-link collapsed" href="form-partai.php?kp=<?= $KodePartai ?>&kc=<?= $KategoriCapil ?>&dapil=<?= $Dapil ?>">

                    <?php

                }
                
                ?>
                
                    <!-- <i class="bi bi-flag-fill"></i> -->

                    <?php

                        if ($KategoriCapil == "DPRD-KAB") {

                            $sql2 = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_master_capil WHERE kategori_capil = '$KategoriCapil' AND kode_partai = '$KodePartai' AND dapil = '$Dapil'");
                            $row2 = mysqli_fetch_assoc($sql2);
                            $TotalPengisianData = $row2['cnt'];
        
                            $sql3 = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_hasil_rekap_dtl WHERE no_ktp = '$NomorKTP' AND kategori_capil = '$KategoriCapil' AND kode_partai = '$KodePartai'");
                            $row3 = mysqli_fetch_assoc($sql3);
                            $TotalSudahMengisi = $row3['cnt'];
        
                            if ($TotalPengisianData == 0) {
                                ?>
                                    <span><?= $KodePartai ?> <img src="assets/img/bawaslu/x-mark.png" style="width: 20px;" /></span>
                                <?php
                            } else {
                                if ($TotalSudahMengisi == $TotalPengisianData) {
                                    ?>
                                        <span><?= $KodePartai ?> <img src="assets/img/bawaslu/done.png" style="width: 20px;" /></span>
                                    <?php
                                } else {
                                    ?>
                                        <span><?= $KodePartai ?></span>
                                    <?php
                                }
                            }

                        } else {
                            
                            $sql2 = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_master_capil WHERE kategori_capil = '$KategoriCapil' AND kode_partai = '$KodePartai'");
                            $row2 = mysqli_fetch_assoc($sql2);
                            $TotalPengisianData = $row2['cnt'];
        
                            $sql3 = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_hasil_rekap_dtl WHERE no_ktp = '$NomorKTP' AND kategori_capil = '$KategoriCapil' AND kode_partai = '$KodePartai'");
                            $row3 = mysqli_fetch_assoc($sql3);
                            $TotalSudahMengisi = $row3['cnt'];
        
                            if ($TotalSudahMengisi == $TotalPengisianData) {
                                ?>
                                    <span><?= $NomorPartai ?>. <?= $KodePartai ?> <img src="assets/img/bawaslu/done.png" style="width: 20px;" /></span>
                                <?php
                            } else {
                                ?>
                                    <span><?= $NomorPartai ?>. <?= $KodePartai ?></span>
                                <?php
                            }
                            
                        }

                    ?>
                    
                </a>
            </li>

            <?php
        }
        
        ?>

    </ul>

  </aside>