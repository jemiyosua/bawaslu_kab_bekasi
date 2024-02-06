<?php

session_start();

require_once('header.php');

require_once('navbar-form.php');

require_once('sidebar-form.php');

require_once('koneksi.php');

$_SESSION['kc'] = $_GET['kc'];
$KategoriCapilPage = $_GET['kc'];
$KodePartaiPage = $_GET['kp'];

?>

<main id="main" class="main">
    
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
            });
            </script>";
        unset($_SESSION['pesanError']);
    }
    ?>

	<section class="section">
        <div class="row">
            <div class="col-lg-12">

            <?php
            
            $sql = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_hasil_rekap_hdr WHERE no_ktp = '$NomorKTP' AND kategori_capil = '$KategoriCapil'");
            $row = mysqli_fetch_assoc($sql);
            $Count = $row['cnt'];

            if ($Count > 0) {

                ?>

                <div class="alert alert-success" role="alert">
                    <div style="font-weight: bold;">Anda Sudah Melakukan Pengisian Form Suara ini!</div>
                </div>

                <?php

            } else {

                ?>
                
                <div class="card">
                    <div class="card-body">

                        <form method="POST" action="proses.php" id="submit-form-partai-2" onsubmit="disableButton()" enctype="multipart/form-data">
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
                                            <label class="form-label" style="font-weight: bold;">Jumlah Suara Sah</label>
                                            <input type="text" class="form-control" id="jumlah_suara_sah" name="jumlah_suara_sah" onkeypress="return isNumberKey(event)" required>
                                        </div>
                                    </div>

                                    <div class="col-sm-4 mb-4 mb-sm-0 mt-3">
                                        <div class="mb-3">
                                            <label class="form-label" style="font-weight: bold;">Jumlah Suara Tidak Sah</label>
                                            <input type="text" class="form-control" id="jumlah_suara_tidak_sah" name="jumlah_suara_tidak_sah" onkeypress="return isNumberKey(event)" required>
                                        </div>
                                    </div>

                                    <div class="col-sm-4 mb-4 mb-sm-0 mt-3">
                                        <div class="mb-3">
                                            <label class="form-label" style="font-weight: bold;">Jumlah Pengguna Hak Pilih</label>
                                            <input type="text" class="form-control" id="jumlah_pengguna_hak_pilih" name="jumlah_pengguna_hak_pilih" onkeypress="return isNumberKey(event)" required>
                                        </div>
                                    </div>

                                    <hr/>

                                    <div class="col-sm-4 mb-4 mb-sm-0 mt-3">
                                        <div class="mb-3">
                                            <!-- <input type="file" id="imageInput" accept="image/*" multiple> -->
                                        <!-- <button onclick="uploadImages()">Upload</button> -->
                                            <!-- <label class="form-label" style="font-weight: bold;">Upload Foto</label>
                                            <input type='file' class='form-control' id='foto' name='foto[]' accept='image/*' onchange="handleImageUpload(event)" multiple required> -->
                                            <label class="form-label" style="font-weight: bold;">Upload Foto</label>
                                            <input class='form-control' type="file" name="images[]" multiple accept="image/*" required>
                                        </div>
                                    </div>

                                    <input type="hidden" class="form-control" name="no_ktp" id="no_ktp" value="<?= $NomorKTP ?>">
                                    <input type="hidden" class="form-control" name="kategori_capil" id="kategori_capil" value="<?= $KategoriCapilPage ?>">
                                    <input type="hidden" class="form-control" name="submit-form-partai-2" value="submit-form-partai-2">

                                    <div class="card-footer text-body-secondary align-item-center">
                                        <button type="submit" class="btn btn-success" id="button-submit"><i class="bi bi-check-circle-fill"></i> Submit</button>
                                        <!-- <div class="spinner-border" role="status" id="spinner" style="display: none;">
                                            <span class="visually-hidden">Loading...</span>
                                        </div> -->
                                    </div>
                                    
                                    <br/>

                                    <div id="proses" style="font-weight: bold;color: red;"></div>

                                </div>
                            </div>
                        </form>

                    </div>
                </div>

                <?php

            }
            
            ?>

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
    var form = document.getElementById('submit-form-partai-2');

    if (form.checkValidity()) {
        document.getElementById('button-submit').disabled = true;
        document.getElementById('proses').innerText = "Proses Insert Data Sedang Berjalan ..., Mohon Jangan Refresh Atau Close Page Ini!";
    }
}

// function handleImageUpload(event) {
//     const input = event.target;
//     const file = input.files[0];
//     const maxSizeInBytes = 3000000; // 3Mb
//     var imagebase64 = document.getElementById('imagebase64');

//     // [...this.state.ListVoucher, ...response.data.list]

//     console.log(file.length)

//     if (file) {
//         if (file.size > maxSizeInBytes) {
//             const reader = new FileReader();

//             reader.onload = function (e) {
//                 const img = new Image();
//                 img.onload = function () {
//                     const canvas = document.createElement('canvas');
//                     const ctx = canvas.getContext('2d');

//                     // Set canvas dimensions to match the image
//                     canvas.width = img.width;
//                     canvas.height = img.height;

//                     // Draw the image on the canvas
//                     ctx.drawImage(img, 0, 0);

//                     // Convert the canvas content to a base64-encoded image
//                     const base64ImageData = canvas.toDataURL('image/jpeg', 0.75); // Adjust quality as needed

//                     // Display the base64-encoded image
//                     // const imgElement = new Image();
//                     // imgElement.src = base64ImageData;
//                     // document.body.appendChild(imgElement);

//                     // imagebase64.value = base64ImageData;

//                     // Log the base64 string to the console (for demonstration purposes)
//                     // console.log("Base64 MORE THAN 3 MB : ", base64ImageData);
//                 };

//                 img.src = e.target.result;
//                 // img.style.display = 'none';
//                 // var myImage = document.querySelector('img');
//                 // if (myImage) {
//                 //     myImage.style.display = 'none';
//                 // }
//             };

//             reader.readAsDataURL(input.files[0]);
//         } else {
//             console.log("LESS THAN 3 MB")
//             var reader = new FileReader();

//             reader.onload = function (e) {
//                 var base64Image = e.target.result;
//                 imagebase64.value = base64Image
//                 // console.log('Base64 LESS THAN 3 MB : ', base64Image);

//                 // displayBase64Image(base64Image);
//             };

//             reader.readAsDataURL(input.files[0]);
//         }
//     }
// }

function uploadImages() {
    var input = document.getElementById('imageInput');
    var files = input.files;

    if (files.length > 0) {
        var base64Images = [];
        var ListImage = [];

        // if (files.length != 20) {
        //     alert("foto kurang atau lebih dari 20")
        //     return false
        // }

        for (var i = 0; i < files.length; i++) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var base64Image = e.target.result;
                // base64Images.concat(base64Image);
                // base64Images.push(base64Image)
                ListImage = [...ListImage, ...base64Image]
                console.log(ListImage)
                // Make an AJAX request to send the base64 images to the server
            //     var xhttp = new XMLHttpRequest();
            //     xhttp.onreadystatechange = function() {
            //         if (xhttp.readyState === 4 && xhttp.status === 200) {
            //             console.log(xhr.responseText);
            //         }
            //     };

            //     var URL = "http://localhost/bawaslu_bekasi/image-upload.php?image"+base64Image
            //     xhttp.open("POST", URL, true);
            //     xhttp.send();
            // };
            // reader.readAsDataURL(files[i]);
            }
        }
        
    }
}

</script>