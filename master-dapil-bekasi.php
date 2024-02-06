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

$Dapil = isset($_GET['id']) ? $_GET['id'] : '';
$ParamKodePartai = isset($_GET['cari_kode_partai']) ? $_GET['cari_kode_partai'] : '';
$ParamNoUrut = isset($_GET['cari_no_urut']) ? $_GET['cari_no_urut'] : '';
$ParamNamaCalon = isset($_GET['cari_nama_calon']) ? $_GET['cari_nama_calon'] : '';
$ParamJenisKelamin = isset($_GET['cari_jenis_kelamin']) ? $_GET['cari_jenis_kelamin'] : '';
$ParamStatus = isset($_GET['cari_status']) ? $_GET['cari_status'] : '';

?>

<main id="main" class="main">

	<div class="pagetitle">
	<h1><a href="master-dprd-kab.php"><i class="bi bi-arrow-left-circle-fill"></i></a> Dashboard Master DPRD - KABUPDATEN (Dapil <?= $Dapil ?>)</h1>
	</div>

    <hr/>

	<section class="section">
	<div class="row">
		<div class="col-lg-12">

		<div class="card">
			<div class="card-body">

			<div class="d-flex justify-content-between align-items-center">
				<div class="col-sm-6 mb-6 mb-sm-0">
					<h5 class="card-title">Master DPRD - KABUPDATEN (Dapil <?= $Dapil ?>)</h5>
				</div>
			</div>
			
			<hr/>

			<table class="table table-hover">
				<thead>
					<tr>
						<th scope="col"> <a class="btn btn-outline-secondary" href="master-dapil-bekasi.php?id=<?= $Dapil ?>"><i
									class="bi bi-arrow-clockwise"></i></a></th>
						<form>
							<input type="text" class="form-control" aria-describedby="button-addon2"
									name="id" value="<?= $Dapil ?>" hidden>
							<th scope="col"></th>

							<th scope="col"><input type="text" class="form-control"
									placeholder="Kode Partai..." aria-describedby="button-addon2"
									name="cari_kode_partai" value="<?= $ParamKodePartai ?>"></th>

							<th scope="col"><input type="text" class="form-control"
									placeholder="Nomor Urut..." aria-describedby="button-addon2"
									name="cari_no_urut" value="<?= $ParamNoUrut ?>"></th>

							<th scope="col"><input type="text" class="form-control"
									placeholder="Nama..." aria-describedby="button-addon2"
									name="cari_nama_calon" value="<?= $ParamNamaCalon ?>"></th>

							<th scope="col"><input type="text" class="form-control"
									placeholder="Jenis Kelamin..." aria-describedby="button-addon2"
									name="cari_jenis_kelamin" value="<?= $ParamJenisKelamin ?>"></th>

							<th scope="col"></th>
						
							<th scope="col">
								<select type="text" class="form-select" aria-describedby="button-addon2"
									name="cari_status" value="<?= $ParamStatus ?>" onchange="this.form.submit()"> 
									<option value='' <?php if ($ParamStatus == '') { echo 'selected';}  else {echo '';}?>>-- Pilih Status --</option>
									<option value ='1' <?php if ($ParamStatus == '1') { echo 'selected';}  else {echo '';}?>>Aktif</option>
									<option value ='0' <?php if ($ParamStatus == '0') { echo 'selected';}  else {echo '';}?>>Non-Aktif</option>
								</select>
							</th>

							<button type="submit" style="display: none;"></button>
						</form>

						<th scope="col"></th>
					</tr>
					<tr>
						<th scope="col">No</th>
						<th scope="col">Kategori Calon Pilihan</th>
						<th scope="col">Kode Partai</th>
						<th scope="col">Nomor Urut</th>
						<th scope="col">Nama Calon Pilihan</th>
						<th scope="col">Jenis Kelamin</th>
						<th scope="col">Daerah Pilihan</th>
						<th scope="col">Status</th>
					</tr>
				</thead>
				<tbody>
					<?php

					$page = (isset($_GET['page'])) ? $_GET['page'] : 1;

					$limit = 10; // Jumlah data per halamannya

					// Untuk menentukan dari data ke berapa yang akan ditampilkan pada tabel yang ada di database
					$limit_start = ($page - 1) * $limit;

					$No = $limit_start + 1;

					
					$q = "SELECT id, kategori_capil, kode_partai, no_urut, nama_capil, jenis_kelamin, dapil, status FROM db_master_capil 
						WHERE kategori_capil = 'DPRD-KAB' 
						AND dapil = '$Dapil' 
						AND (kode_partai LIKE '%$ParamKodePartai%'  OR '' = '$ParamKodePartai')
						AND (no_urut LIKE '%$ParamNoUrut%'  OR '' = '$ParamNoUrut')
						AND (nama_capil LIKE '%$ParamNamaCalon%'  OR '' = '$ParamNamaCalon') 
						AND (jenis_kelamin LIKE '%$ParamJenisKelamin%'  OR '' = '$ParamJenisKelamin')
						AND (status LIKE '%$ParamStatus%'  OR '' = '$ParamStatus')
						ORDER BY id ASC LIMIT $limit_start, $limit";
					$sql = mysqli_query($conn, $q);

					$q2 = "SELECT COUNT(1) AS cnt FROM db_master_capil 
						WHERE kategori_capil = 'DPRD-KAB' 
						AND dapil = '$Dapil' 
						AND (kode_partai LIKE '%$ParamKodePartai%'  OR '' = '$ParamKodePartai')
						AND (no_urut LIKE '%$ParamNoUrut%'  OR '' = '$ParamNoUrut')
						AND (nama_capil LIKE '%$ParamNamaCalon%'  OR '' = '$ParamNamaCalon') 
						AND (jenis_kelamin LIKE '%$ParamJenisKelamin%'  OR '' = '$ParamJenisKelamin')
						AND (status LIKE '%$ParamStatus%'  OR '' = '$ParamStatus')";
					$sql2 = mysqli_query($conn, $q2);
					$row2 = mysqli_fetch_assoc($sql2);
					$total_data = $row2['cnt'];

					if ( $total_data > 0 ) {

						while ($row = mysqli_fetch_assoc($sql)) {

							$Id = $row['id'];
							$KategoriCapil = $row['kategori_capil'];
							$KodePartai = $row['kode_partai'];
							$NomorUrut = $row['no_urut'];
							$NamaCapil = $row['nama_capil'];
							$JenisKelamin = $row['jenis_kelamin'];
							$Dapil = $row['dapil'];
							$Status = $row['status'];
							if ($Status == "1") {
								$vStatus = "Aktif";
							} else {
								$vStatus = "Non-Aktif";
							}

							echo "
							<tr>
								<td>$No</td>
								<td>$KategoriCapil</td>
								<td>$KodePartai</td>
								<td>$NomorUrut</td>
								<td>$NamaCapil</td>
								<td>$JenisKelamin</td>
								<td>$Dapil</td>
								<td>$vStatus</td>
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
						echo "<li class='page-item'><a class='page-link' href='master-dapil-bekasi.php?page=1&id=$Dapil&cari_kode_partai=$ParamKodePartai&cari_no_urut=$ParamNoUrut&cari_nama_calon=$ParamNamaCalon&cari_jenis_kelamin=$ParamJenisKelamin&cari_status=$ParamStatus'>First</a></li>";
						echo "<li class='page-item'><a class='page-link' href='master-dapil-bekasi.php?page=$link_prev&id=$Dapil&cari_kode_partai=$ParamKodePartai&cari_no_urut=$ParamNoUrut&cari_nama_calon=$ParamNamaCalon&cari_jenis_kelamin=$ParamJenisKelamin&cari_status=$ParamStatus'>&laquo;</a></li>";
					}

					
					$q = "SELECT COUNT(1) AS cnt FROM db_master_capil 
						WHERE kategori_capil = 'DPRD-KAB' 
						AND dapil = '$Dapil' 
						AND (kode_partai LIKE '%$ParamKodePartai%'  OR '' = '$ParamKodePartai')
						AND (no_urut LIKE '%$ParamNoUrut%'  OR '' = '$ParamNoUrut')
						AND (nama_capil LIKE '%$ParamNamaCalon%'  OR '' = '$ParamNamaCalon') 
						AND (jenis_kelamin LIKE '%$ParamJenisKelamin%'  OR '' = '$ParamJenisKelamin')
						AND (status LIKE '%$ParamStatus%'  OR '' = '$ParamStatus')";
					
					$sql = mysqli_query($conn, $q);
					$row = mysqli_fetch_assoc($sql);
					$jumlah = $row['cnt'];

					$jumlah_page = ceil($jumlah / $limit); // Hitung jumlah halamannya
					$jumlah_number = 3; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
					$start_number = ($page > $jumlah_number) ? $page - $jumlah_number : 1; // Untuk awal link number
					$end_number = ($page < ($jumlah_page - $jumlah_number)) ? $page + $jumlah_number : $jumlah_page; // Untuk akhir link number

					for ($i = $start_number; $i <= $end_number; $i++) {

						$link_active = ($page == $i) ? ' class="page-item active"' : '';

						echo "<li$link_active><a class='page-link' href='master-dapil-bekasi.php?page=$i&id=$Dapil&cari_kode_partai=$ParamKodePartai&cari_no_urut=$ParamNoUrut&cari_nama_calon=$ParamNamaCalon&cari_jenis_kelamin=$ParamJenisKelamin&cari_status=$ParamStatus'>$i</a></li>";
					}

					// LINK NEXT AND LAST

					// Jika page sama dengan jumlah page, maka disable link NEXT nya
					// Artinya page tersebut adalah page terakhir 
					if ($page == $jumlah_page) { // Jika page terakhir
						echo "<li class='page-item disbled'><a class='page-link' href='#'>&raquo;</a></li>";
						echo "<li class='page-item disbled'><a class='page-link' href='#'>Last</a></li>";
					} else { // Jika Bukan page terakhir
						$link_next = ($page < $jumlah_page) ? $page + 1 : $jumlah_page;

						echo "<li class='page-item'><a class='page-link' href='master-dapil-bekasi.php?page=$link_next&id=$Dapil&cari_kode_partai=$ParamKodePartai&cari_no_urut=$ParamNoUrut&cari_nama_calon=$ParamNamaCalon&cari_jenis_kelamin=$ParamJenisKelamin&cari_status=$ParamStatus'>&raquo;</a></li>";
						echo "<li class='page-item'><a class='page-link' href='master-dapil-bekasi.php?page=$jumlah_page&id=$Dapil&cari_kode_partai=$ParamKodePartai&cari_no_urut=$ParamNoUrut&cari_nama_calon=$ParamNamaCalon&cari_jenis_kelamin=$ParamJenisKelamin&cari_status=$ParamStatus'>Last</a></li>";
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