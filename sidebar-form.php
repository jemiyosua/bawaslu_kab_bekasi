<?php

session_start();

require_once('koneksi.php');

$KategoriCapil = $_SESSION['kc'];
$Dapil = $_SESSION['dapil'];

?>

<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-heading">Form Rekapitulasi</li>

        <?php
        
        if ($KategoriCapil == "PPWP") {

            ?>
            
            <li class="nav-item">
                <a class="nav-link <?= $_SESSION['page'] == 'form-ppwp' ? '' : 'collapsed' ?>" href="form-ppwp.php?kc=PPWP">
                    <i class="bi bi-person"></i>
                    <span>Form PPWP</span>
                </a>
            </li>

            <?php
        }
        
            $sql = mysqli_query($conn, "SELECT kode_partai FROM db_master_capil WHERE kategori_capil = '$KategoriCapil' GROUP BY kode_partai ORDER BY kode_partai ASC");
            while ($row = mysqli_fetch_assoc($sql)) {

            $KodePartai = $row['kode_partai'];

            ?>
            
            <li class="nav-item">
                <?php

                if ($KategoriCapil == "DPRD-PROV") {
                    
                    ?>

                    <a class="nav-link collapsed" href="form-partai.php?kc=<?= $KategoriCapil ?>">

                    <?php
                } else {

                    ?>
                    
                    <a class="nav-link collapsed" href="form-partai.php?kp=<?= $KodePartai ?>&kc=<?= $KategoriCapil ?>&dapil=<?= $Dapil ?>">

                    <?php
                }
                
                ?>
                
                    <i class="bi bi-flag-fill"></i>

                    <?php

                    if ($KategoriCapil == "DPRD-PROV") {

                        // get count data dprd provinsi di tabel master capil
                        $sql = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_master_capil WHERE kategori_capil = '$KategoriCapil'");
                        $row = mysqli_fetch_assoc($sql);
                        $CountMasterCapil = $row['cnt'];

                        $sql2 = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_hasil_rekap_dtl WHERE no_ktp = '$NomorKTP' AND kategori_capil = '$KategoriCapil'");
                        $row2 = mysqli_fetch_assoc($sql2);
                        $CountIsi = $row2['cnt'];

                        if ($CountMasterCapil == $CountIsi) {

                            ?>
                        
                            <span>Form Partai <?= $KategoriCapil ?> <img src="assets/img/bawaslu/done.png" style="width: 20px;" /></span>
    
                            <?php
                            
                        } else {

                            ?>
                        
                            <span>Form Partai <?= $KategoriCapil ?></span>
    
                            <?php

                        }
                    } else {

                        if ($KategoriCapil == "DPRD-KAB") {

                            $sql2 = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_master_capil WHERE kategori_capil = '$KategoriCapil' AND kode_partai = '$KodePartai' AND dapil = '$Dapil'");
                            $row2 = mysqli_fetch_assoc($sql2);
                            $TotalPengisianData = $row2['cnt'];
        
                            $sql3 = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_hasil_rekap_hdr WHERE no_ktp = '$NomorKTP' AND kategori_capil = '$KategoriCapil' AND kode_partai = '$KodePartai'");
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
        
                            $sql3 = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_hasil_rekap_hdr WHERE no_ktp = '$NomorKTP' AND kategori_capil = '$KategoriCapil' AND kode_partai = '$KodePartai'");
                            $row3 = mysqli_fetch_assoc($sql3);
                            $TotalSudahMengisi = $row3['cnt'];
        
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
                    }

                    ?>
                    
                </a>
            </li>

            <?php
        }
        
        ?>

    </ul>

  </aside>