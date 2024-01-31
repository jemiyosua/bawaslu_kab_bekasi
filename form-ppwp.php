<?php

session_start();

$KategoriCapil = $_GET['kc'];
$_SESSION['kc'] = $KategoriCapil;
$_SESSION['page'] = "";
$_SESSION['page'] = "form-ppwp";

require_once('header.php');

require_once('navbar-form.php');

require_once('sidebar-form.php');

require_once('koneksi.php');

?>

<script type="text/javascript">

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    }

    function jmlPemilih() {
        var jmlDpt = document.getElementById("itDptPpwp").value == "" ? "0" : document.getElementById("itDptPpwp").value;
        var jmlDptb = document.getElementById("itDptbPpwp").value == "" ? "0" : document.getElementById("itDptbPpwp").value;
        var jmlDpk = document.getElementById("itDpkPpwp").value == "" ? "0" : document.getElementById("itDpkPpwp").value;

        var totPemilih = parseInt(jmlDpt) + parseInt(jmlDptb) + parseInt(jmlDpk);

        document.getElementById("itJmlPemilih").value = totPemilih.toString();

    };

    function jmlPenggunaHakPilih() {
        var jmlSuaraSah = document.getElementById("itJmlSuaraSah").value == "" ? "0" : document.getElementById("itJmlSuaraSah").value;
        var jmlSuaraTdkSah = document.getElementById("itJmlSuaraTdkSah").value == "" ? "0" : document.getElementById("itJmlSuaraTdkSah").value;

        var totPenggunaHakPilih = parseInt(jmlSuaraSah) + parseInt(jmlSuaraTdkSah);

        document.getElementById("itjmlPgnHakPilih").value = totPenggunaHakPilih.toString();

    };
</script>

<main id="main" class="main">

    <section class="section dashboard">
		<div class="row">

            <div class="container">
                <?php
                if (isset($_SESSION['pesan'])) {
                    echo "<script>
                        Swal.fire({
                            allowEnterKey: false,
                            allowOutsideClick: false,
                            icon: 'success',
                            title: 'Good Job :)',
                            text: '" . $_SESSION['pesan'] . "'
                        }).then(function() {
                            window.location.href='form-ppwp.php?kc=PPWP';
                        });
                        </script>";
                    unset($_SESSION['pesan']);
                } else if (isset($_SESSION['pesanError'])) {
                    echo "<script>
                        Swal.fire({
                            allowEnterKey: false,
                            allowOutsideClick: false,
                            icon: 'error',
                            title: 'Sorry :(',
                            text: '" . $_SESSION['pesanError'] . "'
                        }).then(function() {
                            window.location.href='form-ppwp.php?kc=PPWP';
                        });
                        </script>";
                    unset($_SESSION['pesanError']);
                }

                ?>
                
                <!-- <div class="col-sm-12 mb-6 mb-sm-0 mt-3">
                    <div class="card"> -->

                            <div class="mb-3">
                                <h6 class="card-title text-center pb-0 fs-4">FORM REKAP PERHITUNGAN SUARA PILPRES</h6>
                            </div>
                            <!-- <div class="d-flex justify-content-between align-items-center"> -->
                            <div class="row">

                                <?php
                                
                                $sql = mysqli_query($conn, "SELECT id, no_urut, nama, status FROM db_master_capres_cawapres");
                                while($row = mysqli_fetch_assoc($sql)) {

                                    $Id = $row["id"];
                                    $NomorUrut = $row["no_urut"];
                                    $Nama = $row["nama"];
                                    $Status = $row["status"];

                                    $Src = "";
                                    if ($NomorUrut == "1") {
                                        $Src = "assets/img/bawaslu/capres01.jpg";
                                    } else if ($NomorUrut == "2") {
                                        $Src = "assets/img/bawaslu/capres02.jpg";
                                    } else if ($NomorUrut == "3") {
                                        $Src = "assets/img/bawaslu/capres03.jpg";
                                    }

                                    ?>

                                    <div class="col-sm-4 mb-3 mb-sm-0">
                                        <div class="card">
                                            <div class="card-body">
                                                <img src="<?= $Src ?>" style="display: block;margin: auto;margin-top: 30px;">
                                                <?php

                                                if ($NomorUrut == "1") {
                                                    $KodePartai = "PPWP01";
                                                } else if ($NomorUrut == "2") {
                                                    $KodePartai = "PPWP02";
                                                } else if ($NomorUrut == "3") {
                                                    $KodePartai = "PPWP03";
                                                }
                                                                                                
                                                $sql2 = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_hasil_rekap_hdr WHERE no_ktp = '$NomorKTP' AND kategori_capil = 'PPWP' AND kode_partai = '$KodePartai'");
                                                $row2 = mysqli_fetch_assoc($sql2);
                                                $CountIsi = $row2['cnt'];

                                                if ($CountIsi > 0) {

                                                    ?>
                                                    
                                                    <div class="alert alert-success" role="alert" style="margin-top: 30px;font-weight: bold;">
                                                        Anda Sudah Mengisi Suara Untuk Pasangan Calon Nomor Urut <?= $NomorUrut ?>
                                                    </div>

                                                    <?php

                                                } else {

                                                    ?>
                                                    
                                                    <a href="form-ppwp-submit.php?id=<?=$Id?>&pc=<?=$NomorUrut?>&src=<?=$Src?>" type="button" class="btn btn-outline-primary" style="display: block;margin: auto;margin-top: 30px;width=50%">Input Suara</a>

                                                    <?php
                                                }
                                                
                                                ?>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- <div class="col-sm-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="mb-3 mt-3">
                                                    <img src="<?= $Src ?>">
                                                </div>
                                                <div class="mb_3">
                                                    <a href="form-ppwp-submit.php?id=<?=$Id?>&pc=<?=$NomorUrut?>&src=<?=$Src?>" type="button" class="btn btn-outline-warning">Input Suara</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->

                                    <?php

                                }
                                
                                
                                ?> 

                            </div>
                            <!-- </div> -->

                    <!-- </div>
                </div> -->


                    
                </form>

            </div>

        </div>
    </section>
</main>


<?php

require_once('footer.php');

?>