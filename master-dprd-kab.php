<?php

session_start();

if (!isset($_SESSION['username']) && (!isset($_SESSION['password']))) {

    header('location:login.php');
}

$_SESSION['nav'] = "master-data";
$_SESSION['nav-page'] = "master-dprd-kab";

require_once('header.php');

require_once('navbar.php');

require_once('sidebar.php');

require_once('koneksi.php');


?>

<main id="main" class="main">

	<div class="pagetitle">
	<h1>Dashboard Master Partai</h1>
	</div>

    <hr/>

	<section class="section">
	<div class="row">
		<div class="col-lg-12">

            <div class="row align-items-center">

            <?php
            
            $q = "SELECT dapil FROM db_master_capil WHERE kategori_capil = 'DPRD-KAB' GROUP BY dapil";
            $sql = mysqli_query($conn, $q);
            while ($row = mysqli_fetch_assoc($sql)) {

                $Dapil = $row['dapil'];

                ?>
                
                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title" style="font-size: 25px;">Dapil <?= $Dapil ?></h5>
                                <?php
                                
                                $q1 = "SELECT kecamatan FROM db_master_dapil WHERE dapil = '$Dapil'";
                                $sql1 = mysqli_query($conn, $q1);
                                while ($row1 = mysqli_fetch_assoc($sql1)) {

                                    $Kecamatan = $row1['kecamatan'];

                                    ?>
                                    
                                    <span class="badge rounded-pill text-bg-success"><?= $Kecamatan ?></span>

                                    <?php
                                }
                                
                                ?>
                                <hr/>
                                <a href="master-dapil-bekasi.php?id=<?=$Dapil?>" class="btn btn-outline-primary">Master Dapil <?= $Dapil ?> <i class="bi bi-arrow-right-circle-fill"></i></a>
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