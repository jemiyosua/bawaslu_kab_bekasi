<?php

session_start();

if (!isset($_SESSION['username']) && (!isset($_SESSION['password']))) {

    header('location:login.php');
}

$_SESSION['nav'] = "perhitungan-suara";
$_SESSION['nav-page'] = "master-image-tps";

require_once('header.php');

require_once('navbar.php');

require_once('sidebar.php');

require_once('koneksi.php');

$ParamKecamatan = isset($_GET['cari_kecamatan']) ? $_GET['cari_kecamatan'] : '';
$ParamKelurahan = isset($_GET['cari_kelurahan']) ? $_GET['cari_kelurahan'] : '';
$ParamNoTPS = isset($_GET['cari_no_tps']) ? $_GET['cari_no_tps'] : '';
$ParamNoKTP = isset($_GET['cari_no_ktp']) ? $_GET['cari_no_ktp'] : '';
$ParamNama = isset($_GET['cari_nama']) ? $_GET['cari_nama'] : '';

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

			<table class="table table-hover mt-3">
				<thead>
					<tr>
						<th scope="col"> <a class="btn btn-outline-secondary" href="master-image-tps.php"><i class="bi bi-arrow-clockwise"></i></a></th>
						<form>
							<th scope="col"><input type="text" class="form-control" placeholder="Kecamatan..." aria-describedby="button-addon2" name="cari_kecamatan" value="<?= $ParamKecamatan ?>"></th>
							<th scope="col"><input type="text" class="form-control" placeholder="Kelurahan..." aria-describedby="button-addon2" name="cari_kelurahan" value="<?= $ParamKelurahan ?>"></th>
							<th scope="col"><input type="text" class="form-control" placeholder="Nomor TPS..." aria-describedby="button-addon2" name="cari_no_tps" value="<?= $ParamNoTPS ?>"></th>
							<th scope="col"><input type="text" class="form-control" placeholder="Nomor KTP..." aria-describedby="button-addon2" name="cari_no_ktp" value="<?= $ParamNoKTP ?>"></th>
							<th scope="col"><input type="text" class="form-control" placeholder="Nama..." aria-describedby="button-addon2" name="cari_nama" value="<?= $ParamNama ?>"></th>
							<th scope="col"></th>
							<button type="submit" style="display: none;"></button>
						</form>
						<th scope="col"></th>
					</tr>
					<tr>
						<th scope="col">No</th>
						<th scope="col">Kecamatan</th>
						<th scope="col">Kelurahan</th>
						<th scope="col">Nomor TPS</th>
						<th scope="col">Nomor KTP</th>
						<th scope="col">Nama</th>
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
							window.location.href='master-image-tps.php';
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
							window.location.href='master-image-tps.php';
						});
						</script>";
						unset($_SESSION['pesanError']);
					}

					$page = (isset($_GET['page'])) ? $_GET['page'] : 1;

					$limit = 10; // Jumlah data per halamannya

					// Untuk menentukan dari data ke berapa yang akan ditampilkan pada tabel yang ada di database
					$limit_start = ($page - 1) * $limit;

					$No = $limit_start + 1;

					$q = "SELECT id, kecamatan, kelurahan, no_tps, no_ktp, nama FROM db_ptps 
						WHERE (kecamatan LIKE '%$ParamKecamatan%'  OR '' = '$ParamKecamatan')
						AND (kelurahan LIKE '%$ParamKelurahan%'  OR '' = '$ParamKelurahan')
						AND (no_tps LIKE '%$ParamNoTPS%'  OR '' = '$ParamNoTPS') 
						AND (no_ktp LIKE '%$ParamNoKTP%'  OR '' = '$ParamNoKTP')
						AND (nama LIKE '%$ParamNama%'  OR '' = '$ParamNama')
						ORDER BY no_tps ASC LIMIT $limit_start, $limit";
					$sql = mysqli_query($conn, $q);
					
					$q2 = "SELECT COUNT(1) AS cnt FROM db_ptps 
						WHERE (kecamatan LIKE '%$ParamKecamatan%'  OR '' = '$ParamKecamatan')
						AND (kelurahan LIKE '%$ParamKelurahan%'  OR '' = '$ParamKelurahan')
						AND (no_tps LIKE '%$ParamNoTPS%'  OR '' = '$ParamNoTPS') 
						AND (no_ktp LIKE '%$ParamNoKTP%'  OR '' = '$ParamNoKTP')
						AND (nama LIKE '%$ParamNama%'  OR '' = '$ParamNama')";
					$sql2 = mysqli_query($conn, $q2);
					$row2 = mysqli_fetch_assoc($sql2);
					$total_data = $row2['cnt'];

					if ( $total_data > 0 ) {
						while ($row = mysqli_fetch_assoc($sql)) {

							$Id = $row['id'];
							$Kecamatan = strtoupper($row['kecamatan']);
							$Kelurahan = strtoupper($row['kelurahan']);
							$NomorTPS = $row['no_tps'];
							$NomorKTP = $row['no_ktp'];
							$Nama = strtoupper($row['nama']);

                            $q3 = "SELECT COUNT(1) AS cnt FROM db_master_image 
                                    WHERE image_id LIKE '%".$NomorKTP."%'";
                            $sql3 = mysqli_query($conn, $q3);
                            $row3 = mysqli_fetch_assoc($sql3);
                            $CountImage = $row3['cnt'];

                            if ($CountImage > 0 && ($NomorKTP != "" || $NomorKTP != "-")) {
                                $ButtonDownload = "<a class='btn btn-success' href='export-zip.php?ic=$NomorKTP'><i class='bi bi-download'></i> Download Image (.zip)</a>";
                            } else {
                                $ButtonDownload = "<span class='badge rounded-pill text-bg-danger'>Image Belum Tersedia</span>";
                            }

							echo "
							<tr>
								<td>$No</td>
								<td>$Kecamatan</td>
								<td>$Kelurahan</td>
								<td>$NomorTPS</td>
								<td>$NomorKTP</td>
								<td>$Nama</td>
								<td style='padding-right:0;margin-right:0;'>$ButtonDownload</td>
							</tr>
							";

							$No++;
						}
					} else {
						?>
							<tr>
								<td colspan="12">
									<div class="alert alert-danger" role="alert" style="text-align: center;font-weight: bold;">Data Tidak Ditemukan !</div>
								</td>
							</tr>
						<?php
					}

					?>
					
				</tbody>
			</table>

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
						echo "<li class='page-item'><a class='page-link' href='master-image-tps.php?page=1&cari_kecamatan=$ParamKecamatan&cari_kelurahan=$ParamKelurahan&cari_no_tps=$ParamNoTPS&cari_no_ktp=$ParamNoKTP&cari_nama=$ParamNama'>First</a></li>";
						echo "<li class='page-item'><a class='page-link' href='master-image-tps.php?page=$link_prev&cari_kecamatan=$ParamKecamatan&cari_kelurahan=$ParamKelurahan&cari_no_tps=$ParamNoTPS&cari_no_ktp=$ParamNoKTP&cari_nama=$ParamNama'>&laquo;</a></li>";
					}

					
					$q = "SELECT COUNT(1) AS cnt FROM db_ptps 
                            WHERE (kecamatan LIKE '%$ParamKecamatan%'  OR '' = '$ParamKecamatan')
                            AND (kelurahan LIKE '%$ParamKelurahan%'  OR '' = '$ParamKelurahan')
                            AND (no_tps LIKE '%$ParamNoTPS%'  OR '' = '$ParamNoTPS') 
                            AND (no_ktp LIKE '%$ParamNoKTP%'  OR '' = '$ParamNoKTP')
                            AND (nama LIKE '%$ParamNama%'  OR '' = '$ParamNama') ";
					$sql = mysqli_query($conn, $q);
					$row = mysqli_fetch_assoc($sql);
					$jumlah = $row['cnt'];

					$jumlah_page = ceil($jumlah / $limit); // Hitung jumlah halamannya
					$jumlah_number = 3; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
					$start_number = ($page > $jumlah_number) ? $page - $jumlah_number : 1; // Untuk awal link number
					$end_number = ($page < ($jumlah_page - $jumlah_number)) ? $page + $jumlah_number : $jumlah_page; // Untuk akhir link number

					for ($i = $start_number; $i <= $end_number; $i++) {

						$link_active = ($page == $i) ? ' class="page-item active"' : '';

						echo "<li$link_active><a class='page-link' href='master-image-tps.php?page=$i&cari_kecamatan=$ParamKecamatan&cari_kelurahan=$ParamKelurahan&cari_no_tps=$ParamNoTPS&cari_no_ktp=$ParamNoKTP&cari_nama=$ParamNama'>$i</a></li>";
					}

					// LINK NEXT AND LAST

					// Jika page sama dengan jumlah page, maka disable link NEXT nya
					// Artinya page tersebut adalah page terakhir 
					if ($page == $jumlah_page) { // Jika page terakhir
						echo "<li class='page-item disbled'><a class='page-link' href='#'>&raquo;</a></li>";
						echo "<li class='page-item disbled'><a class='page-link' href='#'>Last</a></li>";
					} else { // Jika Bukan page terakhir
						$link_next = ($page < $jumlah_page) ? $page + 1 : $jumlah_page;

						echo "<li class='page-item'><a class='page-link' href='master-image-tps.php?page=$link_next&cari_kecamatan=$ParamKecamatan&cari_kelurahan=$ParamKelurahan&cari_no_tps=$ParamNoTPS&cari_no_ktp=$ParamNoKTP&cari_nama=$ParamNama'>&raquo;</a></li>";
						echo "<li class='page-item'><a class='page-link' href='master-image-tps.php?page=$jumlah_page&cari_kecamatan=$ParamKecamatan&cari_kelurahan=$ParamKelurahan&cari_no_tps=$ParamNoTPS&cari_no_ktp=$ParamNoKTP&cari_nama=$ParamNama'>Last</a></li>";
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

mysqli_close($conn);

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
							window.location.href='master-image-tps.php';
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