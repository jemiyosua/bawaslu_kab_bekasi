<?php

require_once('header.php');

session_start();

$_SESSION['kategori_capil'] = "PPWP";

?>

<script type="text/javascript">
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

    <form class="row g-3 needs-validation" method="POST" action="proses.php" enctype="multipart/form-data">
    <!-- <form class="row g-3 needs-validation" method="POST" action="form_ppwp.php" enctype="multipart/form-data"> -->
        <div class="mb-3">
            <h6 class="card-title text-center pb-0 fs-4">FORM REKAP PERHITUNGAN SUARA PILPRES</h6>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-12 d-flex flex-column align-items-center justify-content-center">

                <div class="row">
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-2 mt-2">
                                    <img src="assets/img/capres01.jpg" class="card-img-top">
                                </div>
                                <div class="mb_3">
                                    <input type="number" min=0 style="height: 80px;" name="it-paslon-01" class="form-control" placeholder="Paslon 1" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-2 mt-2">
                                    <img src="assets/img/capres02.jpg" class="card-img-top">
                                </div>
                                <div class="mb_3">
                                    <input style="height: 80px;" type="number" min=0 name="it-paslon-02" class="form-control" placeholder="Paslon 2" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-2 mt-2">
                                    <img src="assets/img/capres03.jpg" class="card-img-top">
                                </div>
                                <div class="mb_3">
                                    <input style="height: 80px;" type="number" min=0 name="it-paslon-03" class="form-control" aria-rowspan="2" placeholder="Paslon 3" required>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>


        <div class="mb_3">
            <label for="jml_dpt_ppwp" class="form-label" style="font-weight: bold;">Jumlah DPT(Daftar Pemilih Tetap)</label>
            <input type="number" min=0 name="jml_dpt_ppwp" id="itDptPpwp" class="form-control" placeholder="0" onchange="jmlPemilih()" required>
        </div>
        <div class="mb_3">
            <label for="itDptbPpwp" class="form-label" style="font-weight: bold;">Jumlah DPTb(Daftar Pemilih Tambahan)</label>
            <input id="itDptbPpwp" type="number" min=0 name="jml_dptb_ppwp" class="form-control" placeholder="0" onchange="jmlPemilih()" required>
        </div>


        <div class="mb_3">
            <label for="itDpkPpwp" class="form-label" style="font-weight: bold;">Jumlah DPK(Daftar Pemilih Khusus)</label>
            <input id="itDpkPpwp" type="number" min=0 name="jml_dpk_ppwp" class="form-control" placeholder="0" onchange="jmlPemilih()" required>
        </div>

        <div class="mb_3">
            <label for="itJmlPemilih" class="form-label" style="font-weight: bold;">Jumlah Pemilih</label>
            <input id="itJmlPemilih" type="number" min=0 name="jml_pemilih" class="form-control" placeholder="0" style="background-color: #d1d0cd;" readonly>
        </div>

        <div class="mb_3">
            <label for="itJmlSuaraSah" class="form-label" style="font-weight: bold;">Jumlah Suara Sah </label>
            <input id="itJmlSuaraSah" type="number" min=0 name="jml_suara_sah_ppwp" class="form-control" placeholder="0" onchange="jmlPenggunaHakPilih()" required>
        </div>

        <div class="mb_3">
            <label for="itJmlSuaraTdkSah" class="form-label" style="font-weight: bold;">Jumlah Suara Tidak Sah</label>
            <input id="itJmlSuaraTdkSah" type="number" min=0 name="jml_suara_tdk_sah_ppwp" class="form-control" placeholder="0" onchange="jmlPenggunaHakPilih()" required>
        </div>

        <div class="mb_3">
            <label for="itjmlPgnHakPilih" class="form-label" style="font-weight: bold;">Jumlah Pengguna Hak Pilih</label>
            <input id="itjmlPgnHakPilih" type="number" min=0 style="background-color: #d1d0cd;" name="jml_pgn_hak_pilih" class="form-control" placeholder="0" readonly>
        </div>

        <div>
            <label for="ifC1Ppwp" class="form-label" style="font-weight: bold;">C1-Hasil-PPWP</label>
            <input class="form-control form-control-lg" name="ifImage" id="ifC1Ppwp" type="file" required>
        </div>

        <div class="col-12">
            <button name="submit_ppwp" class="btn btn-primary w-100" type="submit">Submit</button>
        </div>
    </form>

    <hr />
    <div class="col-12 mb-4">
        <a href="form-main.php" class="btn btn-danger w-100">Back</a>
    </div>

</div>


<?php

require_once('footer.php');

?>