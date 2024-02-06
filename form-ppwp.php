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

                <!-- <div class="mb-3">
                    <h6 class="card-title text-center pb-0 fs-4">FORM REKAP PERHITUNGAN SUARA PILPRES</h6>
                </div> -->


                <form method="POST" action="proses.php" id="submit-form-ppwp" onsubmit="disableButton()">

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
                            $KodePartai = "PPWP01";
                        } else if ($NomorUrut == "2") {
                            $Src = "assets/img/bawaslu/capres02.jpg";
                            $KodePartai = "PPWP02";
                        } else if ($NomorUrut == "3") {
                            $Src = "assets/img/bawaslu/capres03.jpg";
                            $KodePartai = "PPWP03";
                        }

                        $sql2 = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_hasil_rekap_hdr WHERE no_ktp = '$NomorKTP' AND kategori_capil = 'PPWP'");
                        $row2 = mysqli_fetch_assoc($sql2);
                        $Count = $row2['cnt'];

                        ?>
                        
                        <div class="col-sm-4 mb-3 mb-sm-0">
                            <div class="card">
                                <div class="card-body">
                                    <img src="<?= $Src ?>" style="display: block;margin: auto;margin-top: 30px;" />
                                    <div class="mt-3">
                                        <?php
                                        
                                        if ($Count > 0) {
                                            
                                            ?>

                                            <div class="alert alert-success" role="alert" style="font-weight: bold;">
                                                Anda Sudah Melakukan Pengisian Jumlah Suara
                                            </div>

                                            <?php

                                        } else {

                                            ?>
                                            
                                            <input type="text" class="form-control" id="jumlah_suara_<?=$Id?>" name="jumlah_suara_<?=$Id?>" onkeypress="return isNumberKey(event)" style="font-weight: bold;text-align: center;height:70px;font-size: 30px;" placeholder="Input Jumlah Suara" required>

                                            <?php

                                        }
                                        
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php

                    }

                    $sql2 = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_hasil_rekap_hdr WHERE no_ktp = '$NomorKTP' AND kategori_capil = 'PPWP'");
                    $row2 = mysqli_fetch_assoc($sql2);
                    $Count = $row2['cnt'];

                    if ($Count < 1) {
                        
                        ?>
                        
                        <div class="card">
                            <div class="card-body">

                                <div class="col-sm-12 mb-12 mb-sm-0 mt-3">

                                    <div class="row">

                                        <div class="col-sm-4 mb-4 mb-sm-0 mt-3">
                                            <div class="mb-3">
                                                <label class="form-label" style="font-weight: bold;">Jumlah Suara DPT</label>
                                                <input type="text" class="form-control" id="jumlah_suara_dpt" name="jumlah_suara_dpt" onkeypress="return isNumberKey(event)" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-4 mb-4 mb-sm-0 mt-3">
                                            <div class="mb-3">
                                                <label class="form-label" style="font-weight: bold;">Jumlah Suara DPTB</label>
                                                <input type="text" class="form-control" id="jumlah_suara_dptb" name="jumlah_suara_dptb" onkeypress="return isNumberKey(event)" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-4 mb-4 mb-sm-0 mt-3">
                                            <div class="mb-3">
                                                <label class="form-label" style="font-weight: bold;">Jumlah Suara DPK</label>
                                                <input type="text" class="form-control" id="jumlah_suara_dpk" name="jumlah_suara_dpk" onkeypress="return isNumberKey(event)" required>
                                            </div>
                                        </div>

                                        <hr/>

                                        <div class="col-sm-4 mb-4 mb-sm-0 mt-3">
                                            <div class="mb-3">
                                                <label class="form-label" style="font-weight: bold;">Jumlah Suara Sah <?= $KategoriCapil ?></label>
                                                <input type="text" class="form-control" id="jumlah_suara_sah" name="jumlah_suara_sah" onkeypress="return isNumberKey(event)" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-4 mb-4 mb-sm-0 mt-3">
                                            <div class="mb-3">
                                                <label class="form-label" style="font-weight: bold;">Jumlah Suara Tidak Sah <?= $KategoriCapil ?></label>
                                                <input type="text" class="form-control" id="jumlah_suara_tidak_sah" name="jumlah_suara_tidak_sah" onkeypress="return isNumberKey(event)" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-4 mb-4 mb-sm-0 mt-3">
                                            <div class="mb-3">
                                                <label class="form-label" style="font-weight: bold;">Jumlah Pengguna Hak Pilih </label>
                                                <input type="text" class="form-control" id="jumlah_pengguna_hak_pilih" name="jumlah_pengguna_hak_pilih" onkeypress="return isNumberKey(event)" required>
                                            </div>
                                        </div>

                                    </div>

                                    <hr/>

                                    <div class="row">
                                        <div class="col-sm-4 mb-4 mb-sm-0 mt-3">
                                            <div class="mb-3">
                                                <label class="form-label" style="font-weight: bold;">Foto Hasil Suara <?= $KategoriCapil ?> 1</label>
                                                <input type="file" class="form-control" id="foto-1" name="foto-1" accept="image/*" onchange="handleImageUpload('1')" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-4 mb-4 mb-sm-0 mt-3">
                                            <div class="mb-3">
                                                <label class="form-label" style="font-weight: bold;">Foto Hasil Suara <?= $KategoriCapil ?> 2</label>
                                                <input type="file" class="form-control" id="foto-2" name="foto-2" accept="image/*" onchange="handleImageUpload('2')" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-4 mb-4 mb-sm-0 mt-3">
                                            <div class="mb-3">
                                                <label class="form-label" style="font-weight: bold;">Foto Hasil Suara <?= $KategoriCapil ?> 3</label>
                                                <input type="file" class="form-control" id="foto-3" name="foto-3" accept="image/*" onchange="handleImageUpload('3')" required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- <div class="row">
                                        <div class="col-sm-4 mb-4 mb-sm-0 mt-3">
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <img id="image-preview-1" style="width:200px;transition: transform 0.5s ease;" onclick="zoomImage(this)">
                                                </div>
                                            </div>
                                            <div id="zoom-container" style="display: none;position: fixed;width: 50%;height: 50%;background: rgba(0, 0, 0, 0.8);justify-content: center;align-items: center;cursor: pointer;" onclick="closeZoom()">
                                                <img id="zoomed-image-1" style="max-width: 100%;max-height: 100%;cursor: pointer;">
                                            </div>
                                        </div>

                                        <div class="col-sm-4 mb-4 mb-sm-0 mt-3">
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <img id="image-preview-2" style="width:200px;transition: transform 0.5s ease;" onclick="zoomImage(this)">
                                                </div>
                                            </div>
                                            <div id="zoom-container" style="display: none;position: fixed;width: 50%;height: 50%;background: rgba(0, 0, 0, 0.8);justify-content: center;align-items: center;cursor: pointer;" onclick="closeZoom()">
                                                <img id="zoomed-image-2" style="max-width: 100%;max-height: 100%;cursor: pointer;">
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-4 mb-4 mb-sm-0 mt-3">
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <img id="image-preview-3" style="width:200px;transition: transform 0.5s ease;" onclick="zoomImage(this)">
                                                </div>
                                            </div>
                                            <div id="zoom-container" style="display: none;position: fixed;width: 50%;height: 50%;background: rgba(0, 0, 0, 0.8);justify-content: center;align-items: center;cursor: pointer;" onclick="closeZoom()">
                                                <img id="zoomed-image-3" style="max-width: 100%;max-height: 100%;cursor: pointer;">
                                            </div>
                                        </div>
                                    
                                    </div> -->

                                    <input type="hidden" class="form-control" name="no_ktp" id="no_ktp" value="<?= $NomorKTP ?>">
                                    <input type="hidden" class="form-control" name="kategori_capil" id="kategori_capil" value="<?= $KategoriCapil ?>">
                                    <input type="hidden" class="form-control" name="kode_partai" id="kode_partai" value="<?= $KodePartai ?>">
                                    <input type="hidden" class="form-control" name="imagebase64-1" id="imagebase64-1">
                                    <input type="hidden" class="form-control" name="imagebase64-2" id="imagebase64-2">
                                    <input type="hidden" class="form-control" name="imagebase64-3" id="imagebase64-3">
                                    <input type="hidden" class="form-control" name="submit-form-ppwp" value="submit-form-ppwp">

                                    <div class="card-footer text-body-secondary">
                                        <button type="submit" class="btn btn-success" id="button-submit"><i class="bi bi-check-circle-fill"></i> Submit</button>
                                    </div>

                                    </div>
                                </div>

                            </form>

                        </div>

                        <?php

                    }
                    
                    ?>

                    </div>

                </form>

            </div>

        </div>
    </section>
