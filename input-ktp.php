<?php

require_once('header.php');

session_start();

?>

<main>
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
                window.location.href='detail-data-ptps.php';
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
                window.location.href='input-ktp.php';
            });
            </script>";
            unset($_SESSION['pesanError']);
        }
        ?>

        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                        <div class="card mb-3">

                            <div class="card-body">

                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="col-sm-8 mb-8 mb-sm-0">
                                        <img src="assets/img/bawaslu/logo_bawaslu_kab_bekasi.png" style="width: 100%;padding-top: 15px" />
                                    </div>
                                </div>

                                <div class="pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4">BAWASLU Kab. Bekasi</h5>
                                    <div style="text-align: center;font-weight: bold;">Verifikasi Nomor KTP PTPS Kab. Bekasi</div>
                                    <hr/>
                                    <div class="alert alert-info" role="alert" style="font-weight: bold;">
                                        Silahkan Input Nomor KTP Anda Untuk Melakukan Verifikasi
                                    </div>
                                </div>

                                <form class="row g-3 needs-validation" method="POST" action="proses.php">

                                    <div class="col-12">
                                        <div class="input-group">
                                            <input type="text" name="no_ktp" class="form-control" style="text-align: center;font-weight: bold;height:75px;font-size: 30px;" required>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button name="cek-ktp" class="btn btn-primary w-100" type="submit">Submit</button>
                                    </div>
                                </form>

                                <hr/>

                                <div class="col-12">
                                    <a href="index.php" name="cek-ktp" class="btn btn-danger w-100">Back</a>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </section>

    </div>
</main>
<!-- End #main -->

<?php

require_once('footer.php');

?>