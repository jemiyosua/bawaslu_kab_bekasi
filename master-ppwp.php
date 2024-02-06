<?php

session_start();

if (!isset($_SESSION['username']) && (!isset($_SESSION['password']))) {

    header('location:login.php');
}

$_SESSION['nav'] = "master-data";
$_SESSION['nav-page'] = "master-ppwp";

require_once('header.php');

require_once('navbar.php');

require_once('sidebar.php');

require_once('koneksi.php');

$ParamNoUrut = isset($_GET['cari_no_urut']) ? $_GET['cari_no_urut'] : '';
$ParamNama = isset($_GET['cari_nama']) ? $_GET['cari_nama'] : '';
$ParamStatus = isset($_GET['cari_status']) ? $_GET['cari_status'] : '';

?>

<main id="main" class="main">

	<div class="pagetitle">
	<h1>Dashboard Master PPWP</h1>
	</div>

	<hr/>

	<section class="section">
	<div class="row">
		<div class="col-lg-12">

		<div class="card">
			<div class="card-body">

			<div class="d-flex justify-content-between align-items-center">
				<div class="col-sm-6 mb-6 mb-sm-0">
					<h5 class="card-title">Master PPWP</h5>
				</div>
			</div>

			<hr/>

			<table class="table table-hover">
				<thead>
				<tr>
					<th scope="col"> <a class="btn btn-outline-secondary" href="master-ppwp.php"><i
									class="bi bi-arrow-clockwise"></i></a></th>
						<form>
							<th scope="col"><input type="text" class="form-control"
									placeholder="Nomor Urut..." aria-describedby="button-addon2"
									name="cari_no_urut" value="<?= $ParamNoUrut ?>"></th>

							<th scope="col"><input type="text" class="form-control"
									placeholder="Nama..." aria-describedby="button-addon2"
									name="cari_nama" value="<?= $ParamNama ?>"></th>
						
							<th scope="col">
								<select type="text" class="form-select" aria-describedby="button-addon2"
									name="cari_status"  onchange="this.form.submit()"> 
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
						<th scope="col">Nomor Urut</th>
						<th scope="col">Nama</th>
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

					
					$q = "SELECT id, no_urut, nama, status FROM db_master_capres_cawapres 
						WHERE (no_urut LIKE '%$ParamNoUrut%'  OR '' = '$ParamNoUrut') 
						AND (nama LIKE '%$ParamNama%'  OR '' = '$ParamNama')
						AND (status LIKE '%$ParamStatus%'  OR '' = '$ParamStatus')
						ORDER BY no_urut ASC LIMIT $limit_start, $limit";
					$sql = mysqli_query($conn, $q);

					$q2 = "SELECT COUNT(1) AS cnt FROM db_master_capres_cawapres 
						WHERE (no_urut LIKE '%$ParamNoUrut%'  OR '' = '$ParamNoUrut') 
						AND (nama LIKE '%$ParamNama%'  OR '' = '$ParamNama')
						AND (status LIKE '%$ParamStatus%'  OR '' = '$ParamStatus')";
					$sql2 = mysqli_query($conn, $q2);
					$row2 = mysqli_fetch_array($sql2);
					$total_data = $row2['cnt'];
					
	                if ( $total_data > 0 ) {
						while ($row = mysqli_fetch_assoc($sql)) {

							$Id = $row['id'];
							$NomorUrut = $row['no_urut'];
							$Nama = $row['nama'];
							$Status = $row['status'];
							if ($Status == "1") {
								$vStatus = "Aktif";
							} else {
								$vStatus = "Non-Aktif";
							}

							echo "
							<tr>
								<td>$No</td>
								<td>$NomorUrut</td>
								<td>$Nama</td>
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
						echo "<li class='page-item'><a class='page-link' href='master-ppwp.php?page=1&cari_no_urut=$ParamNoUrut&cari_nama=$ParamNama&cari_status=$ParamStatus'>First</a></li>";
						echo "<li class='page-item'><a class='page-link' href='master-ppwp.php?page=$link_prev&cari_no_urut=$ParamNoUrut&cari_nama=$ParamNama&cari_status=$ParamStatus'>&laquo;</a></li>";
					}

					
					$q = "SELECT COUNT(1) AS cnt FROM db_master_capres_cawapres 
						WHERE (no_urut LIKE '%$ParamNoUrut%'  OR '' = '$ParamNoUrut') 
						AND (nama LIKE '%$ParamNama%'  OR '' = '$ParamNama')
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

						echo "<li$link_active><a class='page-link' href='master-ppwp.php?page=$i&cari_no_urut=$ParamNoUrut&cari_nama=$ParamNama&cari_status=$ParamStatus'>$i</a></li>";
					}

					// LINK NEXT AND LAST

					// Jika page sama dengan jumlah page, maka disable link NEXT nya
					// Artinya page tersebut adalah page terakhir 
					if ($page == $jumlah_page) { // Jika page terakhir
						echo "<li class='page-item disbled'><a class='page-link' href='#'>&raquo;</a></li>";
						echo "<li class='page-item disbled'><a class='page-link' href='#'>Last</a></li>";
					} else { // Jika Bukan page terakhir
						$link_next = ($page < $jumlah_page) ? $page + 1 : $jumlah_page;

						echo "<li class='page-item'><a class='page-link' href='master-ppwp.php?page=$link_next&cari_no_urut=$ParamNoUrut&cari_nama=$ParamNama&cari_status=$ParamStatus'>&raquo;</a></li>";
						echo "<li class='page-item'><a class='page-link' href='master-ppwp.php?page=$jumlah_page&cari_no_urut=$ParamNoUrut&cari_nama=$ParamNama&cari_status=$ParamStatus'>Last</a></li>";
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