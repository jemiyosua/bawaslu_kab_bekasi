<?php

session_start();
require_once('koneksi.php');

function filterData(&$str) { 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
}

function isMobile() {
    return preg_match('/\b(?:Mobile|Tablet)\b/i', $_SERVER['HTTP_USER_AGENT']);
}

$NavPage = $_SESSION['nav-page'];

if ($NavPage == "summary-tps") {

    if (isMobile()) {
        $fileName = $NavPage . "_" . date('Y-m-d') . ".xlsx";
    } else {
        $fileName = $NavPage . "_" . date('Y-m-d') . ".xls";
    }

    $fields = array(
        'NO', 
        'KECAMATAN', 
        'KELURAHAN', 
        'NO. TPS', 
        'JUMLAH DPT (a)', 
        'JUMLAH DPTB (b)', 
        'JUMLAH DPK (c)', 
        'JUMLAH PEMILIH (a+b+c)',
        'JUMLAH SUARA SAH (d)',
        'JUMLAH SUARA TIDAK SAH (e)',
        'JUMLAH PENGGUNA HAK PILIH (d+e)',
    );

    $excelData = implode("\t", array_values($fields)) . "\n"; 

    $ParamKecamatan = $_SESSION['summary-tps-kecamatan'];
    $ParamKelurahan = $_SESSION['summary-tps-kelurahan'];
    $ParamTps = $_SESSION['summary-tps-tps'];
    $ParamKategoriCapil = $_SESSION['summary-tps-kategori-capil'];

    $query = mysqli_query($conn, "SELECT dp.kecamatan, dp.kelurahan , dp.no_tps, dhrh.kategori_capil, dhrh.jumlah_dpt, dhrh.jumlah_dptb, dhrh.jumlah_dpk, dhrh.jumlah_pemilih,
    dhrh.jumlah_suara_sah , dhrh.jumlah_suara_tidak_sah , dhrh.jumlah_pengguna_hak_pilih, dhrh.tgl_input
    FROM db_hasil_rekap_hdr dhrh join db_ptps dp 
    ON dhrh.no_ktp = dp.no_ktp
    AND (dp.kecamatan LIKE '%$ParamKecamatan%'OR '' = '$ParamKecamatan') 
    AND ( dp.kelurahan LIKE '%$ParamKelurahan%' OR '' = '$ParamKelurahan') 
    AND (dp.no_tps LIKE '%$ParamTps%'OR '' = '$ParamTps')
    AND (dhrh.kategori_capil LIKE '%$ParamKategoriCapil%' OR '' = '$ParamKategoriCapil')
    ORDER BY kecamatan, kelurahan, no_tps");
    $No = 1;
    while($row = mysqli_fetch_assoc($query)) {

        $JumlahPemilih = $row['jumlah_dpt'] + $row['jumlah_dptb'] + $row['jumlah_dpk'];
        $JumlahPenggunaHakPilih =  $row['jumlah_suara_sah'] + $row['jumlah_suara_tidak_sah'];

        $lineData = array(
            $No++,
            $row['kecamatan'],
            $row['kelurahan'],
            $row['no_tps'],
            $row['kategori_capil'],
            $row['jumlah_dpt'],
            $row['jumlah_dptb'], 
            $row['jumlah_dpk'], 
            $JumlahPemilih,
            $row['jumlah_suara_sah'], 
            $row['jumlah_suara_tidak_sah'], 
            $JumlahPenggunaHakPilih,
        );

        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    } 
} else if ($NavPage == "hasil-rekap") {

    if (isMobile()) {
        $fileName = $NavPage . "_" . date('Y-m-d') . ".xlsx";
    } else {
        $fileName = $NavPage . "_" . date('Y-m-d') . ".xls";
    }

    $fields = array(
        'NO', 
        'KECAMATAN', 
        'KELURAHAN', 
        'NO. TPS', 
        'KATEGORI', 
        'DAPIL', 
        'PARTAI', 
        'NO. URUT',
        'NAMA',
        'JUMLAH SUARA',
        'INPUTOR (NIK)',
    );

    $excelData = implode("\t", array_values($fields)) . "\n"; 

    $ParamKecamatan = $_SESSION['hasil-rekap-kecamatan'];
    $ParamKelurahan = $_SESSION['hasil-rekap-kelurahan'];
    $ParamTps = $_SESSION['hasil-rekap-tps'];
    $ParamKategori = $_SESSION['hasil-rekap-kategori'];
    $ParamKodePartai = $_SESSION['hasil-rekap-partai'];
    $ParamKtp = $_SESSION['hasil-rekap-ktp'];
    $ParamNama =  $_SESSION['hasil-rekap-nama'];
    $ParamDapil = $_SESSION['hasil-rekap-dapil'];
    $ParamNoUrut = $_SESSION['hasil-rekap-no-urut'];

    $query = mysqli_query($conn, "SELECT * FROM v_rekap_final WHERE 
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
        ORDER BY
            kecamatan, 
            kelurahan, 
            no_tps DESC, 
            kategori_capil, 
            dapil, 
            kode_partai, 
            no_urut");
            
    $No = 1;
    while($row = mysqli_fetch_assoc($query)) {

        $lineData = array(
            $No++,
            $row['kecamatan'], 
            $row['kelurahan'], 
            $row['no_tps'], 
            $row['kategori_capil'], 
            $row['dapil'], 
            $row['kode_partai'], 
            $row['no_urut'], 
            $row['nama_capil'], 
            $row['jumlah_suara'], 
            "'" . $row['no_ktp'],
        );

        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    }
} else if ($NavPage == "hasil-rekap-partai") {

    if (isMobile()) {
        $fileName = $NavPage . "_" . date('Y-m-d') . ".xlsx";
    } else {
        $fileName = $NavPage . "_" . date('Y-m-d') . ".xls";
    }

    $fields = array(
        'NO', 
        'KECAMATAN', 
        'KELURAHAN', 
        'NO. TPS', 
        'KATEGORI',
        'PARTAI',
        'JUMLAH SUARA',
        'INPUTOR (NIK)',
    );

    $excelData = implode("\t", array_values($fields)) . "\n"; 

    $ParamKecamatan = $_SESSION['rekap-partai-kecamatan'];
    $ParamKelurahan = $_SESSION['rekap-partai-kelurahan'];
    $ParamTps = $_SESSION['rekap-partai-tps'];
    $ParamKategori =  $_SESSION['rekap-partai-kategori'];
    $ParamPartai = $_SESSION['rekap-partai-partai'];
    $ParamKtp = $_SESSION['rekap-partai-ktp'];

    $query = mysqli_query($conn, "SELECT x.* from(
        SELECT dp.kecamatan, dp.kelurahan, dp.no_tps ,dhrsp.kategori_capil ,dhrsp.kode_partai, 
        (SELECT id from db_master_partai dmp  WHERE dmp.kode_partai = dhrsp.kode_partai)no_partai,
        dhrsp.jumlah_suara, dhrsp.no_ktp
        from db_hasil_rekap_suara_partai dhrsp, 
        db_ptps dp
        WHERE dhrsp.no_ktp  = dp.no_ktp 
      )x WHERE (kecamatan LIKE '%$ParamKecamatan%'OR '' = '$ParamKecamatan')
      AND ( kelurahan LIKE '%$ParamKelurahan%' OR '' = '$ParamKelurahan') 
      AND (no_tps LIKE '%$ParamTps%'OR '' = '$ParamTps')
      AND (kategori_capil LIKE '%$ParamKategori%'OR '' = '$ParamKategori')
      AND (kode_partai LIKE '%$ParamPartai%'OR '' = '$ParamPartai')
      AND (no_ktp LIKE '%$ParamKtp%'OR '' = '$ParamKtp')
      ORDER BY kecamatan, kelurahan, no_tps, kategori_capil, no_partai");
    $No = 1;
    while($row = mysqli_fetch_assoc($query)) {

        $lineData = array(
            $No++,
            $row['kecamatan'], 
            $row['kelurahan'], 
            $row['no_tps'], 
            $row['kategori_capil'],
            $row['kode_partai'],
            $row['jumlah_suara'], 
            "'" . $row['no_ktp'],
        );

        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    }
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$fileName.'"');
header('Cache-Control: max-age=0');
 
echo $excelData; 
 
mysqli_close($conn);

exit;