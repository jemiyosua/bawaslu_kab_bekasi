<?php

session_start();

if (!isset($_SESSION['username']) && (!isset($_SESSION['password']))) {

    header('location:login.php');
}

$_SESSION['nav'] = "perhitungan-suara";
$_SESSION['nav-page'] = "hasil-rekap";

require_once('header.php');

require_once('navbar.php');

require_once('sidebar.php');

require_once('koneksi.php');

$ParamKecamatan = isset($_GET['it_cari_kec']) ? $_GET['it_cari_kec'] : '';
$ParamKelurahan = isset($_GET['it_cari_kel']) ? $_GET['it_cari_kel'] : '';
$ParamTps = isset($_GET['it_cari_no_tps']) ? $_GET['it_cari_no_tps'] : '';
$ParamKategori = isset($_GET['it_cari_kategori']) ? $_GET['it_cari_kategori'] : '';
$ParamKodePartai = isset($_GET['it_cari_partai']) ? $_GET['it_cari_partai'] : '';
$ParamKtp = isset($_GET['it_cari_inputor']) ? $_GET['it_cari_inputor'] : '';
$ParamNama = isset($_GET['it_cari_nama']) ? $_GET['it_cari_nama'] : '';
$ParamDapil = isset($_GET['it_cari_dapil']) ? $_GET['it_cari_dapil'] : '';
$ParamNoUrut = isset($_GET['it_cari_no_urut']) ? $_GET['it_cari_no_urut'] : '';

