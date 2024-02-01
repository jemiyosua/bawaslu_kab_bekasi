<?php

require_once('koneksi.php');

session_start();

if (!isset($_SESSION['username']) && (!isset($_SESSION['password']))) {

	header('location:login.php');
}

$_SESSION['nav'] = "master-data";
$_SESSION['nav-page'] = "master-ptps";

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
		<h1><a href='master-ptps.php' style="text-decoration: none;"><i class="bi bi-arrow-left-circle-fill"></i></a> Dashboard Tambah PTPS</h1>
	</div>

	<hr />

	<section class="section">
		<div class="row">
			<div class="col-lg-12">

				<div class="card">
					<div class="card-body">

						<div class="d-flex justify-content-between align-items-center">
							<div class="col-sm-6 mb-6 mb-sm-0">
								<h5 class="card-title">Tambah Data PTPS</h5>
							</div>
						</div>

						<hr/>

						<div>

							<form method="POST" action="proses.php" id="submit-form-insert-ptps" onsubmit="return disableButton()">
								<div class="modal-body">

									<div class="row">

										<div class="col-sm-4 mb-4 mb-sm-0">
											<div class="mb-3">
												<label class="form-label">Kecamatan</label>
												<select class="form-select" name="kecamatan" id="kecamatan" onchange="getKelurahan()" required>
													<option value="" selected>-- Pilih Kecamatan --</option>
													<?php
													
													$sql = mysqli_query($conn, "SELECT kecamatan FROM db_master_dapil ORDER BY kecamatan ASC");
													while ($row = mysqli_fetch_assoc($sql)) {

														$Kecamatan = strtoupper($row['kecamatan']);

														?>

														<option value="<?= $Kecamatan ?>"><?= $Kecamatan ?></option>
		
														<?php
													}

													?>
												</select>
											</div>
										</div>

										<div class="col-sm-4 mb-4 mb-sm-0">
											<div class="mb-3">
												<div id="kelurahan_div"></div>
											</div>
										</div>

										<div class="col-sm-4 mb-4 mb-sm-0">
											<div class="mb-3">
												<div id="dapil_div"></div>
											</div>
										</div>

										<hr/>

										<div class="col-sm-4 mb-4 mb-sm-0" id="tps_form">
											<div class="mb-3">
												<label class="form-label">Nomor TPS</label>
												<input type="text" name="nomor_tps" id="nomor_tps" class="form-control" onchange="return validasiTPS()" onkeypress="return isNumberKey(event)" required/>
												<div style="font-weight: bold;color: red;font-size: 12px;padding-top: 5px;" id="alert_tps"></div>
												<div style="font-weight: bold;color: green;font-size: 12px;padding-top: 5px;" id="alert_tps_sukses"></div>
											</div>
										</div>

										<div class="col-sm-4 mb-4 mb-sm-0">
											<div class="mb-3">
												<label class="form-label">Nama</label>
												<input type="text" name="nama" class="form-control" required/>
											</div>
										</div>

										<div class="col-sm-4 mb-4 mb-sm-0">
											<div class="mb-3">
												<label class="form-label">Nomor KTP</label>
												<input type="text" name="nomor_ktp" class="form-control" onkeypress="return isNumberKey(event)" required/>
											</div>
										</div>

										<input type="hidden" class="form-control" name="submit-form-insert-ptps" value="submit-form-ppwp">

									</div>

									<hr/>

									<div style="font-weight: bold;color: red;font-size: 12px;padding-bottom: 5px;" id="alert_button"></div>
									<button type="submit" class="btn btn-success" id="button-submit"><i class="bi bi-check-circle-fill"></i> Submit</button>

								</div>

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

<script type="text/javascript">

function isNumberKey(evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))
	return false;
}

function disableButton() {
	var alert_tps = document.getElementById('alert_tps').innerHTML;

	if (alert_tps != "") {
		document.getElementById('alert_button').innerHTML = "Masih Terjadi Kesalahan : " + alert_tps;
		return false
	} else {
		var form = document.getElementById('submit-form-insert-ptps');

		if (form.checkValidity()) {
			document.getElementById('button-submit').disabled = true;
		}
	}

	return true
	
}

function getKelurahan() {
	var Kecamatan = document.getElementById('kecamatan').value;

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			console.log(this.responseText)
			var Response = this.responseText;
			var ResponseSplit = Response.split("//");
			var DataKelurahan = ResponseSplit[0];
			var FormDapil = ResponseSplit[1];
			document.getElementById("kelurahan_div").innerHTML = DataKelurahan;
			document.getElementById("dapil_div").innerHTML = FormDapil;
		}
	};

	var URL = 'http://localhost/bawaslu_bekasi/get-kelurahan.php?kecamatan=' + Kecamatan;
	console.log("URL : " + URL)
	xhttp.open("GET", URL, true);
	xhttp.send();
}

function validasiTPS() {
	var Kecamatan = document.getElementById('kecamatan').value;
	var Kelurahan = document.getElementById('kelurahan').value;
	var NomorTPS = document.getElementById('nomor_tps').value;

	if (NomorTPS == "") {
		document.getElementById('alert_button').innerHTML = "";
		document.getElementById("alert_tps").innerHTML = "";
		document.getElementById("alert_tps_sukses").innerHTML = "";
		return
	} else {
		if (Kecamatan == "") {
			document.getElementById("alert_tps").innerHTML = "Kecamatan tidak boleh kosong!";
			return
		} else if (Kelurahan == "") {
			document.getElementById("alert_tps").innerHTML = "Kelurahan tidak boleh kosong!";
			return
		}
	}

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			console.log(this.responseText)
			var Response = this.responseText;

			if (Response == "0") {
				document.getElementById("alert_tps").innerHTML = "";
				document.getElementById("alert_tps_sukses").innerHTML = "Nomor TPS Dapat Digunakan!";
			} else {
				document.getElementById("alert_tps").innerHTML = "Nomor TPS Sudah Digunakan!";
				document.getElementById("alert_tps_sukses").innerHTML = "";
			}
		}
	};

	var URL = 'http://localhost/bawaslu_bekasi/validasi-tps.php?kecamatan=' + Kecamatan + '&kelurahan=' + Kelurahan + '&nomor_tps=' + NomorTPS;
	console.log("URL : " + URL)
	xhttp.open("GET", URL, true);
	xhttp.send();
}

</script>