</main>


<?php

require_once('footer.php');

mysqli_close($conn);

?>

<script type="text/JavaScript">

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    }

    function disableButton() {
        var form = document.getElementById('submit-form-ppwp');

        if (form.checkValidity()) {
            document.getElementById('button-submit').disabled = true;
        }
    }

    var zoomed = false;

    function zoomImage(originalImage) {
        var zoomContainer = document.getElementById('zoom-container');
        var zoomedImage = document.getElementById('zoomed-image');

        zoomedImage.src = originalImage.src;
        zoomContainer.style.display = 'flex';
    }

    // function validateImageSize(input, event, stateImage) {
    //     const maxSizeInBytes = 3000 * 3000; // 1Mb
    //     const file = input.files[0];

    //     if (stateImage == "1") {
    //         var imagePreview = document.getElementById('image-preview-1');
    //         var outputDiv = document.getElementById('output-1');
    //         outputDiv.innerText = "";

    //         if (file && file.size > maxSizeInBytes) {
    //             imagePreview.src = "";
    //             outputDiv.innerText = 'Ukuran gambar terlalu besar, maksimal (1 MB). Silahkan pilih gambar yang lebih kecil!';
    //             input.value = "";
    //         } else {
    //             previewImage(event, stateImage)
    //         }
    //     } else if (stateImage == "2") {
    //         var imagePreview = document.getElementById('image-preview-2');
    //         var outputDiv = document.getElementById('output-2');
    //         outputDiv.innerText = "";

    //         if (file && file.size > maxSizeInBytes) {
    //             imagePreview.src = "";
    //             outputDiv.innerText = 'Ukuran gambar terlalu besar, maksimal (1 MB). Silahkan pilih gambar yang lebih kecil!';
    //             input.value = "";
    //         } else {
    //             previewImage(event, stateImage)
    //         }
    //     } else {
    //         var imagePreview = document.getElementById('image-preview-3');
    //         var outputDiv = document.getElementById('output-3');
    //         outputDiv.innerText = "";

    //         if (file && file.size > maxSizeInBytes) {
    //             imagePreview.src = "";
    //             outputDiv.innerText = 'Ukuran gambar terlalu besar, maksimal (1 MB). Silahkan pilih gambar yang lebih kecil!';
    //             input.value = "";
    //         } else {
    //             previewImage(event, stateImage)
    //         }
    //     }
        
    // }

    function previewImage(event, imageState) {
        var input = event.target;

        var reader = new FileReader();
        reader.onload = function () {
            if (imageState == "1") {
                var imagePreview = document.getElementById('image-preview-1');
                imagePreview.src = reader.result;
            } else if (imageState == "2") {
                var imagePreview = document.getElementById('image-preview-2');
                imagePreview.src = reader.result;
            } else {
                var imagePreview = document.getElementById('image-preview-3');
                imagePreview.src = reader.result;
            }
            
        };

        reader.readAsDataURL(input.files[0]);
    }

    function closeZoom() {
        var zoomContainer = document.getElementById('zoom-container');
        zoomContainer.style.display = 'none';
    }

    function handleImageUpload(stateImage) {
        if (stateImage == "1") {
            // var input = document.getElementById('foto-1');
            var imagebase64 = document.getElementById('imagebase64-1');
            const input = event.target;
            const file = input.files[0];
            const maxSizeInBytes = 3000000; // 3Mb

            // console.log()

            if (file) {
                if (file.size > maxSizeInBytes) {
                    // console.log("MORE THAN 3 MB")
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        const img = new Image();
                        img.onload = function () {
                            const canvas = document.createElement('canvas');
                            const ctx = canvas.getContext('2d');

                            // Set canvas dimensions to match the image
                            canvas.width = img.width;
                            canvas.height = img.height;

                            // Draw the image on the canvas
                            ctx.drawImage(img, 0, 0);

                            // Convert the canvas content to a base64-encoded image
                            const base64ImageData = canvas.toDataURL('image/jpeg', 0.75); // Adjust quality as needed

                            // Display the base64-encoded image
                            // const imgElement = new Image();
                            // imgElement.src = base64ImageData;
                            // document.body.appendChild(imgElement);

                            imagebase64.value = base64ImageData;

                            // Log the base64 string to the console (for demonstration purposes)
                            // console.log("Base64 MORE THAN 3 MB : ", base64ImageData);
                        };

                        img.src = e.target.result;
                    };

                    reader.readAsDataURL(file);
                } else {
                    // console.log("LESS THAN 3 MB")
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        var base64Image = e.target.result;
                        imagebase64.value = base64Image
                        // console.log('Base64 LESS THAN 3 MB : ', base64Image);

                        // displayBase64Image(base64Image);
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }

        } else if (stateImage == "2") {
            // var input = document.getElementById('foto-1');
            var imagebase64 = document.getElementById('imagebase64-2');
            const input = event.target;
            const file = input.files[0];
            const maxSizeInBytes = 3000000; // 3Mb

            // console.log()

            if (file) {
                if (file.size > maxSizeInBytes) {
                    // console.log("MORE THAN 3 MB")
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        const img = new Image();
                        img.onload = function () {
                            const canvas = document.createElement('canvas');
                            const ctx = canvas.getContext('2d');

                            // Set canvas dimensions to match the image
                            canvas.width = img.width;
                            canvas.height = img.height;

                            // Draw the image on the canvas
                            ctx.drawImage(img, 0, 0);

                            // Convert the canvas content to a base64-encoded image
                            const base64ImageData = canvas.toDataURL('image/jpeg', 0.75); // Adjust quality as needed

                            // Display the base64-encoded image
                            // const imgElement = new Image();
                            // imgElement.src = base64ImageData;
                            // document.body.appendChild(imgElement);

                            imagebase64.value = base64ImageData;

                            // Log the base64 string to the console (for demonstration purposes)
                            // console.log("Base64 MORE THAN 3 MB : ", base64ImageData);
                        };

                        img.src = e.target.result;
                    };

                    reader.readAsDataURL(file);
                } else {
                    // console.log("LESS THAN 3 MB")
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        var base64Image = e.target.result;
                        imagebase64.value = base64Image
                        // console.log('Base64 LESS THAN 3 MB : ', base64Image);

                        // displayBase64Image(base64Image);
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }
        } else {
            // var input = document.getElementById('foto-1');
            var imagebase64 = document.getElementById('imagebase64-3');
            const input = event.target;
            const file = input.files[0];
            const maxSizeInBytes = 3000000; // 3Mb

            // console.log()

            if (file) {
                if (file.size > maxSizeInBytes) {
                    // console.log("MORE THAN 3 MB")
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        const img = new Image();
                        img.onload = function () {
                            const canvas = document.createElement('canvas');
                            const ctx = canvas.getContext('2d');

                            // Set canvas dimensions to match the image
                            canvas.width = img.width;
                            canvas.height = img.height;

                            // Draw the image on the canvas
                            ctx.drawImage(img, 0, 0);

                            // Convert the canvas content to a base64-encoded image
                            const base64ImageData = canvas.toDataURL('image/jpeg', 0.75); // Adjust quality as needed

                            // Display the base64-encoded image
                            // const imgElement = new Image();
                            // imgElement.src = base64ImageData;
                            // document.body.appendChild(imgElement);

                            imagebase64.value = base64ImageData;

                            // Log the base64 string to the console (for demonstration purposes)
                            // console.log("Base64 MORE THAN 3 MB : ", base64ImageData);
                        };

                        img.src = e.target.result;
                    };

                    reader.readAsDataURL(file);
                } else {
                    console.log("LESS THAN 3 MB")
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        // var base64Image = e.target.result;
                        // imagebase64.value = base64Image
                        // console.log('Base64 LESS THAN 3 MB : ', base64Image);

                        // displayBase64Image(base64Image);
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }
        }
    }

    function jmlPemilih() {
        var jmlDpt = document.getElementById("jumlah_dpt").value == "" ? "0" : document.getElementById("jumlah_dpt").value;
        var jmlDptb = document.getElementById("jumlah_dptb").value == "" ? "0" : document.getElementById("jumlah_dptb").value;
        var jmlDpk = document.getElementById("jumlah_dpk").value == "" ? "0" : document.getElementById("jumlah_dpk").value;

        var totPemilih = parseInt(jmlDpt) + parseInt(jmlDptb) + parseInt(jmlDpk);

        document.getElementById("jumlah_pemilih").value = totPemilih.toString();

    };

    function jmlPenggunaHakPilih() {
        var jmlSuaraSah = document.getElementById("jumlah_suara_sah").value == "" ? "0" : document.getElementById("jumlah_suara_sah").value;
        var jmlSuaraTdkSah = document.getElementById("jumlah_suara_tidak_sah").value == "" ? "0" : document.getElementById("jumlah_suara_tidak_sah").value;

        var totPenggunaHakPilih = parseInt(jmlSuaraSah) + parseInt(jmlSuaraTdkSah);

        document.getElementById("jumlah_pengguna_hak_pilih").value = totPenggunaHakPilih.toString();

    };
</script>