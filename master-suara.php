<?php

session_start();

if (!isset($_SESSION['username']) && (!isset($_SESSION['password']))) {

    header('location:login.php');
}

$_SESSION['nav'] = "master-suara";
$_SESSION['nav-page'] = $_GET['nav-page'];
$KecamatanPage = $_GET['nav-page'];

if ($KecamatanPage == "") {
	$KecamatanPage = $_SESSION['nav-page'];
}

// echo "before : " . $KecamatanPage;

require_once('header.php');

require_once('navbar.php');

require_once('sidebar.php');

require_once('koneksi.php');

?>

<main id="main" class="main">

	<div class="pagetitle">
		<h1>Dashboard Master Suara : <?= $KecamatanPage ?></h1>
	</div>

	<hr/>

	<section class="section">
	<div class="row">
		<div class="col-lg-12">

		<div class="card">
			<div class="card-body">

			<div class="d-flex justify-content-between align-items-center">
				<div class="col-sm-6 mb-6 mb-sm-0">
					<h5 class="card-title">Tabel Riwayat Pengisian Suara</h5>
				</div>
				<!-- <div class="col-sm-3 mb-3 mb-sm-0">
					<form action="master-suara.php?nav-page=<?=$KecamatanPage?>">
						<div class="input-group mt-3">
							<input type="text" class="form-control" placeholder="Search ..." aria-describedby="button-addon2" name="cari">
						</div>
					</form>
				</div> -->
			</div>
			
			<hr/>

			<table class="table table-hover">
				<thead>
					<tr>
						<th scope="col">No</th>
						<th scope="col">Nama Kecamatan</th>
						<th scope="col">Nama Kelurahan</th>
						<th scope="col">Nomor TPS</th>
						<th scope="col">Inputor</th>
						<th scope="col">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php

					$page = (isset($_GET['page'])) ? $_GET['page'] : 1;

					$limit = 10; // Jumlah data per halamannya

					// Untuk menentukan dari data ke berapa yang akan ditampilkan pada tabel yang ada di database
					$limit_start = ($page - 1) * $limit;

					$No = $limit_start + 1;

					$cari = "";

					if (isset($_GET['cari'])) {
						$cari = $_GET['cari'];

						if ($cari == "") {
							$q = "SELECT id, kecamatan, kelurahan, no_tps, no_ktp FROM db_ptps WHERE kecamatan = '$KecamatanPage' ORDER BY id ASC LIMIT $limit_start, $limit";
							$sql = mysqli_query($conn, $q);
						} else {
							$q = "SELECT id, kecamatan, kelurahan, no_tps, no_ktp FROM db_ptps WHERE kecamatan = '$KecamatanPage' AND (kelurahan LIKE '%" . $cari . "%' OR no_ktp LIKE '%" . $cari . "%') ORDER BY id ASC LIMIT $limit_start, $limit";
							$sql = mysqli_query($conn, $q);
						}
					} else {
						$q = "SELECT id, kecamatan, kelurahan, no_tps, no_ktp FROM db_ptps WHERE kecamatan = '$KecamatanPage' ORDER BY id ASC LIMIT $limit_start, $limit";
						$sql = mysqli_query($conn, $q);
					}

					// echo $q;

					while ($row = mysqli_fetch_assoc($sql)) {

						$Id = $row['id'];
						$Kecamatan = strtoupper($row['kecamatan']);
						$Kelurahan = strtoupper($row['kelurahan']);
						$NomorTPS = $row['no_tps'];
						$NomorKTP = $row['no_ktp'];

						echo "
						<tr>
							<td>$No</td>
							<td>$Kecamatan</td>
							<td>$Kelurahan</td>
							<td>$NomorTPS</td>
							<td>$NomorKTP</td>
							<td>
								<a href='master-suara-detail.php?id=$Id&nav=master-suara&nav-page=$Kecamatan&kel=$Kelurahan'><span class='badge rounded-pill text-bg-info'>Lihat Suara</span></a>
							</td>
						</tr>
						";

						$No++;
					}
					?>
				</tbody>
			</table>

			<?php
			
			$q = "SELECT COUNT(*) AS cnt FROM db_ptps WHERE kecamatan = '$KecamatanPage' AND (kelurahan LIKE '%" . $cari . "%' OR no_ktp LIKE '%" . $cari . "%') ORDER BY id ASC";
			$sql = mysqli_query($conn, $q);
			$row = mysqli_fetch_assoc($sql);
			$total_data = $row['cnt'];
			
			?>

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
						echo "<li class='page-item'><a class='page-link' href='master-suara.php?page=1&nav-page=$KecamatanPage&cari=$cari'>First</a></li>";
						echo "<li class='page-item'><a class='page-link' href='master-suara.php?page=$link_prev&nav-page=$KecamatanPage&cari=$cari'>&laquo;</a></li>";
					}

					if (isset($_GET['cari'])) {
						$cari = $_GET['cari'];

						if ($cari == "") {
							$q = "SELECT COUNT(1) AS cnt FROM db_ptps WHERE kecamatan = '$KecamatanPage'";
							$sql = mysqli_query($conn, $q);
						} else {
							$q = "SELECT COUNT(1) AS cnt FROM db_ptps WHERE kecamatan = '$KecamatanPage' AND (kelurahan LIKE '%" . $cari . "%' OR no_ktp LIKE '%" . $cari . "%') ORDER BY id ASC";
							$sql = mysqli_query($conn, $q);
						}
					} else {
						$q = "SELECT COUNT(1) AS cnt FROM db_ptps WHERE kecamatan = '$KecamatanPage'";
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

						echo "<li$link_active><a class='page-link' href='master-suara.php?page=$i&nav-page=$KecamatanPage&cari=$cari'>$i</a></li>";
					}

					// LINK NEXT AND LAST

					// Jika page sama dengan jumlah page, maka disable link NEXT nya
					// Artinya page tersebut adalah page terakhir 
					if ($page == $jumlah_page) { // Jika page terakhir
						echo "<li class='page-item disbled'><a class='page-link' href='#'>&raquo;</a></li>";
						echo "<li class='page-item disbled'><a class='page-link' href='#'>Last</a></li>";
					} else { // Jika Bukan page terakhir
						$link_next = ($page < $jumlah_page) ? $page + 1 : $jumlah_page;

						echo "<li class='page-item'><a class='page-link' href='master-suara.php?page=$link_next&nav-page=$KecamatanPage&cari=$cari'>&raquo;</a></li>";
						echo "<li class='page-item'><a class='page-link' href='master-suara.php?page=$jumlah_page&nav-page=$KecamatanPage&cari=$cari'>Last</a></li>";
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