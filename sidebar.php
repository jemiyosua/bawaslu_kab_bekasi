<?php

require_once('koneksi.php');

session_start();

?>
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="main.php">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Master Data</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>

            <ul id="components-nav" class="nav-content collapse <?= $_SESSION['nav'] == "master-data" ? 'show' : '' ?>" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="master-partai.php" class="<?= $_SESSION['nav-page'] == "master-partai" ? 'active' : '' ?>">
                        <i class="bi bi-circle"></i><span>Partai</span>
                    </a>
                </li>
                <li>
                    <a href="master-ppwp.php" class="<?= $_SESSION['nav-page'] == "master-ppwp" ? 'active' : '' ?>">
                        <i class="bi bi-circle"></i><span>PPWP</span>
                    </a>
                </li>
                <li>
                    <a href="master-dpr-ri.php" class="<?= $_SESSION['nav-page'] == "master-dpr-ri" ? 'active' : '' ?>">
                        <i class="bi bi-circle"></i><span>DPR - RI</span>
                    </a>
                </li>
                <li>
                    <a href="master-dpd-ri.php" class="<?= $_SESSION['nav-page'] == "master-dpd-ri" ? 'active' : '' ?>">
                        <i class="bi bi-circle"></i><span>DPD - RI</span>
                    </a>
                </li>
                <li>
                    <a href="master-dprd-prov.php" class="<?= $_SESSION['nav-page'] == "master-dprd-prov" ? 'active' : '' ?>">
                        <i class="bi bi-circle"></i><span>DPRD - PROV</span>
                    </a>
                </li>
                <li>
                    <a href="master-dprd-kab.php" class="<?= $_SESSION['nav-page'] == "master-dprd-kab" ? 'active' : '' ?>">
                        <i class="bi bi-circle"></i><span>DPRD - KAB</span>
                    </a>
                </li>
                <li>
                    <a href="master-ptps.php" class="<?= $_SESSION['nav-page'] == "master-ptps" ? 'active' : '' ?>">
                        <i class="bi bi-circle"></i><span>PTPS</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#master-suara-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-megaphone"></i><span>Master Suara</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>

            <ul id="master-suara-nav" class="nav-content collapse <?= $_SESSION['nav'] == "master-suara" ? 'show' : '' ?>" data-bs-parent="#sidebar-nav">

            <?php
            
            $q = "SELECT kecamatan FROM db_ptps GROUP BY kecamatan";
            $sql = mysqli_query($conn, $q);
            while ($row = mysqli_fetch_assoc($sql)) {

                $Kecamatan = strtoupper($row['kecamatan']);

                ?>
                
                <li>
                    <a href="master-suara.php?nav-page=<?= $Kecamatan ?>" class="<?= $_SESSION['nav-page'] == $Kecamatan ? 'active' : '' ?>">
                        <i class="bi bi-circle"></i><span><?= $Kecamatan ?></span>
                    </a>
                </li>

                <?php
            }


            ?>

            </ul>
        </li> -->

        <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#rekap-suara-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-calculator"></i><span>Perhitungan Suara</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <!-- <a class="nav-link" href="#">
                <i class="bi bi-calculator"></i>
                <span>Perhitungan Suara</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>  -->

            <ul id="rekap-suara-nav" class="nav-content collapse <?= $_SESSION['nav'] == "perhitungan-suara" ? 'show' : '' ?>" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="hasil-rekap.php" class="<?= $_SESSION['nav-page'] == "hasil-rekap" ? 'active' : '' ?>">
                        <i class="bi bi-circle"></i><span>Rekap Suara</span>
                    </a>
                </li>
            </ul>
        </li>
            </a>
        </li>

        <!-- <li class="nav-heading">Pages</li>

        <li class="nav-item">
        <a class="nav-link collapsed" href="users-profile.html">
            <i class="bi bi-person"></i>
            <span>Profile</span>
        </a>
        </li>

        <li class="nav-item">
        <a class="nav-link collapsed" href="pages-faq.html">
            <i class="bi bi-question-circle"></i>
            <span>F.A.Q</span>
        </a>
        </li>

        <li class="nav-item">
        <a class="nav-link collapsed" href="pages-contact.html">
            <i class="bi bi-envelope"></i>
            <span>Contact</span>
        </a>
        </li>

        <li class="nav-item">
        <a class="nav-link collapsed" href="pages-register.html">
            <i class="bi bi-card-list"></i>
            <span>Register</span>
        </a>
        </li>

        <li class="nav-item">
        <a class="nav-link collapsed" href="pages-login.html">
            <i class="bi bi-box-arrow-in-right"></i>
            <span>Login</span>
        </a>
        </li>

        <li class="nav-item">
        <a class="nav-link collapsed" href="pages-error-404.html">
            <i class="bi bi-dash-circle"></i>
            <span>Error 404</span>
        </a>
        </li>

        <li class="nav-item">
        <a class="nav-link collapsed" href="pages-blank.html">
            <i class="bi bi-file-earmark"></i>
            <span>Blank</span>
        </a>
        </li> -->

    </ul>

  </aside>