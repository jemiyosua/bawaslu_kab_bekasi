<?php
session_start();
require_once('koneksi.php');
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Export File.xlsx");

?>

<main id="main" class="main">
    <?php
    $NavPage = $_SESSION['nav-page'];

    if ($NavPage == 'summary-tps') {

    ?>
        <div>

            <table>
                <tr>
                    <th>No</th>
                    <th>Kecamatan</th>
                    <th>Kelurahan</th>
                    <th>No TPS</th>
                    <th>Jumlah DPT(a)</th>
                    <th>Jumlah DBTb(b)</th>
                    <th>Jumlah DPK(c)</th>
                    <th>Jumlah Pemilih(a+b+c)</th>
                    <th>Jumlah Suara Sah(d)</th>
                    <th>Jumlah Suara Tidak Sah(e)</th>
                    <th>Jumlah Pengguna Hak Pilih(d+e)</th>
                    <th>Tgl Input</th>
                </tr>
                <?php
                // koneksi database
                // $koneksi = mysqli_connect("localhost","root","","pegawai");

                // menampilkan data pegawai

                $ParamKecamatan = $_SESSION['ParamKecamatan'];
                $ParamKelurahan = $_SESSION['ParamKelurahan'];
                $ParamTps = $_SESSION['ParamTps'];

                $q = "SELECT dp.kecamatan, dp.kelurahan , dp.no_tps , dhrh.jumlah_dpt, dhrh.jumlah_dptb, dhrh.jumlah_dpk, dhrh.jumlah_pemilih,
                                        dhrh.jumlah_suara_sah , dhrh.jumlah_suara_tidak_sah , dhrh.jumlah_pengguna_hak_pilih, dhrh.tgl_input
                                        from db_hasil_rekap_hdr dhrh join db_ptps dp 
                                        ON dhrh.no_ktp = dp.no_ktp
                                        AND (dp.kecamatan LIKE '%$ParamKecamatan%'OR '' = '$ParamKecamatan') 
                                        AND ( dp.kelurahan LIKE '%$ParamKelurahan%' OR '' = '$ParamKelurahan') 
                                        AND (dp.no_tps LIKE '%$ParamTps%'OR '' = '$ParamTps')
                                        AND jumlah_dpt > 0
                                        ORDER BY kecamatan, kelurahan, no_tps";
                $data = mysqli_query($conn, $q);
                $no = 1;
                while ($d = mysqli_fetch_array($data)) {
                ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $d['kecamatan']; ?></td>
                        <td><?php echo $d['kelurahan']; ?></td>
                        <td><?php echo $d['no_tps']; ?></td>
                        <td><?php echo $d['jumlah_dpt']; ?></td>
                        <td><?php echo $d['jumlah_dptb']; ?></td>
                        <td><?php echo $d['jumlah_dpk']; ?></td>
                        <td><?php echo $d['jumlah_pemilih']; ?></td>
                        <td><?php echo $d['jumlah_suara_sah']; ?></td>
                        <td><?php echo $d['jumlah_suara_tidak_sah']; ?></td>
                        <td><?php echo $d['jumlah_pengguna_hak_pilih']; ?></td>
                        <td><?php echo $d['tgl_input']; ?></td>
                    </tr>
                <?php
                }
                ?>
            </table>
        </div>

    <?php

    } else if ($NavPage == 'hasil-rekap') {
    ?>
        <div>

            <table>
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
                <?php
                // koneksi database
                // $koneksi = mysqli_connect("localhost","root","","pegawai");

                // menampilkan data pegawai

                $ParamKecamatan = $_SESSION['hasil-rekap-kecamatan'];
                $ParamKelurahan = $_SESSION['hasil-rekap-kelurahan'];
                $ParamTps = $_SESSION['hasil-rekap-tps'];
                $ParamKategori = $_SESSION['hasil-rekap-kategori'];
                $ParamKodePartai = $_SESSION['hasil-rekap-partai'];
                $ParamKtp = $_SESSION['hasil-rekap-ktp'];
                $ParamNama =  $_SESSION['hasil-rekap-nama'];
                $ParamDapil = $_SESSION['hasil-rekap-dapil'];
                $ParamNoUrut = $_SESSION['hasil-rekap-no-urut'];

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
                        no_urut";
                $data = mysqli_query($conn, $q);
                $no = 1;
                while ($d = mysqli_fetch_array($data)) {
                ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $d['kecamatan']; ?></td>
                        <td><?php echo $d['kelurahan']; ?></td>
                        <td><?php echo $d['no_tps']; ?></td>
                        <td><?php echo $d['kategori_capil']; ?></td>
                        <td><?php echo $d['dapil']; ?></td>
                        <td><?php echo $d['kode_partai']; ?></td>
                        <td><?php echo $d['no_urut']; ?></td>
                        <td><?php echo $d['nama_capil']; ?></td>
                        <td><?php echo $d['jumlah_suara']; ?></td>
                        <td><?php echo "'".$d['no_ktp']; ?></td>
                        <td><?php echo $d['tgl_input']; ?></td>
                    </tr>
                <?php
                }
                ?>
            </table>
        </div>

    <?php

    }
    ?>


</main>