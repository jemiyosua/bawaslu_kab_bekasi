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

                            <div class="pt-4 pb-2">
                                <h5 class="card-title text-center pb-0 fs-4">BAWASLU Kab. Bekasi</h5>
                                <p class="text-center small">Enter your Identity Card (KTP)</p>
                            </div>

                            <form class="row g-3 needs-validation" method="POST" action="proses.php">

                                <div class="col-12">
                                    <div class="input-group">
                                        <input type="text" name="no_ktp" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button name="cek-ktp" class="btn btn-primary w-100" type="submit">Submit</button>
                                </div>
                            </form>

                            <hr/>
                            
                            <a href="index.php" class="btn btn-danger w-100">Back</a>

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