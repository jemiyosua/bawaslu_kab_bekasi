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

<?php
if (isset($_POST['submit_ppwp'])) {
    if (count($_FILES) > 0) {
        if (is_uploaded_file($_FILES['ifImage']['tmp_name'])) {
            $imgData = addslashes(file_get_contents($_FILES['ifImage']['tmp_name']));
            $imgType = $_FILES['ifImage']['type'];
            // $sql = "INSERT INTO tbl_image(imageType ,imageData) VALUES(?, ?)";

            echo $imgData;

            echo "<script>
            Swal.fire({
                allowEnterKey: false,
                allowOutsideClick: false,
                icon: 'success',
                title: 'OKEE:)',
                text: '" . $_FILES['ifImage']['name'].$imgType."'
            })
            </script>";
        } else {
            echo "<script>
            Swal.fire({
                allowEnterKey: false,
                allowOutsideClick: false,
                icon: 'warning',
                title: 'EMPTY:)',
                text: 'File belum diupload'
            })
            </script>";
        }
    }
}
?>

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
                            window.location.href='form-main.php';
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
                            window.location.href='form_ppwp.php';
                        });
                        </script>";
                    unset($_SESSION['pesanError']);
                }

                ?>
                
                <!-- <div class="col-sm-12 mb-6 mb-sm-0 mt-3">
                    <div class="card"> -->

                        <form class="row g-3 needs-validation" method="POST" action="proses.php" enctype="multipart/form-data">
                        <!-- <form class="row g-3 needs-validation" method="POST" action="form_ppwp.php" enctype="multipart/form-data"> -->
                            <div class="mb-3">
                                <h6 class="card-title text-center pb-0 fs-4">FORM REKAP PERHITUNGAN SUARA PILPRES</h6>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                    
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="mb-3 mt-3">
                                                    <img src="assets/img/bawaslu/capres01.jpg" class="card-img-top">
                                                </div>
                                                <div class="mb_3">
                                                    <input type="text" placeholder="0" style="text-align: center;font-weight: bold;height:75px;font-size: 30px;" name="it-paslon-01" class="form-control" onkeypress="return isNumberKey(event)" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="mb-3 mt-3">
                                                    <img src="assets/img/bawaslu/capres02.jpg" class="card-img-top">
                                                </div>
                                                <div class="mb_3">
                                                    <input type="text" placeholder="0" style="text-align: center;font-weight: bold;height:75px;font-size: 30px;" name="it-paslon-02" class="form-control" onkeypress="return isNumberKey(event)" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="mb-3 mt-3">
                                                    <img src="assets/img/bawaslu/capres03.jpg" class="card-img-top">
                                                </div>
                                                <div class="mb_3">
                                                    <input type="text" placeholder="0" style="text-align: center;font-weight: bold;height:75px;font-size: 30px;" name="it-paslon-03" class="form-control" onkeypress="return isNumberKey(event)" aria-rowspan="2" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- <hr/>

                                    <div class="col-4 mb-3">
                                        <button name="submit_ppwp" class="btn btn-success w-100" type="submit"><i class="bi bi-check-circle-fill"></i> Submit</button>
                                    </div> -->
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-6 mb-6 mb-sm-0 mt-3">
                                                    <div class="mb-3">
                                                        <label for="jml_dpt_ppwp" class="form-label" style="font-weight: bold;">Jumlah DPT(Daftar Pemilih Tetap)</label>
                                                        <input type="text" min=0 name="jml_dpt_ppwp" id="itDptPpwp" class="form-control" placeholder="0" onchange="jmlPemilih()" onkeypress="return isNumberKey(event)" required>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 mb-6 mb-sm-0 mt-3">
                                                    <div class="mb-3">
                                                        <label for="itDptbPpwp" class="form-label" style="font-weight: bold;">Jumlah DPTb(Daftar Pemilih Tambahan)</label>
                                                        <input id="itDptbPpwp" type="text" min=0 name="jml_dptb_ppwp" class="form-control" placeholder="0" onchange="jmlPemilih()" onkeypress="return isNumberKey(event)" required>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 mb-6 mb-sm-0 mt-3">
                                                    <div class="mb-3">
                                                        <label for="itDpkPpwp" class="form-label" style="font-weight: bold;">Jumlah DPK(Daftar Pemilih Khusus)</label>
                                                        <input id="itDpkPpwp" type="text" min=0 name="jml_dpk_ppwp" class="form-control" placeholder="0" onchange="jmlPemilih()" onkeypress="return isNumberKey(event)" required>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 mb-6 mb-sm-0 mt-3">
                                                    <div class="mb-3">
                                                        <label for="itJmlPemilih" class="form-label" style="font-weight: bold;">Jumlah Pemilih</label>
                                                        <input id="itJmlPemilih" type="text" min=0 name="jml_pemilih" class="form-control" placeholder="0" style="background-color: #d1d0cd;" readonly>
                                                    </div>
                                                </div>

                                                <hr/>

                                                <div class="col-sm-6 mb-6 mb-sm-0 mt-3">
                                                    <div class="mb-3">
                                                        <label for="itJmlSuaraSah" class="form-label" style="font-weight: bold;">Jumlah Suara Sah </label>
                                                        <input id="itJmlSuaraSah" type="text" min=0 name="jml_suara_sah_ppwp" class="form-control" placeholder="0" onchange="jmlPenggunaHakPilih()" onkeypress="return isNumberKey(event)" required>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 mb-6 mb-sm-0 mt-3">
                                                    <div class="mb-3">
                                                        <label for="itJmlSuaraTdkSah" class="form-label" style="font-weight: bold;">Jumlah Suara Tidak Sah</label>
                                                        <input id="itJmlSuaraTdkSah" type="text" min=0 name="jml_suara_tdk_sah_ppwp" class="form-control" placeholder="0" onchange="jmlPenggunaHakPilih()" onkeypress="return isNumberKey(event)" required>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 mb-6 mb-sm-0 mt-3">
                                                    <div class="mb-3">
                                                        <label for="itjmlPgnHakPilih" class="form-label" style="font-weight: bold;">Jumlah Pengguna Hak Pilih</label>
                                                        <input id="itjmlPgnHakPilih" type="number" min=0 style="background-color: #d1d0cd;" name="jml_pgn_hak_pilih" class="form-control" placeholder="0" readonly>
                                                    </div>
                                                </div>

                                                <hr/>

                                                <div class="col-sm-6 mb-6 mb-sm-0 mt-3">
                                                    <div>
                                                        <label for="ifC1Ppwp" class="form-label" style="font-weight: bold;">C1-Hasil-PPWP</label>
                                                        <input class="form-control form-control" name="ifImage" id="ifC1Ppwp" type="file" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr/>

                                            <div class="col-3 mt-3">
                                                <button name="submit_ppwp" class="btn btn-success w-100" type="submit"><i class="bi bi-check-circle-fill"></i> Submit</button>
                                            </div>

                                        </div>
                                    </div>

                                   

                                </div>

                            </div>

                        </form>
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