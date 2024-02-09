<?php

session_start();

if (!isset($_SESSION['username']) && (!isset($_SESSION['password']))) {

    header('location:login.php');
}

$_SESSION['nav'] = "batch-kecamatan";
$_SESSION['nav-page'] = "";

require_once('header.php');

require_once('navbar.php');

require_once('sidebar.php');

require_once('koneksi.php');

?>

<main id="main" class="main">
	
	<?php
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

	<div class="pagetitle">
		<h1>Dashboard Batch Kecamatan</h1>
	</div>

	<hr/>

	<section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="row">

                <?php
                
				$No = 0;
				$query = mysqli_query($conn, "SELECT COUNT(*) AS cnt, nomor_batch, status_all FROM db_batch_kecamatan GROUP BY nomor_batch");
				while ($row = mysqli_fetch_assoc($query)) {

                    $No++;
					$TotalKecamatan = $row['cnt'];
					$NomorBatch = $row['nomor_batch'];
					$Status = $row['status_all'];

					if ($Status == 0) {
						$Value = "";
						$Alert = "alert-danger";
						$Text = "Status Batch $NomorBatch Sedang OFF (Tidak Aktif)";
					} else {
						$Value = "checked";
						$Alert = "alert-success";
						$Text = "Status Batch $NomorBatch Sedang ON (Aktif)";
					}

                    ?>
                    
                        <div class="col-sm-4 mb-3 mb-sm-0">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title" style="font-size: 25px;">Batch <?= $NomorBatch ?></h5>

									<!-- <hr/> -->

									<ul class="list-group">

                                    <?php
                                    
                                    $query2 = mysqli_query($conn, "SELECT kecamatan, status FROM db_batch_kecamatan WHERE nomor_batch = '$NomorBatch'");
                                    while ($row2 = mysqli_fetch_assoc($query2)) {

                                        $Kecamatan = $row2['kecamatan'];
										$StatusKecamatan = $row2['status'];
										if ($StatusKecamatan == 0) {
											$ValueKecamatan = "";
											$Badge = '<span class="badge rounded-pill text-bg-danger">Tidak Aktif</span>';
										} else {
											$ValueKecamatan = "checked";
											$Badge = '<span class="badge rounded-pill text-bg-success">Aktif</span>';
										}

                                        ?>
                                        
                                        <!-- <span class="badge rounded-pill text-bg-light"><?= $Kecamatan ?></span> -->
										<li class="list-group-item">
										<div class="d-flex justify-content-between align-items-center">
												<?= $Kecamatan ?>
												<form action="proses.php" method="POST">
													<div class='form-check form-switch'>
														<input class='form-check-input' type='checkbox' role='switch' id='status_kecamatan' name='status_kecamatan' onchange='this.form.submit()' <?=$ValueKecamatan?>>
														<label class='form-check-label'><?= $Badge ?></label>
													</div>
													<input type='hidden' class='form-control' name='nomor_batch' value='<?= $NomorBatch ?>'>
													<input type='hidden' class='form-control' name='kecamatan' value='<?= $Kecamatan ?>'>
													<input type='hidden' class='form-control' name='status_kecamatan' value='<?= $StatusKecamatan ?>'>
													<input type='hidden' class='form-control' name='total_kecamatan' value='<?= $TotalKecamatan ?>'>
													<input type='hidden' class='form-control' name='submit-kecamatan' value='submit-kecamatan'>
												</form>
											</div>
										</li>

                                        <?php
                                    }
                                    
                                    ?>
									
									</ul>
                                    
									<hr/>

									<div class="alert <?= $Alert ?>" role="alert" style="font-weight: bold;"><?= $Text ?></div>

									<form action="proses.php" method="POST">
										<div class='form-check form-switch'><input class='form-check-input' type='checkbox' role='switch' id='status' name='status' onchange='this.form.submit()' <?=$Value?>>
											<label class='form-check-label'>Status Batch</label>
										</div>
										<input type='hidden' class='form-control' name='nomor_batch' value='<?= $NomorBatch ?>'>
										<input type='hidden' class='form-control' name='status_batch' value='<?= $Status ?>'>
										<input type='hidden' class='form-control' name='submit-batch-kecamatan' value='submit-batch-kecamatan'>
									</form>
									
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

mysqli_close($conn);