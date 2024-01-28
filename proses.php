<?php

require_once('koneksi.php');

session_start();

if (isset($_POST['login-admin'])) {

    $Username = $_POST['username'];
    $Password = $_POST['password'];

    $sql = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_login WHERE username = '$Username' AND password = '$Password'");
    $row = mysqli_fetch_assoc($sql);
    $CountAdmin = $row["cnt"];

    if ($CountAdmin > 0) {
        $_SESSION['username'] = $Username;
        $_SESSION['password'] = $Password;
        header('location: main.php');
    } else {
        $_SESSION['pesanError'] = "Username atau Password Anda Salah!";
        header('location: login.php');
    }
} else if (isset($_POST['cek-ktp'])) {

    $NomorKTP = $_POST['no_ktp'];

    $sql = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_ptps WHERE no_ktp = '$NomorKTP'");
    $row = mysqli_fetch_assoc($sql);
    $CountKTP = $row["cnt"];

    if ($CountKTP > 0) {
        // $_SESSION['pesan'] = "Nomor KTP Anda Terdaftar!";
        $_SESSION['nomor_ktp'] = $NomorKTP;
        header('location: detail-data-ptps.php');
    } else {
        $_SESSION['pesanError'] = "Nomor KTP Anda Tidak Terdaftar!";
        header('location: input-ktp.php');
    }
}else if (isset($_POST['submit_ppwp'])) {
    //---------------------form ppwp-------------------------
    $NomorKTP = $_SESSION['nomor_ktp'];
    $KategoriCapil = ($_SESSION['kategori_capil']);

    $arr_data_paslon = [
        [
            "id_mst_capil" => 1,
            "jml_suara" => (int)$_POST['it-paslon-01']
        ],
        [
            "id_mst_capil" => 3,
            "jml_suara" => (int)$_POST['it-paslon-02']
        ],
        [
            "id_mst_capil" => 5,
            "jml_suara" => (int)$_POST['it-paslon-03']
        ]
    ];

    $jml_dpt_ppwp = $_POST['jml_dpt_ppwp'];
    $jml_dptb_ppwp = $_POST['jml_dptb_ppwp'];
    $jml_dpk_ppwp = $_POST['jml_dpk_ppwp'];
    $jml_pemilih = $_POST['jml_pemilih'];
    $jml_suara_sah_ppwp = $_POST['jml_suara_sah_ppwp'];
    $jml_suara_tdk_sah_ppwp = $_POST['jml_suara_tdk_sah_ppwp'];
    $jml_pgn_hak_pilih = $_POST['jml_pgn_hak_pilih'];

    $total_suara_paslon = (int)$_POST['it-paslon-01'] + (int)$_POST['it-paslon-02'] + (int)$_POST['it-paslon-03'];

    $sql = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_hasil_rekap_hdr WHERE no_ktp = '$NomorKTP' and kategori_capil = '$KategoriCapil'");
    $row = mysqli_fetch_assoc($sql);
    $CountData = $row["cnt"];

    if ($CountData > 0) {
        $_SESSION['pesanError'] = "Data sudah pernah diinput dengan NIK dan Kategori Yang sama";
        header('location: form_ppwp.php');
    } else {

        if ($jml_pemilih < $jml_pgn_hak_pilih) {
            $_SESSION['pesanError'] = "Pengguna hak pilih lebih banyak daripada jumlah pemilih";
            header('location: form_ppwp.php');
        } else if ($jml_suara_sah_ppwp < $total_suara_paslon) {
            $_SESSION['pesanError'] = "Total suara paslon lebih banyak daripada jumlah suara sah";
            header('location: form_ppwp.php');
        } else {
            $msNow = round(microtime(true)*1000);
            $imageId = $NomorKTP."_".$KategoriCapil."_".(String)$msNow;
            $sql = mysqli_query($conn, "insert into db_hasil_rekap_hdr(no_ktp,kategori_capil,jumlah_dpt,jumlah_dptb,jumlah_dpk,jumlah_pemilih,jumlah_suara_sah,jumlah_suara_tidak_sah,jumlah_pengguna_hak_pilih, image_id)
                                    values('$NomorKTP','$KategoriCapil','$jml_dpt_ppwp','$jml_dptb_ppwp','$jml_dpk_ppwp','$jml_pemilih','$jml_suara_sah_ppwp','$jml_suara_tdk_sah_ppwp','$jml_pgn_hak_pilih', '$imageId')");

            foreach ($arr_data_paslon as $data_paslon) {
                $id_mst_capil = $data_paslon['id_mst_capil'];
                $jml_suara = $data_paslon['jml_suara'];

                $sql = mysqli_query($conn, "insert into db_hasil_rekap_dtl(no_ktp, kategori_capil,id_mst_capil, jumlah_suara)
                                        values('$NomorKTP','$KategoriCapil','$id_mst_capil','$jml_suara')");
            }

            $sql = mysqli_query($conn, "update db_ptps set status_ppwp = 1 where no_ktp = '$NomorKTP'");

            if (count($_FILES) > 0) {
                if (is_uploaded_file($_FILES['ifImage']['tmp_name'])) {
                    $imgData = addslashes(file_get_contents($_FILES['ifImage']['tmp_name']));
                    $sql = mysqli_query($conn, "insert into db_master_image(image_id, imagebase64)values('$imageId', '". $imgData ."')");
                }
            }

            $_SESSION['pesan'] = "Berhasil Input Data Rekap";
            header('location: form_ppwp.php');
        }
    }
}
