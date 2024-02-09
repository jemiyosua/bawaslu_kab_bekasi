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

	$pilNoTPS = '';
	$pilNoKTP = '';
	$pilNama = '';
	$pilKecamatan = '';
	$id = '';
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
	}
	$proses = $_GET['ptps'];
	$judul = 'Tambah ';

	if ($proses== 'update'){
		$judul = 'Update ';
		$sql = mysqli_query($conn, 'SELECT * FROM db_ptps WHERE id = ' .$id);
		$row = mysqli_fetch_assoc($sql);

		$pilKecamatan = strtoupper($row['kecamatan']);
		$pilKelurahan = strtoupper($row['kelurahan']);
		$pilNoTPS = $row['no_tps'];
		$pilNoKTP = $row['no_ktp'];
		$pilNama = strtoupper($row['nama']);
		$pilDapil = $row['dapil_kab'];
	}
	?>

	<div class="pagetitle">
		<h1><a href='master-ptps.php' style="text-decoration: none;"><i class="bi bi-arrow-left-circle-fill"></i></a> Dashboard <?=$judul?> PTPS</h1>
	</div>

	<hr />

	<section class="section">
		<div class="row">
			<div class="col-lg-12">

				<div class="card">
					<div class="card-body">

						<div class="d-flex justify-content-between align-items-center">
							<div class="col-sm-6 mb-6 mb-sm-0">
								<h5 class="card-title"><?=$judul?> Data PTPS</h5>
								<input type="text" name="proses" id="proses" value= '<?= $proses?>' hidden></input>
							</div>
						</div>

						<hr/>

						<div>
							<input id="pilKelurahan" value = '<?= $pilKelurahan?>' hidden></input>

							<form method="POST" action="proses.php" id="submit-form-<?=$proses?>-ptps" onsubmit="return disableButton()">
							 <input type="text" name="id" id="id" value= '<?= $id?>' hidden></input>
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

														<option value="<?= $Kecamatan ?>" <?php if( $Kecamatan == $pilKecamatan ) echo 'selected'?>><?= $Kecamatan ?></option>
		
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
												<input type="text" name="nomor_tps" id="nomor_tps" class="form-control" onchange="return validasiTPS()" onkeypress="return isNumberKey(event)" value = '<?php echo $pilNoTPS?>' required/>
												<div style="font-weight: bold;color: red;font-size: 12px;padding-top: 5px;" id="alert_tps"></div>
												<div style="font-weight: bold;color: green;font-size: 12px;padding-top: 5px;" id="alert_tps_sukses"></div>
											</div>
										</div>

										<div class="col-sm-4 mb-4 mb-sm-0">
											<div class="mb-3">
												<label class="form-label">Nama</label>
												<input type="text" name="nama" class="form-control" value = '<?php echo $pilNama?>' required/>
											</div>
										</div>

										<div class="col-sm-4 mb-4 mb-sm-0">
											<div class="mb-3">
												<label class="form-label">Nomor KTP</label>
												<input type="text" name="nomor_ktp" id="nomor_ktp" class="form-control" onchange="return validasiKTP()" onkeypress="return isNumberKey(event)" value = '<?php echo $pilNoKTP?>' required/>
												<div style="font-weight: bold;color: red;font-size: 12px;padding-top: 5px;" id="alert_ktp"></div>
												<div style="font-weight: bold;color: green;font-size: 12px;padding-top: 5px;" id="alert_ktp_sukses"></div>
											</div>
										</div>

										<input type="hidden" class="form-control" name="submit-form-<?=$proses?>-ptps" value="submit-form-ppwp">

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

mysqli_close($conn);

?>

<script type="text/javascript">

window.addEventListener("load",function() {
    getKelurahan();
},false);

function isNumberKey(evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))
	return false;
}

function disableButton() {
	var alert_tps = document.getElementById('alert_tps').innerHTML;
	var alert_ktp = document.getElementById('alert_ktp').innerHTML;
	var alert = "";

	if (alert_tps != "") {
		alert = alert + "Masih Terjadi Kesalahan : " + alert_tps;
	}

	if (alert_ktp != "") {
		if (alert.length > 0) {
			alert= alert + " " + alert_ktp;
		} else {
			alert= alert + "Masih Terjadi Kesalahan : " + alert_ktp;
		} 
	}

	if (alert != "") {
		document.getElementById('alert_button').innerHTML = alert;
		return false
	} else {
		var form;
		var proses =  document.getElementById('proses').value;
		if(proses == 'insert'){
			var form = document.getElementById('submit-form-insert-ptps');
		} else if (proses == 'update'){
			var form = document.getElementById('submit-form-update-ptps');
		}
    
		if (form.checkValidity()) {
			document.getElementById('button-submit').disabled = true;
		}
	}

	return true
	
}

function getKelurahan() {
	var Kecamatan = document.getElementById('kecamatan').value;
	var pilKelurahan = document.getElementById('pilKelurahan').value;
	var addParam = "";

	if(Kecamatan == "") {
		return
	}

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

	var URL = 'https://bawaslukabbekasi.com/get-kelurahan.php?kecamatan=' + Kecamatan + '&kelurahan=' + pilKelurahan;

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
  
	var URL = 'https://bawaslukabbekasi.com/validasi-tps.php?kecamatan=' + Kecamatan + '&kelurahan=' + Kelurahan + '&nomor_tps=' + NomorTPS;

	console.log("URL : " + URL)
	xhttp.open("GET", URL, true);
	xhttp.send();
}

function validasiKTP() {	
	var NomorKTP = document.getElementById('nomor_ktp').value; 

	if (NomorKTP == "") {
		document.getElementById('alert_button').innerHTML = "";
		document.getElementById("alert_ktp").innerHTML = "";
		document.getElementById("alert_ktp_sukses").innerHTML = "";
		return
	} else {
		if (NomorKTP.charAt(0) == "0") {
			document.getElementById("alert_ktp").innerHTML = "Digit Pertama Nomor KTP tidak boleh 0 (Nol)!";
			return
		} 
		if (NomorKTP.length > 16 || NomorKTP.length < 16) {
			document.getElementById("alert_ktp").innerHTML = "Nomor KTP Terdiri Dari 16 Digit!";
			return
		} 
	}

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			console.log(this.responseText)
			var Response = this.responseText;

			if (Response == "0") {
				document.getElementById("alert_ktp").innerHTML = "";
				document.getElementById("alert_ktp_sukses").innerHTML = "Nomor KTP Dapat Digunakan!";
			} else {
				document.getElementById("alert_ktp").innerHTML = "Nomor KTP Sudah Digunakan!";
				document.getElementById("alert_ktp_sukses").innerHTML = "";
			}
		}
	};

	var URL = 'https://bawaslukabbekasi.com/validasi-ktp.php?nomor_ktp=' + NomorKTP ;
	console.log("URL : " + URL)
	xhttp.open("GET", URL, true);
	xhttp.send();

}

function clearNoTPS() {
	document.getElementById("nomor_tps").value = '';

	console.log('123');

}
  
</script>