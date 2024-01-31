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

// resetSessionHasilRekap();

?>

<?php
function resetSessionHasilRekap()
{
    unset($_SESSION['s_it_cari_kec']);
    unset($_SESSION['it_cari_kel']);
    unset($_SESSION['it_cari_no_tps']);
    unset($_SESSION['it_cari_kategori']);
    unset($_SESSION['it_cari_dapil']);
    unset($_SESSION['it_cari_partai']);
    unset($_SESSION['it_cari_no_urut']);
    unset($_SESSION['it_cari_nama']);
    unset($_SESSION['it_cari_kec']);
};

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
                        <table class="table table-hover" style="display: block; overflow-x: auto;white-space: nowrap;">
                            <thead class="thead-grey">
                                <tr>
                                    <th scope="col"></th>
                                    <!-- <form>
                                        <th scope="col"><input type="text" class="form-control" placeholder="Kecamatan..." aria-describedby="button-addon2" name="it_cari_kec"></th>
                                    </form> -->

                                    <th scope="col"><input type="text" class="form-control" placeholder="Kecamatan..." aria-describedby="button-addon2" name="it_cari_kec" onchange="alert('TEST')"></th>
                                    <form>
                                        <th scope="col"><input type="text" class="form-control" placeholder="Kelurahan..." aria-describedby="button-addon2" name="it_cari_kel"></th>
                                    </form>

                                    <form>
                                        <th scope="col"><input type="text" class="form-control" placeholder="No TPS..." aria-describedby="button-addon2" name="it_cari_no_tps"></th>
                                    </form>

                                    <form>
                                        <th scope="col"><input type="text" class="form-control" placeholder="Kategori..." aria-describedby="button-addon2" name="it_cari_kategori"></th>
                                    </form>

                                    <form>
                                        <th scope="col"><input type="text" class="form-control" placeholder="Dapil..." aria-describedby="button-addon2" name="it_cari_dapil"></th>
                                    </form>

                                    <form>
                                        <th scope="col"><input type="text" class="form-control" placeholder="Partai..." aria-describedby="button-addon2" name="it_cari_partai"></th>
                                    </form>

                                    <form>
                                        <th scope="col"><input type="text" class="form-control" placeholder="No Urut..." aria-describedby="button-addon2" name="it_cari_no_urut"></th>
                                    </form>

                                    <form>
                                        <th scope="col"><input type="text" class="form-control" placeholder="Nama..." aria-describedby="button-addon2" name="it_cari_nama"></th>
                                    </form>

                                    <th scope="col"></th>

                                    <form>
                                        <th scope="col"><input type="text" class="form-control" placeholder="Inputor..." aria-describedby="button-addon2" name="it_cari_inputor"></th>
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

                                $ParamKecamatan = "ALL";
                                $ParamKelurahan = "ALL";
                                $ParamTps = "ALL";
                                $ParamKategori = "ALL";
                                $ParamKodePartai = "ALL";
                                $ParamKtp = "ALL";
                                $ParamNama = "ALL";
                                $ParamDapil = "ALL";
                                $ParamNoUrut = "ALL";

                                if (isset($_GET['it_cari_kec'])) {
                                    $ParamKecamatan = $_GET['it_cari_kec'] == "" ? "ALL" : $_GET['it_cari_kec'];
                                }

                                if (isset($_GET['it_cari_kel'])) {
                                    $ParamKelurahan = $_GET['it_cari_kel'] == "" ? "ALL" : $_GET['it_cari_kel'];
                                }

                                if (isset($_GET['it_cari_kel'])) {
                                    $ParamKelurahan = $_GET['it_cari_kel'] == "" ? "ALL" : $_GET['it_cari_kel'];
                                }

                                if (isset($_GET['it_cari_no_tps'])) {
                                    $ParamTps = $_GET['it_cari_no_tps'] == "" ? "ALL" : $_GET['it_cari_no_tps'];
                                }

                                if (isset($_GET['it_cari_kategori'])) {
                                    $ParamKategori = $_GET['it_cari_kategori'] == "" ? "ALL" : $_GET['it_cari_kategori'];
                                }

                                if (isset($_GET['it_cari_dapil'])) {
                                    $ParamDapil = $_GET['it_cari_dapil'] == "" ? "ALL" : $_GET['it_cari_dapil'];
                                } 

                                if (isset($_GET['it_cari_partai'])) {
                                    $ParamKodePartai = $_GET['it_cari_partai'] == "" ? "ALL" : $_GET['it_cari_partai'];
                                }

                                if (isset($_GET['it_cari_no_urut'])) {
                                    $ParamNoUrut = $_GET['it_cari_no_urut'] == "" ? "ALL" : $_GET['it_cari_no_urut'];
                                }
                                
                                if (isset($_GET['it_cari_nama'])) {
                                    $ParamNama = $_GET['it_cari_nama'] == "" ? "ALL" : $_GET['it_cari_nama'];
                                }

                                if (isset($_GET['it_cari_inputor'])) {
                                    $ParamKtp = $_GET['it_cari_inputor'] == "" ? "ALL" : $_GET['it_cari_inputor'];
                                }
                                
                                // if (isset($_SESSION['s_it_cari_kec'])) {
                                //     $ParamKecamatan = $_SESSION['s_it_cari_kec'];
                                // } else {
                                //     if (isset($_GET['it_cari_kec'])) {
                                //         $ParamKecamatan = $_GET['it_cari_kec'] == "" ? "ALL" : $_GET['it_cari_kec'];
                                //     } else {
                                //         $ParamKecamatan = "ALL";
                                //     }

                                //     if($ParamKecamatan != "ALL"){
                                //         $_SESSION['s_it_cari_kec'] = $ParamKecamatan;
                                //     }
                                // }

                                // if (!isset($_SESSION['it_cari_kel'])) {
                                //     if (isset($_GET['it_cari_kel'])) {
                                //         $ParamKelurahan = $_GET['it_cari_kel'] == "" ? "ALL" : $_GET['it_cari_kel'];
                                //     } else {
                                //         $ParamKelurahan = "ALL";
                                //     }
                                //     if ($ParamKelurahan != "ALL") {
                                //         $_SESSION['it_cari_kel'] = $ParamKelurahan;
                                //     }
                                // } else {
                                //     if ($ParamKelurahan != "ALL"){
                                //         $ParamKelurahan = $_SESSION['it_cari_kel'];
                                //     }
                                // }


                                // if (!isset($_SESSION['it_cari_no_tps'])) {
                                //     if (isset($_GET['it_cari_no_tps'])) {
                                //         $ParamTps = $_GET['it_cari_no_tps'] == "" ? "ALL" : $_GET['it_cari_no_tps'];
                                //     } else {
                                //         $ParamTps = "ALL";
                                //     }
                                //     $_SESSION['it_cari_no_tps'] = $ParamTps;
                                // } else {
                                //     $ParamTps = $_SESSION['it_cari_no_tps'];
                                // }


                                // if (!isset($_SESSION['it_cari_kategori'])) {
                                //     if (isset($_GET['it_cari_kategori'])) {
                                //         $ParamKategori = $_GET['it_cari_kategori'] == "" ? "ALL" : $_GET['it_cari_kategori'];
                                //     } else {
                                //         $ParamKategori = "ALL";
                                //     }
                                //     $_SESSION['it_cari_kategori'] = $ParamKategori;
                                // } else {
                                //     $ParamKategori = $_SESSION['it_cari_kategori'];
                                // }


                                // if (!isset($_SESSION['it_cari_dapil'])) {
                                //     if (isset($_GET['it_cari_dapil'])) {
                                //         $ParamDapil = $_GET['it_cari_dapil'] == "" ? "ALL" : $_GET['it_cari_dapil'];
                                //     } else {
                                //         $ParamDapil = "ALL";
                                //     }
                                //     $_SESSION['it_cari_dapil'] = $ParamDapil;
                                // } else {
                                //     $ParamDapil = $_SESSION['it_cari_dapil'];
                                // }



                                // if (!isset($_SESSION['it_cari_partai'])) {
                                //     if (isset($_GET['it_cari_partai'])) {
                                //         $ParamKodePartai = $_GET['it_cari_partai'] == "" ? "ALL" : $_GET['it_cari_partai'];
                                //     } else {
                                //         $ParamKodePartai = "ALL";
                                //     }

                                //     $_SESSION['it_cari_partai'] = $ParamKodePartai;
                                // } else {
                                //     $ParamKodePartai = $_SESSION['it_cari_partai'];
                                // }


                                // if (!isset($_SESSION['it_cari_no_urut'])) {
                                //     if (isset($_GET['it_cari_no_urut'])) {
                                //         $ParamNoUrut = $_GET['it_cari_no_urut'] == "" ? "ALL" : $_GET['it_cari_no_urut'];
                                //     } else {
                                //         $ParamNoUrut = "ALL";
                                //     }
                                //     $_SESSION['it_cari_no_urut'] = $ParamNoUrut;
                                // } else {
                                //     $ParamNoUrut = $_SESSION['it_cari_no_urut'];
                                // }


                                // if (!isset($_SESSION['it_cari_nama'])) {
                                //     if (isset($_GET['it_cari_nama'])) {
                                //         $ParamNama = $_GET['it_cari_nama'] == "" ? "ALL" : $_GET['it_cari_nama'];
                                //     } else {
                                //         $ParamNama = "ALL";
                                //     }
                                //     $_SESSION['it_cari_nama'] = $ParamNama;
                                // } else {
                                //     $ParamNama = $_SESSION['it_cari_nama'];
                                // }

                                // if (!isset($_SESSION['it_cari_inputor'])) {
                                //     if (isset($_GET['it_cari_inputor'])) {
                                //         $ParamKtp = $_GET['it_cari_inputor'] == "" ? "ALL" : $_GET['it_cari_inputor'];
                                //     } else {
                                //         $ParamKtp = "ALL";
                                //     }
                                //     $_SESSION['it_cari_inputor'] = $ParamKtp;
                                // } else {
                                //     $ParamKtp = $_SESSION['it_cari_inputor'];
                                // }

                                // echo $ParamKecamatan . '-' . $ParamKelurahan . '-' . $ParamTps . '-' . $ParamKategori . '-' . $ParamKodePartai . '-' . $ParamKtp . '-' . $ParamNama . '-' . $ParamDapil . '-' . $ParamNoUrut;

                                $q = "select * from v_rekap_final where 
                                        (kategori_capil like '%$ParamKategori%' 
                                        or 'ALL' = '$ParamKategori') 
                                        and (kecamatan like '%$ParamKecamatan%'or 'ALL' = '$ParamKecamatan') 
                                        and ( kelurahan like '%$ParamKelurahan%' or 'ALL' = '$ParamKelurahan') 
                                        and (no_ktp like '%$ParamKtp%'or 'ALL' = '$ParamKtp')
                                        and (no_tps = '%$ParamTps%'or 'ALL' = '$ParamTps')
                                        and (no_urut = '$ParamNoUrut' or 'ALL' = '$ParamNoUrut' ) 
                                        and (kode_partai like '%$ParamKodePartai%' or 'ALL' =  '$ParamKodePartai') 
                                        and (nama_capil like '%$ParamNama%' or 'ALL' =  '$ParamNama') 
                                        and (dapil like '%$ParamDapil%' or 'ALL' =  '$ParamDapil')
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
                                ?>
                            </tbody>
                        </table>

                        <?php

                        // $q = "SELECT COUNT(1) AS cnt FROM db_master_capres_cawapres WHERE nama LIKE '%" . $cari . "%' ORDER BY id ASC";
                        $q = "select count(1) as cnt from v_rekap_final where 
                                        (kategori_capil like '%$ParamKategori%' 
                                        or 'ALL' = '$ParamKategori') 
                                        and (kecamatan like '%$ParamKecamatan%'or 'ALL' = '$ParamKecamatan') 
                                        and ( kelurahan like '%$ParamKelurahan%' or 'ALL' = '$ParamKelurahan') 
                                        and (no_ktp like '%$ParamKtp%'or 'ALL' = '$ParamKtp')
                                        and (no_tps = '%$ParamTps%'or 'ALL' = '$ParamTps')
                                        and (no_urut = '$ParamNoUrut' or 'ALL' = '$ParamNoUrut' ) 
                                        and (kode_partai like '%$ParamKodePartai%' or 'ALL' =  '$ParamKodePartai') 
                                        and (nama_capil like '%$ParamNama%' or 'ALL' =  '$ParamNama') 
                                        and (dapil like '%$ParamDapil%' or 'ALL' =  '$ParamDapil')";
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
                                    echo "<li class='page-item'><a class='page-link' href='hasil-rekap.php?page=1'>First</a></li>";
                                    echo "<li class='page-item'><a class='page-link' href='hasil-rekap.php?page=$link_prev&it_cari_kec=$ParamKecamatan&it_cari_kategori=$ParamKategori&it_cari_kel=$ParamKelurahan&it_cari_inputor=$ParamKtp&it_cari_no_tps=$ParamTps&it_cari_no_urut=$ParamNoUrut&it_cari_partai=$ParamKodePartai&it_cari_nama=$ParamNama&it_cari_dapil=$ParamDapil'>&laquo;</a></li>";
                                }

                                $ParamKecamatan = "ALL";
                                $ParamKelurahan = "ALL";
                                $ParamTps = "ALL";
                                $ParamKategori = "ALL";
                                $ParamKodePartai = "ALL";
                                $ParamKtp = "ALL";
                                $ParamNama = "ALL";
                                $ParamDapil = "ALL";
                                $ParamNoUrut = "ALL";

                                if (isset($_GET['it_cari_kec'])) {
                                    $ParamKecamatan = $_GET['it_cari_kec'] == "" ? "ALL" : $_GET['it_cari_kec'];
                                }

                                if (isset($_GET['it_cari_kel'])) {
                                    $ParamKelurahan = $_GET['it_cari_kel'] == "" ? "ALL" : $_GET['it_cari_kel'];
                                }

                                if (isset($_GET['it_cari_kel'])) {
                                    $ParamKelurahan = $_GET['it_cari_kel'] == "" ? "ALL" : $_GET['it_cari_kel'];
                                }

                                if (isset($_GET['it_cari_no_tps'])) {
                                    $ParamTps = $_GET['it_cari_no_tps'] == "" ? "ALL" : $_GET['it_cari_no_tps'];
                                }

                                if (isset($_GET['it_cari_kategori'])) {
                                    $ParamKategori = $_GET['it_cari_kategori'] == "" ? "ALL" : $_GET['it_cari_kategori'];
                                }

                                if (isset($_GET['it_cari_dapil'])) {
                                    $ParamDapil = $_GET['it_cari_dapil'] == "" ? "ALL" : $_GET['it_cari_dapil'];
                                } 

                                if (isset($_GET['it_cari_partai'])) {
                                    $ParamKodePartai = $_GET['it_cari_partai'] == "" ? "ALL" : $_GET['it_cari_partai'];
                                }

                                if (isset($_GET['it_cari_no_urut'])) {
                                    $ParamNoUrut = $_GET['it_cari_no_urut'] == "" ? "ALL" : $_GET['it_cari_no_urut'];
                                }
                                
                                if (isset($_GET['it_cari_nama'])) {
                                    $ParamNama = $_GET['it_cari_nama'] == "" ? "ALL" : $_GET['it_cari_nama'];
                                }

                                if (isset($_GET['it_cari_inputor'])) {
                                    $ParamKtp = $_GET['it_cari_inputor'] == "" ? "ALL" : $_GET['it_cari_inputor'];
                                }

                                $q = "select count(1) as cnt from v_rekap_final where 
                                        (kategori_capil like '%$ParamKategori%' or 'ALL' = '$ParamKategori') 
                                        and (kecamatan like '%$ParamKecamatan%'or 'ALL' = '$ParamKecamatan') 
                                        and ( kelurahan like '%$ParamKelurahan%' or 'ALL' = '$ParamKelurahan') 
                                        and (no_ktp like '%$ParamKtp%'or 'ALL' = '$ParamKtp')
                                        and (no_tps = '%$ParamTps%'or 'ALL' = '$ParamTps')
                                        and (no_urut = '$ParamNoUrut' or 'ALL' = '$ParamNoUrut' ) 
                                        and (kode_partai like '%$ParamKodePartai%' or 'ALL' =  '$ParamKodePartai') 
                                        and (nama_capil like '%$ParamNama%' or 'ALL' =  '$ParamNama') 
                                        and (dapil like '%$ParamDapil%' or 'ALL' =  '$ParamDapil')";
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