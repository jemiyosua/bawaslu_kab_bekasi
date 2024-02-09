<?php

require_once('koneksi.php');

session_start();

if (isset($_POST['login-admin'])) {

    $Username = $_POST['username'];
    $Password = $_POST['password'];

    $PasswordMd5 = md5($Password);

    $sql = mysqli_query($conn, "SELECT COUNT(*) AS cnt, flag_login, access FROM db_login WHERE username = '$Username' AND password = '$PasswordMd5'");
    $row = mysqli_fetch_assoc($sql);
    $CountAdmin = $row["cnt"];
    $FlagLogin = $row["flag_login"];
    $Access = $row["access"];

    if ($CountAdmin > 0) {
        if ($FlagLogin == 1) {
            // $_SESSION['pesanError'] = "Akses login mencapai limit!";
            // header('location: login.php');
            $_SESSION['username'] = $Username;
            $_SESSION['password'] = $Password;
            $_SESSION['access'] = $Access;
            header('location: main.php');
        } else {
            // $sql = mysqli_query($conn, "UPDATE db_login SET flag_login = '1' WHERE username = '$Username' AND password = '$Password'");
    
            $_SESSION['username'] = $Username;
            $_SESSION['password'] = $Password;
            $_SESSION['access'] = $Access;
            header('location: main.php');
        }
    } else {
        $_SESSION['pesanError'] = "Username atau Password Anda Salah!";
        header('location: login.php');
    }
} else if (isset($_POST['cek-ktp'])) {

    $NomorKTP = $_POST['no_ktp'];

    $sql = mysqli_query($conn, "SELECT COUNT(*) AS cnt, kecamatan FROM db_ptps WHERE no_ktp = '$NomorKTP'");
    $row = mysqli_fetch_assoc($sql);
    $CountKTP = $row["cnt"];
    $KecamatanPTPS = strtoupper($row["kecamatan"]);

    if ($CountKTP > 0) {
        $sql2 = mysqli_query($conn, "SELECT status FROM db_batch_kecamatan WHERE kecamatan = '$KecamatanPTPS'");
        $row2 = mysqli_fetch_assoc($sql2);
        $Status = $row2["status"];
        if ($Status == "1") {
            $_SESSION['nomor_ktp'] = $NomorKTP;
            $_SESSION['kecamatan_session'] = $KecamatanPTPS;
            header('location: detail-data-ptps.php');
        } else {
            $_SESSION['nomor_ktp'] = '';
            $_SESSION['pesanError'] = "Anda Belum Diperbolehkan Mengkases Pengisian Form!";
            header('location: input-ktp.php');
        }
    } else {
        $_SESSION['nomor_ktp'] = '';
        $_SESSION['pesanError'] = "Nomor KTP Anda Tidak Terdaftar!";
        header('location: input-ktp.php');
    }
} else if (isset($_POST['submit_ppwp'])) {
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
        header('location: form-ppwp.php');
    } else {
        if ($jml_pemilih < $jml_pgn_hak_pilih) {
            $_SESSION['pesanError'] = "Pengguna hak pilih lebih banyak daripada jumlah pemilih";
            header('location: form-ppwp.php');
        } else if ($jml_suara_sah_ppwp < $total_suara_paslon) {
            $_SESSION['pesanError'] = "Total suara paslon lebih banyak daripada jumlah suara sah";
            header('location: form-ppwp.php');
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
            header('location: form-ppwp.php');
        }
    }
} else if (isset($_POST['submit-input-suara'])) {

    // $JumlahSuara = $_POST['jumlah_suara'];
    // $NomorKTP = $_POST['no_ktp'];
    // $KategoriCapil = $_POST['kategori_capil'];
    // $IdCapil = $_POST['id_capil'];
    // $KodePartai = $_POST['kode_partai'];

    // $sql = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_hasil_rekap_dtl WHERE no_ktp = '$NomorKTP' AND kategori_capil = '$KategoriCapil' AND id_mst_capil = '$Id'");
    // $row = mysqli_fetch_assoc($sql);
    // $Count = $row["cnt"];

    // if ($Count == 0) {

    //     if ($KategoriCapil == "DPRD-PROV") {
    //         $sql1 = mysqli_query($conn, "INSERT INTO db_hasil_rekap_dtl (no_ktp, kategori_capil, id_mst_capil, jumlah_suara, tgl_input) VALUES ('$NomorKTP', '$KategoriCapil', '$IdCapil', '$JumlahSuara', NOW())");

    //         if ($sql1) {
    //             $_SESSION['pesan'] = "Data Berhasil Tersimpan!";
    //             header('location: form-partai.php?kc='.$KategoriCapil);
    //         } else {
    //             $_SESSION['pesanError'] = "Data Gagal Tersimpan!";
    //             header('location: form-partai.php?kc='.$KategoriCapil);
    //         }
    //     } else {
    //         $sql1 = mysqli_query($conn, "INSERT INTO db_hasil_rekap_dtl (no_ktp, kategori_capil, kode_partai, id_mst_capil, jumlah_suara, tgl_input) VALUES ('$NomorKTP', '$KategoriCapil', '$KodePartai', '$IdCapil', '$JumlahSuara', NOW())");

    //         if ($sql1) {
    //             $_SESSION['pesan'] = "Data Berhasil Tersimpan!";
    //             header('location: form-partai.php?kp='.$KodePartai.'&kc='.$KategoriCapil);
    //         } else {
    //             $_SESSION['pesanError'] = "Data Gagal Tersimpan!";
    //             header('location: form-partai.php?kp='.$KodePartai.'&kc='.$KategoriCapil);
    //         }
    //     }
    // } else {
    //     header('location: form-partai.php?kp='.$KodePartai.'&kc='.$KategoriCapil);
    // }

    $NomorKTP = $_POST['no_ktp'];
    $KategoriCapil = $_POST['kategori_capil'];
    $KodePartai = $_POST['kode_partai'];
    $IdCapil = $_POST['id_capil'];
    $JumlahDPT = $_POST['jumlah_dpt'];
    $JumlahDPTB = $_POST['jumlah_dptb'];
    $JumlahDPK = $_POST['jumlah_dpk'];
    $JumlahPemilih = $_POST['jumlah_pemilih'];
    $JumlahSuaraSah = $_POST['jumlah_suara_sah'];
    $JumlahSuaraTidakSah = $_POST['jumlah_suara_tidak_sah'];
    $JumlahPenggunaHakPilih = $_POST['jumlah_pengguna_hak_pilih'];
    $PasanganCalon = $_POST['pc'];
    $Src = $_POST['src'];
    $Dapil = $_POST['dapil'];

    $Gambar = $_POST['imagebase64'];

    $msNow = round(microtime(true)*1000);
    $imageId = $NomorKTP."_".$KategoriCapil."_".(String)$msNow;

    if ($KategoriCapil == "DPRD-PROV") {
        $sql = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_hasil_rekap_hdr WHERE no_ktp = '$NomorKTP' AND kategori_capil = '$KategoriCapil' AND id_mst_capil = '$IdCapil'");
    } else {
        $sql = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_hasil_rekap_hdr WHERE no_ktp = '$NomorKTP' AND kategori_capil = '$KategoriCapil' AND kode_partai = '$KodePartai' AND id_mst_capil = '$IdCapil'");
    }
    
    $row = mysqli_fetch_assoc($sql);
    $Count = $row["cnt"];

    if ($Count == 0) {

        $sql1 = mysqli_query($conn, "INSERT INTO db_hasil_rekap_hdr (no_ktp, kategori_capil, kode_partai, id_mst_capil, jumlah_dpt, jumlah_dptb, jumlah_dpk, jumlah_pemilih, jumlah_suara_sah, jumlah_suara_tidak_sah, jumlah_pengguna_hak_pilih, image_id, tgl_input) VALUES ('$NomorKTP', '$KategoriCapil', '$KodePartai', '$IdCapil', '$JumlahDPT', '$JumlahDPTB', '$JumlahDPK', '$JumlahPemilih', '$JumlahSuaraSah', '$JumlahSuaraTidakSah', '$JumlahPenggunaHakPilih', '$imageId', NOW())");

        $sql2 = mysqli_query($conn, "INSERT INTO db_master_image (image_id, imagebase64) VALUES ('$imageId', '$Gambar')");

        if ($sql1 && $sql2) {
            $_SESSION['pesan'] = "Data Berhasil Tersimpan!";
            if ($KategoriCapil == "PPWP") {
                header('location: form-ppwp.php?kc='.$KategoriCapil);
                exit;
            } else if ($KategoriCapil == "DPRD-KAB") {
                header('location: form-partai.php?kp='.$KodePartai.'&kc='.$KategoriCapil.'&dapil='.$Dapil);
                exit;
            } else {
                header('location: form-partai.php?kp='.$KodePartai.'&kc='.$KategoriCapil);
                exit;
            }
        } else {
            $_SESSION['pesanError'] = "Data Gagal Tersimpan!";
            if ($KategoriCapil == "PPWP") {
                header('location: form-ppwp-submit.php?id='.$IdCapil.'&pc='.$PasanganCalon.'&src='.$Src);
                exit;
            } else if ($KategoriCapil == "DPRD-KAB") {
                header('location: form-partai.php?kp='.$KodePartai.'&kc='.$KategoriCapil.'&dapil='.$Dapil);
                exit;
            } else {
                header('location: form-partai-submit.php?kc='.$KategoriCapil.'&id='.$IdCapil.'&kp='.$KodePartai);
                exit;
            }
            
        }
    } else {
        if ($KategoriCapil == "PPWP") {
            header('location: form-ppwp-submit.php?id='.$IdCapil.'&pc='.$PasanganCalon.'&src='.$Src);
            exit;
        } else if ($KategoriCapil == "DPRD-KAB") {
            header('location: form-partai.php?kp='.$KodePartai.'&kc='.$KategoriCapil.'&dapil='.$Dapil);
            exit;
        } else {
            header('location: form-partai-submit.php?kc='.$KategoriCapil.'&id='.$IdCapil.'&kp='.$KodePartai);
            exit;
        }
    }
} else if (isset($_POST['submit-form-ppwp'])) {
    
    $NomorKTP = $_POST['no_ktp'];
    $KategoriCapil = $_POST['kategori_capil'];
    $KodePartai = $_POST['kode_partai'];

    $JumlahSuaraDPT = $_POST['jumlah_suara_dpt'];
    $JumlahSuaraDPTB = $_POST['jumlah_suara_dptb'];
    $JumlahSuaraDPK = $_POST['jumlah_suara_dpk'];

    $JumlahSuaraSah = $_POST['jumlah_suara_sah'];
    $JumlahSuaraTidakSah = $_POST['jumlah_suara_tidak_sah'];
    $JumlahPenggunaHakPilih = $_POST['jumlah_pengguna_hak_pilih'];

    $PasanganCalon = $_POST['pc'];
    $Src = $_POST['src'];
    $Dapil = $_POST['dapil'];

    $arr_data_paslon = [
        [
            "id_mst_capil" => 1,
            "jumlah_suara" => $_POST['jumlah_suara_1'],
            "gambar" => $_POST['imagebase64-1'],
            "file_name" => $_POST['imagebase64FileName-1']
        ],
        [
            "id_mst_capil" => 3,
            "jumlah_suara" => $_POST['jumlah_suara_3'],
            "gambar" => $_POST['imagebase64-2'],
            "file_name" => $_POST['imagebase64FileName-2']
        ],
        [
            "id_mst_capil" => 5,
            "jumlah_suara" => $_POST['jumlah_suara_5'],
            "gambar" => $_POST['imagebase64-3'],
            "file_name" => $_POST['imagebase64FileName-3']
        ]
    ];

    foreach ($arr_data_paslon as $data_paslon) {
        $id_mst_capil = $data_paslon['id_mst_capil'];
        $jumlah_suara = $data_paslon['jumlah_suara'];
        $file_name = $data_paslon['file_name'];

        $FormatImage = "FORM-SUARA-PPWP";
        // $msNow = round(microtime(true)*1000);
        $newFilename = str_replace(" ", "", $file_name);

        $imageId = $NomorKTP."_".$KategoriCapil."_".$FormatImage."_".$newFilename;
        $Gambar = $data_paslon['gambar'];
        $newGambar = str_replace("data:image/png;base64,", "", $Gambar);

        // echo $imageId;
        // echo "<br>";
        // echo $newFilename;
        // echo "<br>";
        // echo $newGambar;
        // echo "<br>";

        $sql = mysqli_query($conn, "INSERT INTO db_hasil_rekap_dtl (no_ktp, kategori_capil, id_mst_capil, jumlah_suara, image_id) VALUES ('$NomorKTP', '$KategoriCapil', '$id_mst_capil', '$jumlah_suara', '$imageId')");

        $sql3 = mysqli_query($conn, "INSERT INTO db_master_image (image_id, imagebase64) VALUES ('$imageId', '$newGambar')");
    }

    $sql2 = mysqli_query($conn, "INSERT INTO db_hasil_rekap_hdr (no_ktp, kategori_capil, jumlah_dpt, jumlah_dptb, jumlah_dpk, jumlah_suara_sah, jumlah_suara_tidak_sah, jumlah_pengguna_hak_pilih) VALUES ('$NomorKTP', '$KategoriCapil', '$JumlahSuaraDPT', '$JumlahSuaraDPTB', '$JumlahSuaraDPK', '$JumlahSuaraSah', '$JumlahSuaraTidakSah', '$JumlahPenggunaHakPilih')");

    if ($sql && $sql2 && $sql3) {
        $_SESSION['pesan'] = "Berhasil Input Data PPWP";
        header('location: form-ppwp.php?kc='.$KategoriCapil);
    } else {
        $_SESSION['pesan'] = "Gagal Input Data PPWP";
        header('location: form-ppwp.php?kc='.$KategoriCapil);
    }

} else if (isset($_POST['submit-form-partai'])) {
    
    $NomorKTP = $_POST['no_ktp'];
    $KategoriCapil = $_POST['kategori_capil'];
    $KodePartai = $_POST['kode_partai'];
    $Id = $_POST['id_mst_capil'];
    $JumlahSuara = $_POST['jumlah_suara'];
    $Dapil = $_POST['dapil'];
    // $Gambar = $_POST['imagebase64'];

    // $msNow = round(microtime(true)*1000);
    // $imageId = $NomorKTP."_".$KategoriCapil."_".(String)$msNow;
    
    $sql = mysqli_query($conn, "INSERT INTO db_hasil_rekap_dtl (no_ktp, kategori_capil, kode_partai, id_mst_capil, jumlah_suara) VALUES ('$NomorKTP', '$KategoriCapil', '$KodePartai', '$Id', '$JumlahSuara')");

    // $sql2 = mysqli_query($conn, "INSERT INTO db_master_image (image_id, imagebase64) VALUES ('$imageId', '$Gambar')");

    if ($sql) {
        if ($KategoriCapil == "DPRD-KAB") {
            // $_SESSION['pesan'] = "Berhasil Input Data";
            header('location: form-partai.php?kc='.$KategoriCapil.'&kp='.$KodePartai.'&dapil='.$Dapil);
        } else {
            // $_SESSION['pesan'] = "Berhasil Input Data";
            header('location: form-partai.php?kc='.$KategoriCapil.'&kp='.$KodePartai);
        }
    } else {
        if ($KategoriCapil == "DPRD-KAB") {
            // $_SESSION['pesan'] = "Berhasil Input Data";
            header('location: form-partai.php?kc='.$KategoriCapil.'&kp='.$KodePartai.'&dapil='.$Dapil);
        } else {
            // $_SESSION['pesan'] = "Berhasil Input Data";
            header('location: form-partai.php?kc='.$KategoriCapil.'&kp='.$KodePartai);
        }
    }
} else if (isset($_POST['submit-form-partai-2'])) {

    $NomorKTP = $_POST['no_ktp'];
    $KategoriCapil = $_POST['kategori_capil'];

    $JumlahSuaraDPT = $_POST['jumlah_suara_dpt'];
    $JumlahSuaraDPTB = $_POST['jumlah_suara_dptb'];
    $JumlahSuaraDPK = $_POST['jumlah_suara_dpk'];
    $JumlahSuaraSah = $_POST['jumlah_suara_sah'];
    $JumlahSuaraTidakSah = $_POST['jumlah_suara_tidak_sah'];
    $JumlahPenggunaHakPilih = $_POST['jumlah_pengguna_hak_pilih'];

    if ($KategoriCapil == "DPR-RI") {
        $FormatImage = "FORM-SUARA-DPR-RI";
    } else if ($KategoriCapil == "DPRD-PROV") { 
        $FormatImage = "FORM-SUARA-DPRD-PROV";
    } else if ($KategoriCapil == "DPRD-KAB") {
        $FormatImage = "FORM-SUARA-DPRD-KAB";
    } else if ($KategoriCapil == "DPD-RI") {
        $FormatImage = "FORM-SUARA-DPD-RI";
    }

    $sql = mysqli_query($conn, "INSERT INTO db_hasil_rekap_hdr (no_ktp, kategori_capil, jumlah_dpt, jumlah_dptb, jumlah_dpk, jumlah_suara_sah, jumlah_suara_tidak_sah, jumlah_pengguna_hak_pilih) VALUES ('$NomorKTP', '$KategoriCapil', '$JumlahSuaraDPT', '$JumlahSuaraDPTB', '$JumlahSuaraDPK', '$JumlahSuaraSah', '$JumlahSuaraTidakSah', '$JumlahPenggunaHakPilih')");

    if(isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
        $uploadedImages = $_FILES['images'];        

        foreach($uploadedImages['name'] as $key => $imageName) {
            $tmpName = $uploadedImages['tmp_name'][$key];
            $filename = $_FILES['images']['name'][$key];
            $newFilename = str_replace(" ", "", $filename);
    
            $msNow = round(microtime(true)*1000);
            $imageId = $NomorKTP . "_" . $KategoriCapil . "_" . $FormatImage . "_" . $newFilename;
            // $imageId = $NomorKTP . "_" . $KategoriCapil . "_" . $FormatImage . "_" . (String)$msNow;
            $imageContent = file_get_contents($tmpName);
            $encodedImage = base64_encode($imageContent);

            // echo $encodedImage;
    
            $sqlInsert = mysqli_query($conn, "INSERT INTO db_master_image (image_id, imagebase64) VALUES ('$imageId', '$encodedImage')");
        }
        $ErrorCode = "0";
    }

    if ($sql && $ErrorCode == "0") {
        $_SESSION['pesan'] = "Berhasil Input Data";
        header('location: form-partai-2.php?kc='.$KategoriCapil);
    } else {
        $_SESSION['pesanError'] = "Gagal Input Data";
        header('location: form-partai-2.php?kc='.$KategoriCapil);
    }

} else if (isset($_POST['submit-form-insert-ptps'])) {

    $Kecamatan = $_POST['kecamatan'];
    $Kelurahan = $_POST['kelurahan'];
    $Nama = $_POST['nama'];
    $NomorKTP = $_POST['nomor_ktp'];
    $NomorTPS = $_POST['nomor_tps'];
    $Dapil = $_POST['dapil'];

    $sql = mysqli_query($conn, "SELECT COUNT(1) cnt FROM db_ptps WHERE no_tps = '$NomorTPS' AND kecamatan = '$Kecamatan' AND kelurahan = '$Kelurahan'");
    $row = mysqli_fetch_assoc($sql);
    $Count = $row["cnt"];
    if ($Count > 0 ) {
        $_SESSION['pesanError'] = "Sudah Terdapat PTPS di TPS Kecamatan " . $Kecamatan . " Kelurahan " . $Kelurahan ." No. " . $NomorTPS;
        header('location: master-ptps.php');
    } else {
        $sql1 = mysqli_query($conn, "SELECT COUNT(1) cnt FROM db_ptps WHERE nama = '$Nama' AND no_ktp = '$NomorKTP'");
        $row1 = mysqli_fetch_assoc($sql1);
        $Count1 = $row1["cnt"];
        if ($Count1 > 0) {
            $_SESSION['pesanError'] = "PTPS sudah pernah didaftarkan";
        header('location: master-ptps.php');
        } else {
            $sql2 = mysqli_query($conn, "INSERT INTO db_ptps (kecamatan, kelurahan, no_tps, no_ktp, nama, dapil_kab) VALUES ('$Kecamatan', '$Kelurahan', '$NomorTPS', '$NomorKTP', '$Nama' ,'$Dapil')");

            if ($sql2) {
                $_SESSION['pesan'] = "Berhasil Input Data";
                header('location: master-ptps.php');
            } else {
                $_SESSION['pesanError'] = "Gagal Input Data";
                header('location: master-ptps.php');
            }
        }
    }

} else if (isset($_POST['submit-form-update-ptps'])) {
    $id = $_POST['id'];
    $Kecamatan = $_POST['kecamatan'];
    $Kelurahan = $_POST['kelurahan'];
    $Nama = $_POST['nama'];
    $NomorKTP = $_POST['nomor_ktp'];
    $NomorTPS = $_POST['nomor_tps'];
    $Dapil = $_POST['dapil'];

    $sql = mysqli_query($conn, "SELECT COUNT(1) cnt FROM db_ptps WHERE no_tps = '$NomorTPS' AND kecamatan = '$Kecamatan' AND kelurahan = '$Kelurahan' and id <> '$id'");
    $row = mysqli_fetch_assoc($sql);
    $Count = $row["cnt"];
    if ($Count > 0 ) {
        $_SESSION['pesanError'] = "Sudah Terdapat PTPS di TPS Kecamatan " . $Kecamatan . " Kelurahan " . $Kelurahan ." No. " . $NomorTPS;
        header('location: master-ptps.php');
    } else {
        $sql1 = mysqli_query($conn, "SELECT COUNT(1) cnt FROM db_ptps WHERE nama = '$Nama' AND no_ktp = '$NomorKTP' AND id <> '$id'");
        $row1 = mysqli_fetch_assoc($sql1);
        $Count1 = $row1["cnt"];
        if ($Count1 > 0) {
            $_SESSION['pesanError'] = "PTPS sudah pernah didaftarkan";
        header('location: master-ptps.php');
        } else {
            $sql2 = mysqli_query($conn, "UPDATE db_ptps SET kecamatan = '$Kecamatan', kelurahan = '$Kelurahan', no_tps = '$NomorTPS', no_ktp = '$NomorKTP', nama = '$Nama', dapil_kab = '$Dapil' WHERE id = '$id'");

            if ($sql2) {
                $_SESSION['pesan'] = "Berhasil Update Data";
                header('location: master-ptps.php');
            } else {
                $_SESSION['pesanError'] = "Gagal Update Data";
                header('location: master-ptps.php');
            }
        }
    }
    
} else if (isset($_GET['delete-ptps'])) {
    $IdDelete = $_GET['deleteID'];

    $query = "DELETE FROM db_ptps WHERE id = '$IdDelete'";    
    
    if (!$results = mysqli_query($conn, $query)) {
        echo 600;
    } else {
        echo 200;
    }

} else if (isset($_POST['submit-form-partai-image'])) {

    // $files = $_FILES;

    // echo "<pre>";
    // print_r($files);
    // echo "</pre>";

    $folderUpload = "./assets/uploads";

    # periksa apakah folder tersedia
    if (!is_dir($folderUpload)) {
        # jika tidak maka folder harus dibuat terlebih dahulu
        mkdir($folderUpload, 0777, $rekursif = true);
    }

    $files = $_FILES;
    $jumlahFile = count($files['listGambar']['name']);

    for ($i = 0; $i < $jumlahFile; $i++) {
        $namaFile = $files['listGambar']['name'][$i];
        $lokasiTmp = $files['listGambar']['tmp_name'][$i];

        echo "nama: $namaFile, tmp: {$lokasiTmp} <br>";
    }

} else if (isset($_POST['submit-form-suara-partai'])) {

    $NomorKTP = $_POST['no_ktp'];
    $KategoriCapil = $_POST['kategori_capil'];
    $KodePartai = $_POST['kode_partai'];
    $Dapil = $_POST['dapil'];
    $JumlahSuaraPartai = $_POST['jumlah_suara_partai'];

    $sql = mysqli_query($conn, "INSERT INTO db_hasil_rekap_suara_partai (no_ktp, kategori_capil, kode_partai, jumlah_suara) VALUES ('$NomorKTP', '$KategoriCapil', '$KodePartai', '$JumlahSuaraPartai')");

    if ($sql) {
        if ($KategoriCapil == "DPRD-KAB") {
            header('location: form-partai.php?kc='.$KategoriCapil.'&kp='.$KodePartai.'&dapil='.$Dapil);
        } else {
            header('location: form-partai.php?kc='.$KategoriCapil.'&kp='.$KodePartai);
        }
    } else {
        if ($KategoriCapil == "DPRD-KAB") {
            header('location: form-partai.php?kc='.$KategoriCapil.'&kp='.$KodePartai.'&dapil='.$Dapil);
        } else {
            header('location: form-partai.php?kc='.$KategoriCapil.'&kp='.$KodePartai);
        }
    }
} else if (isset($_POST['submit-batch-kecamatan'])) {

    $NomorBatch = $_POST['nomor_batch'];
    $StatusBatch = $_POST['status_batch'];

    $Status = "";
    if ($StatusBatch == "1") {
        $Status = "0";
        $sql = mysqli_query($conn, "UPDATE db_batch_kecamatan SET status_all = '0' WHERE nomor_batch = '$NomorBatch'");
    } else {
        $Status = "1";
        $sql = mysqli_query($conn, "UPDATE db_batch_kecamatan SET status_all = '1' WHERE nomor_batch = '$NomorBatch'");
    }

    $sql2 = mysqli_query($conn, "UPDATE db_batch_kecamatan SET status = '$Status' WHERE nomor_batch = '$NomorBatch'");

    if ($sql && $sql2) {
        $_SESSION['pesan'] = "Berhasil Update Data";
        header('location: batch-kecamatan.php');
    } else {
        $_SESSION['pesanError'] = "Gagal Update Data";
        header('location: batch-kecamatan.php');
    }
} else if (isset($_POST['submit-kecamatan'])) {

    $Kecamatan = $_POST['kecamatan'];
    $StatusKecamatan = $_POST['status_kecamatan'];
    $NomorBatch = $_POST['nomor_batch'];
    $TotalKecamatan = $_POST['total_kecamatan'];

    $Status = "";
    if ($StatusKecamatan == "1") {
        // toggle aktif ke tidak aktif
        $Status = "0";
    } else {
        // toggle tidak aktif ke aktif
        $Status = "1";
    }

    $sql2 = mysqli_query($conn, "UPDATE db_batch_kecamatan SET status = '$Status' WHERE kecamatan = '$Kecamatan'");

    $Status = "";
    if ($StatusKecamatan == "1") {
        // toggle aktif ke tidak aktif
        $query = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_batch_kecamatan WHERE nomor_batch = '$NomorBatch' AND status = '0' ");
        $row = mysqli_fetch_assoc($query);
        $TotalkecamatanDB = $row['cnt'];

        if ($TotalkecamatanDB == $TotalKecamatan) {
            $sql = mysqli_query($conn, "UPDATE db_batch_kecamatan SET status_all = '0' WHERE nomor_batch = '$NomorBatch'");
        } else {
            $sql = mysqli_query($conn, "UPDATE db_batch_kecamatan SET status_all = '1' WHERE nomor_batch = '$NomorBatch'");
        }
    } else {
        // toggle tidak aktif ke aktif
        $query = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_batch_kecamatan WHERE nomor_batch = '$NomorBatch' AND status = '1' ");
        $row = mysqli_fetch_assoc($query);
        $TotalkecamatanDB = $row['cnt'];

        if ($TotalkecamatanDB == $TotalKecamatan) {
            $sql = mysqli_query($conn, "UPDATE db_batch_kecamatan SET status_all = '1' WHERE nomor_batch = '$NomorBatch'");
        } else {
            $sql = mysqli_query($conn, "UPDATE db_batch_kecamatan SET status_all = '0' WHERE nomor_batch = '$NomorBatch'");
        }
    } 

    if ($sql && $sql2) {
        $_SESSION['pesan'] = "Berhasil Update Data";
        header('location: batch-kecamatan.php');
    } else {
        $_SESSION['pesanError'] = "Gagal Update Data";
        header('location: batch-kecamatan.php');
    }
}

mysqli_close($conn);