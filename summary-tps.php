<?php

session_start();

if (!isset($_SESSION['username']) && (!isset($_SESSION['password']))) {

    header('location:login.php');
}

$_SESSION['nav'] = "perhitungan-suara";
$_SESSION['nav-page'] = "summary-tps";

require_once('header.php');

require_once('navbar.php');

require_once('sidebar.php');

require_once('koneksi.php');

$ParamKecamatan = isset($_GET['it_cari_kec']) ? $_GET['it_cari_kec'] : '';
$ParamKelurahan = isset($_GET['it_cari_kel']) ? $_GET['it_cari_kel'] : '';
$ParamTps = isset($_GET['it_cari_no_tps']) ? $_GET['it_cari_no_tps'] : '';
$ParamKategoriCapil = isset($_GET['it_cari_kat_capil']) ? $_GET['it_cari_kat_capil'] : '';

?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Rekap Pemilih Per-TPS</h1>
    </div>

    <hr />

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <div class="col-sm-3 mb-3 mb-sm-2 m-2">
                            <a class="btn btn-outline-success" target="_blank" href="export-excel.php">Export Excel <i class="bi bi-file-earmark-spreadsheet"></i></a>
                        </div>

                        <hr />

                        <table class="table table-hover table-striped" style="display: block; overflow-x: auto;white-space: nowrap;">
                            <thead class="table-grey">
                                <tr>
                                    <th scope="col"> <a class="btn btn-outline-secondary" href="summary-tps.php"><i class="bi bi-arrow-clockwise"></i></a></th>

                                    <form>
                                        <th scope="col"><input type="text" class="form-control" placeholder="Kecamatan..." aria-describedby="button-addon2" name="it_cari_kec" value="<?= $ParamKecamatan ?>"></th>

                                        <th scope="col"><input type="text" class="form-control" placeholder="Kelurahan..." aria-describedby="button-addon2" name="it_cari_kel" value="<?= $ParamKelurahan ?>"></th>

                                        <th scope="col"><input type="text" class="form-control" placeholder="No TPS..." aria-describedby="button-addon2" name="it_cari_no_tps" value="<?= $ParamTps ?>"></th>

                                        <th scope="col"><input type="text" class="form-control" placeholder="Kategori Capil..." aria-describedby="button-addon2" name="it_cari_kat_capil" value="<?= $ParamKategoriCapil ?>"></th>

                                        <button type="submit" style="display: none;"></button>
                                    </form>
                                </tr>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Kecamatan</th>
                                    <th scope="col">Kelurahan</th>
                                    <th scope="col">No TPS</th>
                                    <th scope="col">Kategori Capil</th>
                                    <th scope="col">Jumlah DPT(a)</th>
                                    <th scope="col">Jumlah DBTb(b)</th>
                                    <th scope="col">Jumlah DPK(c)</th>
                                    <th scope="col">Jumlah Pemilih(a+b+c)</th>
                                    <th scope="col">Jumlah Suara Sah(d)</th>
                                    <th scope="col">Jumlah Suara Tidak Sah(e)</th>
                                    <th scope="col">Jumlah Pengguna Hak Pilih(d+e)</th>
                                    <th scope="col">Tgl Input</th>

                                </tr>

                            </thead>
                            <tbody>
                                <?php

                                $page = (isset($_GET['page'])) ? $_GET['page'] : 1;

                                $limit = 10; // Jumlah data per halamannya

                                // Untuk menentukan dari data ke berapa yang akan ditampilkan pada tabel yang ada di database
                                $limit_start = ($page - 1) * $limit;

                                $No = $limit_start + 1;

                                $_SESSION['summary-tps-kecamatan'] = $ParamKecamatan;
                                $_SESSION['summary-tps-kelurahan'] = $ParamKelurahan;
                                $_SESSION['summary-tps-tps'] = $ParamTps;
                                $_SESSION['summary-tps-kategori-capil'] = $ParamKategoriCapil;

                                $q = "SELECT dp.kecamatan, dp.kelurahan, dhrh.no_ktp, dhrh.kategori_capil , dp.no_tps , dhrh.jumlah_dpt, dhrh.jumlah_dptb, dhrh.jumlah_dpk, dhrh.jumlah_pemilih,
                                                dhrh.jumlah_suara_sah , dhrh.jumlah_suara_tidak_sah , dhrh.jumlah_pengguna_hak_pilih, dhrh.tgl_input
                                                FROM db_hasil_rekap_hdr dhrh join db_ptps dp 
                                                ON dhrh.no_ktp = dp.no_ktp
                                                AND (dp.kecamatan LIKE '%$ParamKecamatan%'OR '' = '$ParamKecamatan') 
                                                AND (dp.kelurahan LIKE '%$ParamKelurahan%' OR '' = '$ParamKelurahan') 
                                                AND (dp.no_tps LIKE '%$ParamTps%'OR '' = '$ParamTps')
                                                AND (dhrh.kategori_capil LIKE '%$ParamKategoriCapil%'OR '' = '$ParamKategoriCapil')
                                                ORDER BY kecamatan, kelurahan, no_tps
                                                LIMIT $limit_start, $limit";

                                $sql = mysqli_query($conn, $q);

                                $q2 = "SELECT COUNT(1) as cnt
                                            FROM db_hasil_rekap_hdr dhrh join db_ptps dp 
                                            ON dhrh.no_ktp = dp.no_ktp
                                            AND (kecamatan LIKE '%$ParamKecamatan%' OR '' = '$ParamKecamatan') 
                                            AND (kelurahan LIKE '%$ParamKelurahan%' OR '' = '$ParamKelurahan') 
                                            AND (no_tps LIKE '%$ParamTps%' OR '' = '$ParamTps')
                                            AND (dhrh.kategori_capil LIKE '%$ParamKategoriCapil%'OR '' = '$ParamKategoriCapil')";
                                $sql2 = mysqli_query($conn, $q2);
                                $row2 = mysqli_fetch_assoc($sql2);
                                $total_data = $row2['cnt'];

                                if ($total_data > 0) {
                                    while ($row = mysqli_fetch_assoc($sql)) {

                                        $Kecamatan = strtoupper($row['kecamatan']);
                                        $Kelurahan = strtoupper($row['kelurahan']);
                                        $KategoriCapil = $row['kategori_capil'];
                                        $NomorKTP = $row['no_ktp'];
                                        $NoTPS = $row['no_tps'];
                                        $JmlDpt = $row['jumlah_dpt'];
                                        $JmlDptb = $row['jumlah_dptb'];
                                        $JmlDpk = $row['jumlah_dpk'];
                                        $JmlPemilih = $JmlDpt + $JmlDptb + $JmlDpk;
                                        $JmlSuaraSah = $row['jumlah_suara_sah'];
                                        $JmlSuaraTdkSah = $row['jumlah_suara_tidak_sah'];
                                        $JmlPgnHakPilih = $JmlSuaraSah + $JmlSuaraTdkSah;
                                        $TglInput = $row['tgl_input'];

                                        echo "
                                            <tr>
                                                <td>$No</td>
                                                <td>$Kecamatan</td>
                                                <td>$Kelurahan</td>
                                                <td>$NoTPS</td>
                                                <td>$KategoriCapil</td>
                                                <td>$JmlDpt</td>
                                                <td>$JmlDptb</td>
                                                <td>$JmlDpk</td>
                                                <td style='font-weight:bold'>$JmlPemilih</td>
                                                <td>$JmlSuaraSah</td>
                                                <td>$JmlSuaraTdkSah</td>
                                                <td style='font-weight:bold'>$JmlPgnHakPilih</td>
                                                <td>$TglInput</td>
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
                                    echo "<li class='page-item'><a class='page-link' href='summary-tps.php?page=1'>First</a></li>";
                                    echo "<li class='page-item'><a class='page-link' href='summary-tps.php?page=$link_prev&it_cari_kec=$ParamKecamatan&it_cari_kel=$ParamKelurahan&it_cari_no_tps=$ParamTps'>&laquo;</a></li>";
                                }

                                $q = "SELECT COUNT(1) as cnt
                                        FROM db_hasil_rekap_hdr dhrh join db_ptps dp 
                                        ON dhrh.no_ktp = dp.no_ktp
                                        AND (dp.kecamatan LIKE '%$ParamKecamatan%' OR '' = '$ParamKecamatan') 
                                        AND ( dp.kelurahan LIKE '%$ParamKelurahan%' OR '' = '$ParamKelurahan') 
                                        AND (dp.no_tps LIKE '%$ParamTps%' OR '' = '$ParamTps')
                                        AND (dhrh.kategori_capil LIKE '%$ParamKategoriCapil%'OR '' = '$ParamKategoriCapil')";
                                $sql = mysqli_query($conn, $q);
                                $row = mysqli_fetch_assoc($sql);
                                $jumlah = $row['cnt'];

                                $jumlah_page = ceil($jumlah / $limit); // Hitung jumlah halamannya
                                $jumlah_number = 3; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
                                $start_number = ($page > $jumlah_number) ? $page - $jumlah_number : 1; // Untuk awal link number
                                $end_number = ($page < ($jumlah_page - $jumlah_number)) ? $page + $jumlah_number : $jumlah_page; // Untuk akhir link number

                                for ($i = $start_number; $i <= $end_number; $i++) {

                                    $link_active = ($page == $i) ? ' class="page-item active"' : '';

                                    echo "<li$link_active><a class='page-link' href='summary-tps.php?page=$i&it_cari_kec=$ParamKecamatan&it_cari_kel=$ParamKelurahan&it_cari_no_tps=$ParamTps'>$i</a></li>";
                                }

                                // LINK NEXT AND LAST

                                // Jika page sama dengan jumlah page, maka disable link NEXT nya
                                // Artinya page tersebut adalah page terakhir 
                                if ($page == $jumlah_page) { // Jika page terakhir
                                    echo "<li class='page-item disbled'><a class='page-link' href='#'>&raquo;</a></li>";
                                    echo "<li class='page-item disbled'><a class='page-link' href='#'>Last</a></li>";
                                } else { // Jika Bukan page terakhir
                                    $link_next = ($page < $jumlah_page) ? $page + 1 : $jumlah_page;

                                    echo "<li class='page-item'><a class='page-link' href='summary-tps.php?page=$link_next&it_cari_kec=$ParamKecamatan&it_cari_kel=$ParamKelurahan&it_cari_no_tps=$ParamTps'>&raquo;</a></li>";
                                    echo "<li class='page-item'><a class='page-link' href='summary-tps.php?page=$jumlah_page&it_cari_kec=$ParamKecamatan&it_cari_kel=$ParamKelurahan&it_cari_no_tps=$ParamTps'>Last</a></li>";
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