?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Rekap Hasil Perhitungan Suara</h1>
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
                            <thead>
                                <tr>
                                    <th scope="col"> <a class="btn btn-outline-secondary" href="hasil-rekap.php"><i class="bi bi-arrow-clockwise"></i></a></th>
                                    <form>
                                        <th scope="col"><input type="text" class="form-control" placeholder="Kecamatan..." aria-describedby="button-addon2" name="it_cari_kec" value="<?=$ParamKecamatan?>"></th>

                                        <th scope="col"><input type="text" class="form-control" placeholder="Kelurahan..." aria-describedby="button-addon2" name="it_cari_kel" value="<?=$ParamKelurahan?>"></th>

                                        <th scope="col"><input type="text" class="form-control" placeholder="No TPS..." aria-describedby="button-addon2" name="it_cari_no_tps" value="<?=$ParamTps?>"></th>

                                        <th scope="col"><input type="text" class="form-control" placeholder="Kategori..." aria-describedby="button-addon2" name="it_cari_kategori" value="<?=$ParamKategori?>"></th>

                                        <th scope="col"><input type="text" class="form-control" placeholder="Dapil..." aria-describedby="button-addon2" name="it_cari_dapil" value="<?=$ParamDapil?>"></th>

                                        <th scope="col"><input type="text" class="form-control" placeholder="Partai..." aria-describedby="button-addon2" name="it_cari_partai" value="<?=$ParamKodePartai?>"></th>

                                        <th scope="col"><input type="text" class="form-control" placeholder="No Urut..." aria-describedby="button-addon2" name="it_cari_no_urut" value="<?=$ParamNoUrut?>"></th>

                                        <th scope="col"><input type="text" class="form-control" placeholder="Nama..." aria-describedby="button-addon2" name="it_cari_nama" value="<?=$ParamNama?>"></th>

                                        <th scope="col"></th>

                                        <th scope="col"><input type="text" class="form-control" placeholder="Inputor..." aria-describedby="button-addon2" name="it_cari_inputor"></th>

                                        <button type="submit" style="display: none;"></button>
                                    </form>

                                    <th scope="col"></th>

                                </tr>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Kecamatan</th>
                                    <th scope="col">Kelurahan</th>
                                    <th scope="col">No TPS</th>
                                    <th scope="col">Kategori</th>
                                    <th scope="col">Dapil</th>
                                    <th scope="col">Partai</th>
                                    <th scope="col">No Urut</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Jumlah Suara</th>
                                    <th scope="col">Inputor(NIK)</th>
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

                                $_SESSION['hasil-rekap-kecamatan'] = $ParamKecamatan;
                                $_SESSION['hasil-rekap-kelurahan'] = $ParamKelurahan;
                                $_SESSION['hasil-rekap-tps'] = $ParamTps;
                                $_SESSION['hasil-rekap-kategori'] = $ParamKategori;
                                $_SESSION['hasil-rekap-partai'] = $ParamKodePartai;
                                $_SESSION['hasil-rekap-ktp'] = $ParamKtp;
                                $_SESSION['hasil-rekap-nama'] = $ParamNama;
                                $_SESSION['hasil-rekap-dapil'] = $ParamDapil;
                                $_SESSION['hasil-rekap-no-urut'] = $ParamNoUrut;

                                $q = "SELECT * FROM v_rekap_final WHERE 
                                        (kategori_capil LIKE '%$ParamKategori%' 
                                        OR '' = '$ParamKategori') 
                                        AND (kecamatan LIKE '%$ParamKecamatan%'OR '' = '$ParamKecamatan') 
                                        AND ( kelurahan LIKE '%$ParamKelurahan%' OR '' = '$ParamKelurahan') 
                                        AND (no_ktp LIKE '%$ParamKtp%'OR '' = '$ParamKtp')
                                        AND (no_tps LIKE '%$ParamTps%'OR '' = '$ParamTps')
                                        AND (no_urut = '$ParamNoUrut' OR '' = '$ParamNoUrut' ) 
                                        AND (kode_partai LIKE '%$ParamKodePartai%' OR '' =  '$ParamKodePartai') 
                                        AND (nama_capil LIKE '%$ParamNama%' OR '' =  '$ParamNama') 
                                        AND (dapil LIKE '%$ParamDapil%' OR '' =  '$ParamDapil')
                                    order by 
                                        kecamatan, 
                                        kelurahan, 
                                        no_tps DESC, 
                                        kategori_capil, 
                                        dapil, 
                                        kode_partai, 
                                        no_urut
                                        LIMIT $limit_start, $limit ";

                                $sql = mysqli_query($conn, $q);

                                $sql2 = mysqli_query($conn, "SELECT COUNT(1) AS cnt FROM v_rekap_final WHERE 
                                    (kategori_capil LIKE '%$ParamKategori%' 
                                    OR '' = '$ParamKategori') 
                                    AND (kecamatan LIKE '%$ParamKecamatan%'OR '' = '$ParamKecamatan') 
                                    AND ( kelurahan LIKE '%$ParamKelurahan%' OR '' = '$ParamKelurahan') 
                                    AND (no_ktp LIKE '%$ParamKtp%'OR '' = '$ParamKtp')
                                    AND (no_tps LIKE '%$ParamTps%'OR '' = '$ParamTps')
                                    AND (no_urut = '$ParamNoUrut' OR '' = '$ParamNoUrut' ) 
                                    AND (kode_partai LIKE '%$ParamKodePartai%' OR '' =  '$ParamKodePartai') 
                                    AND (nama_capil LIKE '%$ParamNama%' OR '' =  '$ParamNama') 
                                    AND (dapil LIKE '%$ParamDapil%' OR '' =  '$ParamDapil')");
                                $row2 = mysqli_fetch_assoc($sql2);
                                

                                $total_data = $row2['cnt'];

                                // $first_row = mysqli_fetch_assoc($sql);  

                                // $total_data = $first_row == null ? 0 : $first_row['cnt'];

                                // echo $first_row['nama_capil'];

                                if ($total_data > 0) {
                                    while ($row = mysqli_fetch_assoc($sql)) {

                                        $Kecamatan = $row['kecamatan'];
                                        $Kelurahan = $row['kelurahan'];
                                        $NoTPS = $row['no_tps'];
                                        $Kategori = $row['kategori_capil'];
                                        $Dapil = $row['dapil'];
                                        $Partai = $row['kode_partai'];
                                        $NoUrut = $row['no_urut'];
                                        $Nama = $row['nama_capil'];
                                        $JumlahSuara = $row['jumlah_suara'];
                                        $Inputor = $row['no_ktp'];
                                        $TglInput = $row['tgl_input'];

                                        echo "
                                            <tr>
                                                <td>$No</td>
                                                <td>$Kecamatan</td>
                                                <td>$Kelurahan</td>
                                                <td>$NoTPS</td>
                                                <td>$Kategori</td>
                                                <td>$Dapil</td>
                                                <td>$Partai</td>
                                                <td>$NoUrut</td>
                                                <td>$Nama</td>
                                                <td>$JumlahSuara</td>
                                                <td>$Inputor</td>
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
                                    echo "<li class='page-item'><a class='page-link' href='hasil-rekap.php?page=1'>First</a></li>";
                                    echo "<li class='page-item'><a class='page-link' href='hasil-rekap.php?page=$link_prev&it_cari_kec=$ParamKecamatan&it_cari_kategori=$ParamKategori&it_cari_kel=$ParamKelurahan&it_cari_inputor=$ParamKtp&it_cari_no_tps=$ParamTps&it_cari_no_urut=$ParamNoUrut&it_cari_partai=$ParamKodePartai&it_cari_nama=$ParamNama&it_cari_dapil=$ParamDapil'>&laquo;</a></li>";
                                }

                                $q = "SELECT count(1) AS cnt FROM v_rekap_final WHERE 
                                        (kategori_capil LIKE '%$ParamKategori%' OR '' = '$ParamKategori') 
                                        AND (kecamatan LIKE '%$ParamKecamatan%'OR '' = '$ParamKecamatan') 
                                        AND ( kelurahan LIKE '%$ParamKelurahan%' OR '' = '$ParamKelurahan') 
                                        AND (no_ktp LIKE '%$ParamKtp%'OR '' = '$ParamKtp')
                                        AND (no_tps LIKE '%$ParamTps%'OR '' = '$ParamTps')
                                        AND (no_urut = '$ParamNoUrut' OR '' = '$ParamNoUrut' ) 
                                        AND (kode_partai LIKE '%$ParamKodePartai%' OR '' =  '$ParamKodePartai') 
                                        AND (nama_capil LIKE '%$ParamNama%' OR '' =  '$ParamNama') 
                                        AND (dapil LIKE '%$ParamDapil%' OR '' =  '$ParamDapil')";
                                $sql = mysqli_query($conn, $q);
                                $row = mysqli_fetch_assoc($sql);
                                $jumlah = $row['cnt'];

                                $jumlah_page = ceil($jumlah / $limit); // Hitung jumlah halamannya
                                $jumlah_number = 3; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
                                $start_number = ($page > $jumlah_number) ? $page - $jumlah_number : 1; // Untuk awal link number
                                $end_number = ($page < ($jumlah_page - $jumlah_number)) ? $page + $jumlah_number : $jumlah_page; // Untuk akhir link number

                                for ($i = $start_number; $i <= $end_number; $i++) {

                                    $link_active = ($page == $i) ? ' class="page-item active"' : '';

                                    echo "<li$link_active><a class='page-link' href='hasil-rekap.php?page=$i&it_cari_kec=$ParamKecamatan&it_cari_kategori=$ParamKategori&it_cari_kel=$ParamKelurahan&it_cari_inputor=$ParamKtp&it_cari_no_tps=$ParamTps&it_cari_no_urut=$ParamNoUrut&it_cari_partai=$ParamKodePartai&it_cari_nama=$ParamNama&it_cari_dapil=$ParamDapil'>$i</a></li>";
                                }

                                // LINK NEXT AND LAST

                                // Jika page sama dengan jumlah page, maka disable link NEXT nya
                                // Artinya page tersebut adalah page terakhir 
                                if ($page == $jumlah_page) { // Jika page terakhir
                                    echo "<li class='page-item disbled'><a class='page-link' href='#'>&raquo;</a></li>";
                                    echo "<li class='page-item disbled'><a class='page-link' href='#'>Last</a></li>";
                                } else { // Jika Bukan page terakhir
                                    $link_next = ($page < $jumlah_page) ? $page + 1 : $jumlah_page;

                                    echo "<li class='page-item'><a class='page-link' href='hasil-rekap.php?page=$link_next&it_cari_kec=$ParamKecamatan&it_cari_kategori=$ParamKategori&it_cari_kel=$ParamKelurahan&it_cari_inputor=$ParamKtp&it_cari_no_tps=$ParamTps&it_cari_no_urut=$ParamNoUrut&it_cari_partai=$ParamKodePartai&it_cari_nama=$ParamNama&it_cari_dapil=$ParamDapil'>&raquo;</a></li>";
                                    echo "<li class='page-item'><a class='page-link' href='hasil-rekap.php?page=$jumlah_page&it_cari_kec=$ParamKecamatan&it_cari_kategori=$ParamKategori&it_cari_kel=$ParamKelurahan&it_cari_inputor=$ParamKtp&it_cari_no_tps=$ParamTps&it_cari_no_urut=$ParamNoUrut&it_cari_partai=$ParamKodePartai&it_cari_nama=$ParamNama&it_cari_dapil=$ParamDapil'>Last</a></li>";
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