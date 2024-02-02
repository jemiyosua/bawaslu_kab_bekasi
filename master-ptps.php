<?php

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

	<div class="pagetitle">
	<h1>Dashboard Master PTPS</h1>
	</div>

	<hr/>

	<section class="section">
	<div class="row">
		<div class="col-lg-12">

		<div class="card">
			<div class="card-body">

			<div class="d-flex justify-content-between align-items-center">
				<div class="col-sm-6 mb-6 mb-sm-0">
					<h5 class="card-title">Master PTPS</h5>
				</div>
				<div class="col-sm-3 mb-3 mb-sm-0">
					<form>
						<div class="input-group mt-3">
							<input type="text" class="form-control" placeholder="Search ..." aria-describedby="button-addon2" name="cari">
						</div>
					</form>
				</div>
			</div>

			<hr/>

			<table class="table table-hover">
				<thead>
					<tr>
						<th scope="col">No</th>
						<th scope="col">Kecamatan</th>
						<th scope="col">Kelurahan</th>
						<th scope="col">Nomor TPS</th>
						<th scope="col">Nomor KTP</th>
						<th scope="col">Nama</th>
						<th scope="col">Daerah Pilihan</th>
						<th scope="col">Action</th>
					</tr>
				</thead>
				<tbody>
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
					<?php

					$page = (isset($_GET['page'])) ? $_GET['page'] : 1;

					$limit = 10; // Jumlah data per halamannya

					// Untuk menentukan dari data ke berapa yang akan ditampilkan pada tabel yang ada di database
					$limit_start = ($page - 1) * $limit;

					$No = $limit_start + 1;
					$cari ='';

					if (isset($_GET['cari'])) {
						$cari = $_GET['cari'];

						if ($cari == "") {
							$q = "SELECT id, kecamatan, kelurahan, no_tps, no_ktp, nama, dapil_kab FROM db_ptps ORDER BY id ASC LIMIT $limit_start, $limit";
							$sql = mysqli_query($conn, $q);
						} else {
							$q = "SELECT id, kecamatan, kelurahan, no_tps, no_ktp, nama, dapil_kab FROM db_ptps WHERE kecamatan LIKE '%" . $cari . "%' OR kelurahan LIKE '%" . $cari . "%' OR no_ktp LIKE '%" . $cari . "%' OR nama LIKE '%" . $cari . "%' OR concat('BEKASI ',dapil_kab) LIKE '%" . $cari . "%' ORDER BY id ASC LIMIT $limit_start, $limit";
							$sql = mysqli_query($conn, $q);
						}
					} else {
						$q = "SELECT id, kecamatan, kelurahan, no_tps, no_ktp, nama, dapil_kab FROM db_ptps ORDER BY id ASC LIMIT $limit_start, $limit";
						$sql = mysqli_query($conn, $q);
					}

					while ($row = mysqli_fetch_assoc($sql)) {

						$Id = $row['id'];
						$Kecamatan = strtoupper($row['kecamatan']);
						$Kelurahan = strtoupper($row['kelurahan']);
						$NomorTPS = $row['no_tps'];
						$NomorKTP = $row['no_ktp'];
						$Nama = strtoupper($row['nama']);
						$Dapil = $row['dapil_kab'];
						$vDapil = 'BEKASI ' . $row['dapil_kab'];

						echo "
						<tr>
							<td>$No</td>
							<td>$Kecamatan</td>
							<td>$Kelurahan</td>
							<td>$NomorTPS</td>
							<td>$NomorKTP</td>
							<td>$Nama</td>
							<td>$vDapil</td>
							<td style='padding-right:0;margin-right:0;'>
								<a class='btn btn-warning' href='form-master-ptps.php?ptps=update&id=$Id'> <i class='bi bi-pencil-square'></i></a>
								<button class='btn btn-danger' onclick='fnDeleteRow($Id)'><i class='bi bi-trash-fill'></i></button> 
							</td>
						</tr>
						";

						$No++;
					}
					?>
					
				</tbody>
			</table>

			<?php
			
			$q = "SELECT COUNT(1) AS cnt FROM db_ptps WHERE kecamatan LIKE '%" . $cari . "%' OR kelurahan LIKE '%" . $cari . "%' OR no_ktp LIKE '%" . $cari . "%' OR nama LIKE '%" . $cari . "%' OR concat('BEKASI ',dapil_kab) LIKE '%" . $cari . "%' ORDER BY id ASC";
			$sql = mysqli_query($conn, $q);
			$row = mysqli_fetch_assoc($sql);
			$total_data = $row['cnt'];
			
			?>

			<a class='btn btn-success' href='form-master-ptps.php?ptps=insert'> <i class='bi bi-plus-square'> Tambah PTPS</i></a>

			<div style="font-weight: bold;color:red">Total Data : <?= $total_data ?></div>

			<nav aria-label="Page navigation example" style="padding-top: 15px;">
				<ul class="pagination">
					<!-- LINK FIRST AND PREV -->
					<?php

					if ($page == 1) { // Jika page adalah page ke 1, maka disable link PREV
						echo "<li class='page-item disbled'><a class='page-link' href='#'>First</a></li>";
						echo "<li class='page-item disbled'><a class='page-link' href='#'>&laquo;</a></li>";
					} else { // Jika page bukan page ke 1
						$link_prev = ($page > 1) ? $page - 1 : 1;
						echo "<li class='page-item'><a class='page-link' href='master-ptps.php?page=1'>First</a></li>";
						echo "<li class='page-item'><a class='page-link' href='master-ptps.php?page=$link_prev&cari=$cari'>&laquo;</a></li>";
					}

					if (isset($_GET['cari'])) {
						$cari = $_GET['cari'];

						if ($cari == "") {
							$q = "SELECT COUNT(1) AS cnt FROM db_ptps";
							$sql = mysqli_query($conn, $q);
						} else {
							$q = "SELECT COUNT(1) AS cnt FROM db_ptps WHERE kecamatan LIKE '%" . $cari . "%' OR kelurahan LIKE '%" . $cari . "%' OR no_ktp LIKE '%" . $cari . "%' OR nama LIKE '%" . $cari . "%' OR concat('BEKASI ',dapil_kab) LIKE '%" . $cari . "%' ORDER BY id ASC";
							$sql = mysqli_query($conn, $q);
						}
					} else {
						$q = "SELECT COUNT(1) AS cnt FROM db_ptps";
						$sql = mysqli_query($conn, $q);
					}
					$sql = mysqli_query($conn, $q);
					$row = mysqli_fetch_assoc($sql);
					$jumlah = $row['cnt'];

					$jumlah_page = ceil($jumlah / $limit); // Hitung jumlah halamannya
					$jumlah_number = 3; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
					$start_number = ($page > $jumlah_number) ? $page - $jumlah_number : 1; // Untuk awal link number
					$end_number = ($page < ($jumlah_page - $jumlah_number)) ? $page + $jumlah_number : $jumlah_page; // Untuk akhir link number

					for ($i = $start_number; $i <= $end_number; $i++) {

						$link_active = ($page == $i) ? ' class="page-item active"' : '';

						echo "<li$link_active><a class='page-link' href='master-ptps.php?page=$i&cari=$cari'>$i</a></li>";
					}

					// LINK NEXT AND LAST

					// Jika page sama dengan jumlah page, maka disable link NEXT nya
					// Artinya page tersebut adalah page terakhir 
					if ($page == $jumlah_page) { // Jika page terakhir
						echo "<li class='page-item disbled'><a class='page-link' href='#'>&raquo;</a></li>";
						echo "<li class='page-item disbled'><a class='page-link' href='#'>Last</a></li>";
					} else { // Jika Bukan page terakhir
						$link_next = ($page < $jumlah_page) ? $page + 1 : $jumlah_page;

						echo "<li class='page-item'><a class='page-link' href='master-ptps.php?page=$link_next&cari=$cari'>&raquo;</a></li>";
						echo "<li class='page-item'><a class='page-link' href='master-ptps.php?page=$jumlah_page&cari=$cari'>Last</a></li>";
					}

					?>
				</ul>
			</nav>

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
	function fnDeleteRow(id){
		Swal.fire({
			title: 'Yakin menghapus?',
			text: "Data yang sudah dihapus tidak dapat dikembalikan!",
			icon: 'warning',
			showCancelButton: true,
			cancelButtonText: 'Batal',
			confirmButtonText: 'Ya, hapus sekarang!'
		}).then((result) => {
			if (result.value) {
				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						console.log(this.responseText)
						var Response = this.responseText;
						if(Response == 200) {
							Swal.fire({
								title: 'Terhapus!',
								text: 'Data berhasil dihapus.',
								icon: 'success',
								showConfirmButton: false
							});
							window.location.href='master-ptps.php';
						}else {
							Swal.fire({
								title: 'Gagal!',
								text: 'Data gagal dihapus.',
								icon: 'Sorry',
								showConfirmButton: false
							});
						}
					}
				};

				var URL = 'http://localhost/bawaslu_kab_bekasi/proses.php?delete-ptps=1&deleteID=' + id;
				console.log("URL : " + URL)
				xhttp.open("GET", URL, true);
				xhttp.send();
			} 
		})
	}
</script>