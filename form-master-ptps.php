<?php

session_start();

if (!isset($_SESSION['username']) && (!isset($_SESSION['password']))) {

	header('location:login.php');
}

$_SESSION['nav'] = "master-data";
$_SESSION['nav-page'] = "form-master-ptps";

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
			window.location.href='master-ptps.php';
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
			window.location.href='master-ptps.php';
		});
		</script>";
		unset($_SESSION['pesanError']);
	}
	?>
	

	<div class="pagetitle">
		<h1>Dashboard Master PTPS</h1>
	</div>

	<hr />

	<section class="section">
		<div class="row">
			<div class="col-lg-12">

				<div class="card">
					<div class="card-body">

						<div class="d-flex justify-content-between align-items-center">
							<div class="col-sm-6 mb-6 mb-sm-0">
								<h5 class="card-title">Master PTPS</h5>
							</div>
						</div>

						<hr />
						<div>
							<?php
	                           if (isset($_GET['Id'])) {
								$Id = $_GET['Id'];
							   }
							   if (isset($_GET['Kecamatan'])) {
								$Kecamatan = $_GET['Kecamatan'];
							   }
							   if (isset($_GET['Kelurahan'])) {
								$Kelurahan = $_GET['Kelurahan'];
							   }
							   if (isset($_GET['NomorTPS'])) {
								$NomorTPS = $_GET['NomorTPS'];
							   }
							   if (isset($_GET['NomorKTP'])) {
								$NomorKTP = $_GET['NomorKTP'];
							   }
							   if (isset($_GET['Nama'])) {
								$Nama = $_GET['Nama'];
							   }
							   if (isset($_GET['Dapil'])) {
								$Dapil = $_GET['Dapil'];
							   }
							?>
							<form class="row g-3 needs-validation" method="POST" action="proses.php">
								<div class="modal-body">
									<div class="form-group" hidden>
										<input type="text" name="vID" class="form-control"
											value="<?php echo $Id ?>" />
									</div>

									<div class="form-group">
										<label>Daerah Pilihan</label>
										<select name="vDapil" class="form-select" id="dapil">
											<?php
											if (isset($Dapil)) {
												$default_dapil = $Dapil;
											}
											if (isset($default_dapil)) {
												?>

												<option value="<?php echo $default_dapil ?>" selected='selected' hidden>
													<?php echo $default_dapil ?>
												</option>

												<?php
											}
											$q_Dapil = mysqli_query($conn, "SELECT DISTINCT dapil from db_master_dapil");
											while ($row_dapil = mysqli_fetch_array($q_Dapil)) {
												?>
												<option value="<?php echo $row_dapil['dapil'] ?>">
													<?php echo $row_dapil['dapil'] ?>
												</option>

												<?php
											}
											?>
										</select>
									</div>
									

									<div class="form-group">
										<label>Kecamatan</label>
										<select name="vKecamatan" class="form-select" id = "kecamatan">
											<?php

											if (isset($_POST['pilihan-dapil'])) {
												$pilihan_dapil = $_POST['pilihan-dapil'];
											} else {
												$pilihan_dapil = $Dapil;
											}
											if (isset($Kecamatan)) {
												$default_kecamatan = $Kecamatan;
											}
											if (isset($default_kecamatan)) {
												?>

												<option value="<?php echo $default_kecamatan ?>" selected='selected' hidden>
													<?php echo $default_kecamatan ?>
												</option>

												<?php
											}
											$q_Kecamatan = mysqli_query($conn, "SELECT kecamatan from db_master_dapil WHERE dapil like '%$pilihan_dapil%'");
											while ($row_Kec = mysqli_fetch_array($q_Kecamatan)) {
												?>
												<option value="<?php echo strtoupper($row_Kec['kecamatan']) ?>">
													<?php echo strtoupper($row_Kec['kecamatan']) ?>
												</option>

												<?php
											}
											?>
										</select>
									</div>

									<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
									<script>
										$(document).ready(function(){
											$('#dapil').on('change',function(){
											var dapil = $(this).val();
												if(dapil){
													$.ajax({
														type:'POST',
														url:'load-kec-ptps.php',
														data: {
															dapil : dapil
														},
														success:function(html){
															$('#kecamatan').html(html);
														}
													});

												}else{
													$('#kecamatan').html('<option></option>');
												}
											});
										});
									</script>

									<div class="form-group">
										<label>Kelurahan</label>
										<input type="text" name="vKelurahan" class="form-control"
											value="<?php echo $Kelurahan ?>" />
									</div>

									<div class="form-group">
										<label>Nomor TPS</label>
										<input type="text" name="vNoTPS" class="form-control"
											value="<?php echo $NomorTPS ?>" />
									</div>

									<div class="form-group">
										<label>Nomor KTP</label>
										<input type="text" name="vNoKTP" class="form-control"
											value="<?php echo $NomorKTP ?>" />
									</div>

									<div class="form-group">
										<label>Nama</label>
										<input type="text" name="vNama" class="form-control"
											value="<?php echo $Nama ?>" />
									</div>
								</div>
								<div class="modal-footer">
									<button name="update-ptps" type="submit" class="btn btn-primary">Simpan</button>
									<a type="button" class="btn btn-secondary" href="master-ptps.php">Kembali</a>

								</div>
							</form>
						</div>
					</div>

				</div>
			</div>
	</section>

</main>

<?php

require_once('footer.php');

?>