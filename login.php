<?php

require_once('header.php');

session_start();

if (isset($_SESSION['username']) && (isset($_SESSION['password']))) {

    header('location:main.php');
}

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
                window.location.href='login.php';
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
                window.location.href='login.php';
            });
            </script>";
            unset($_SESSION['pesanError']);
        }
        ?>

        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                        <!-- <div class="d-flex justify-content-center py-4">
                            <a href="index.php" class="logo d-flex align-items-center w-auto">
                                <span class="d-none d-lg-block">BAWASLU Kab. Bekasi</span>
                            </a>
                        </div> -->
                        <!-- End Logo -->

                        <div class="card mb-3">

                            <div class="card-body">

                            <div class="pt-4 pb-2">
                                <h5 class="card-title text-center pb-0 fs-4">BAWASLU Kab. Bekasi</h5>
                                <p class="text-center small">Enter your username & password to login</p>
                            </div>

                            <form class="row g-3 needs-validation" method="POST" action="proses.php">

                                <div class="col-12">
                                <label for="yourUsername" class="form-label">Username</label>
                                <div class="input-group has-validation">
                                    <input type="text" name="username" class="form-control" id="username" required>
                                </div>
                                </div>

                                <div class="col-12">
                                    <label for="yourPassword" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" id="password" required>
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-primary w-100" type="submit" name="login-admin">Login</button>
                                </div>
                            </form>

                            <hr/>
                            
                            <a href="index.php" class="btn btn-danger w-100" type="submit">Back</a>

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