<?php

session_start();

$_SESSION['kc'] = $_GET['kc'];
$_SESSION['dapil'] = $_GET['dapil'];

require_once('header.php');

require_once('navbar-form.php');

require_once('sidebar-form.php');

require_once('koneksi.php');

$KategoriCapilPage = $_GET['kc'];
$KodePartaiPage = $_GET['kp'];

?>

<main id="main" class="main">

	<section class="section">
        <div class="row">
            <div class="col-lg-12">

            <?php
            
            if ($KategoriCapilPage != "DPD-RI" && ($KodePartaiPage == "" || $KodePartaiPage == null)) {

                ?>

                <div class="alert alert-info" role="alert" style="font-weight: bold">
                    Silahkan Memilih Partai Melalui Menu Sidebar Untuk Melakukan Pengisian Jumlah Suara
                </div>

                <?php

            } else {

                ?>
                
                <div class="card">
                    <div class="card-body">

                        <?php
                        
                        if ($KategoriCapilPage == "DPR-RI" || $KategoriCapilPage == "DPRD-PROV" || $KategoriCapilPage == "DPRD-KAB") {

                            $sql = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_hasil_rekap_suara_partai WHERE no_ktp = '$NomorKTP' AND kategori_capil = '$KategoriCapilPage' AND kode_partai = '$KodePartaiPage'");
                            $row = mysqli_fetch_assoc($sql);
                            $CountIsiJumlahSuaraPartai = $row['cnt'];

                            if ($CountIsiJumlahSuaraPartai > 0) {

                                ?>
                                
                                <div class="col-sm-12 mb-12 mb-sm-0 mt-3">
                                    <div class="mb-3">
                                        <div class="alert alert-success" role="alert" style="font-weight: bold;">
                                            Anda Sudah Mengisi Jumlah Suara Partai!
                                        </div>
                                    </div>
                                </div>

                                <hr/>

                                <?php

                            } else {

                                ?>
                                
                                <div class="col-sm-12 mb-12 mb-sm-0 mt-3">
                                    <div class="mb-3">
                                        <div class="alert alert-danger" role="alert" style="font-weight: bold;">
                                            Anda Belum Mengisi Jumlah Suara Partai!
                                        </div>
                                    </div>
                                </div>
                                
                                <form action="proses.php" method="POST" id="submit-form-suara-partai" onsubmit="disableButtonSuara()">
                                    <div class="col-sm-3 mb-3 mb-sm-0 mt-3">
                                        <div class="mb-3">
                                            <label class="form-label" style="font-weight: bold;">Jumlah Suara Partai</label>
                                            <input type="text" class="form-control" id="jumlah_suara_partai" name="jumlah_suara_partai" onkeypress="return isNumberKey(event)" required>
                                        </div>
                                    </div>

                                    <input type='hidden' class='form-control' name='no_ktp' id='no_ktp' value='<?=$NomorKTP?>'>
                                    <input type='hidden' class='form-control' name='kategori_capil' id='kategori_capil' value='<?=$KategoriCapilPage?>'>
                                    <input type='hidden' class='form-control' name='kode_partai' id='kode_partai' value='<?=$KodePartaiPage?>'>
                                    <input type='hidden' class='form-control' name='dapil' id='dapil' value='<?=$Dapil?>'>
                                    <input type='hidden' class='form-control' name='submit-form-suara-partai' value='submit-form-suara-partai'>

                                    <div class="col-sm-3 mb-3 mb-sm-0 mt-3">
                                        <div class="mb-3">
                                            <button type='submit' class='btn btn-success' id='button-submit'><i class='bi bi-check-circle-fill'></i> Submit</button>
                                        </div>
                                    </div>
                                </form>

                                <hr/>

                                <?php

                            }

                        }
                        
                        ?>
                            
                        <table class="table table-hover">

                            <thead>
                                <?php
                                
                                if ($KategoriCapilPage == "DPD-RI") {

                                    ?>
                                    
                                    <tr>
                                        <th scope="col">Nomor Urut</th>
                                        <th scope="col">Nama Capil</th>
                                        <th scope="col">Jumlah Suara</th>
                                        <th scope="col">Action</th>
                                    </tr>

                                    <?php

                                } else {

                                    ?>
                                    
                                    <tr>
                                        <th scope="col">Nomor Urut</th>
                                        <th scope="col">Nama Capil</th>
                                        <th scope="col">Partai</th>
                                        <th scope="col">Jumlah Suara</th>
                                        <th scope="col">Action</th>
                                    </tr>

                                    <?php

                                }
                                
                                ?>
                            </thead>
                            <tbody>
                                <?php

                                if ($KategoriCapilPage == "DPRD-KAB") {
                                    $q = "SELECT id, kategori_capil, kode_partai, no_urut, nama_capil FROM db_master_capil WHERE kategori_capil = '$KategoriCapilPage' AND kode_partai = '$KodePartaiPage' AND dapil = '$Dapil' ORDER BY no_urut ASC";
                                } else {
                                    $q = "SELECT id, kategori_capil, kode_partai, no_urut, nama_capil FROM db_master_capil WHERE kategori_capil = '$KategoriCapilPage' AND kode_partai = '$KodePartaiPage' ORDER BY no_urut ASC";
                                }
                                
                                $sql = mysqli_query($conn, $q);
                                while ($row = mysqli_fetch_assoc($sql)) {

                                    $Id = $row['id'];
                                    $KategoriCapilDB = $row['kategori_capil'];
                                    $KodePartaiDB = $row['kode_partai'];
                                    $NomorUrut = $row['no_urut'];
                                    $NamaCapil = $row['nama_capil'];

                                    $q2 = "SELECT COUNT(*) AS cnt FROM db_hasil_rekap_dtl WHERE no_ktp = '$NomorKTP' AND kategori_capil = '$KategoriCapilDB' AND kode_partai = '$KodePartaiDB' AND id_mst_capil = '$Id'";
                                    $sql2 = mysqli_query($conn, $q2);
                                    $row2 = mysqli_fetch_assoc($sql2);
                                    $Count = $row2['cnt'];

                                    if ($Count > 0) {
                                        if ($KategoriCapilPage == "DPD-RI") {
                                            echo "
                                            <tr>
                                                <td>$NomorUrut</td>
                                                <td>$NamaCapil</td>
                                                <td colspan='2'>
                                                    <div class='alert alert-success' role='alert' style='font-weight: bold'>Anda Sudah Mengisi Jumlah Suara!</div>
                                                </td>
                                            </tr>
                                            ";
                                        } else {
                                            echo "
                                            <tr>
                                                <td>$NomorUrut</td>
                                                <td>$NamaCapil</td>
                                                <td>$KodePartaiDB</td>
                                                <td colspan='2'>
                                                    <div class='alert alert-success' role='alert' style='font-weight: bold'>Anda Sudah Mengisi Jumlah Suara!</div>
                                                </td>
                                            </tr>
                                            ";
                                        }
                                       
                                    } else {

                                        if ($KategoriCapilPage == "DPD-RI") {
                                            echo "
                                            <form action='proses.php' method='POST' id='submit-form-partai' onsubmit='disableButton()'>
                                                <tr>
                                                    <td>$NomorUrut</td>
                                                    <td>$NamaCapil</td>
                                                    <td><input type='text' class='form-control' id='jumlah_suara' name='jumlah_suara' onkeypress='return isNumberKey(event)' required></td>
                                                    <td><button type='submit' class='btn btn-success' id='button-submit'><i class='bi bi-check-circle-fill'></i> Submit</button></td>
                                                </tr>
                                                <input type='hidden' class='form-control' name='id_mst_capil' id='id_mst_capil' value='$Id'>
                                                <input type='hidden' class='form-control' name='imagebase64' id='imagebase64'>
                                                <input type='hidden' class='form-control' name='no_ktp' id='no_ktp' value='$NomorKTP'>
                                                <input type='hidden' class='form-control' name='kategori_capil' id='kategori_capil' value='$KategoriCapilDB'>
                                                <input type='hidden' class='form-control' name='kode_partai' id='kode_partai' value='$KodePartaiDB'>
                                                <input type='hidden' class='form-control' name='submit-form-partai' value='submit-form-partai'>
                                            </form>
                                            ";
                                        } else {
                                            echo "
                                            <form action='proses.php' method='POST' id='submit-form-partai' onsubmit='disableButton()'>
                                                <tr>
                                                    <td>$NomorUrut</td>
                                                    <td>$NamaCapil</td>
                                                    <td>$KodePartaiDB</td>
                                                    <td><input type='text' class='form-control' id='jumlah_suara' name='jumlah_suara' onkeypress='return isNumberKey(event)' required></td>
                                                    <td><button type='submit' class='btn btn-success' id='button-submit'><i class='bi bi-check-circle-fill'></i> Submit</button></td>
                                                </tr>
                                                <input type='hidden' class='form-control' name='id_mst_capil' id='id_mst_capil' value='$Id'>
                                                <input type='hidden' class='form-control' name='imagebase64' id='imagebase64'>
                                                <input type='hidden' class='form-control' name='no_ktp' id='no_ktp' value='$NomorKTP'>
                                                <input type='hidden' class='form-control' name='kategori_capil' id='kategori_capil' value='$KategoriCapilDB'>
                                                <input type='hidden' class='form-control' name='kode_partai' id='kode_partai' value='$KodePartaiDB'>
                                                <input type='hidden' class='form-control' name='dapil' id='dapil' value='$Dapil'>
                                                <input type='hidden' class='form-control' name='submit-form-partai' value='submit-form-partai'>
                                            </form>
                                            ";
                                        }
                                       
                                    }
                                    
                                }
                                ?>
                                </form>
                            </tbody>
                        </table>

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
        var form = document.getElementById('submit-form-partai');

        if (form.checkValidity()) {
            document.getElementById('button-submit').disabled = true;
        }
    }

    function disableButtonSuara() {
        var form = document.getElementById('submit-form-suara-partai');

        if (form.checkValidity()) {
            document.getElementById('button-submit').disabled = true;
        }
    }

    function validateImageSize(input, event) {
        const maxSizeInBytes = 3000 * 3000; // 3Mb
        const file = input.files[0];

        var imagePreview = document.getElementById('image-preview');
        var outputDiv = document.getElementById('output');
        outputDiv.innerText = "";

        if (file && file.size > maxSizeInBytes) {
            imagePreview.src = "";
            outputDiv.innerText = 'Ukuran gambar terlalu besar, maksimal (3 MB). Silahkan pilih gambar yang lebih kecil!';
            input.value = "";
        }
    }

    // function handleImageUpload() {
    //     var input = document.getElementById('foto');
    //     var imagebase64 = document.getElementById('imagebase64');
        
    //     if (input.files && input.files[0]) {
    //         var reader = new FileReader();

    //         reader.onload = function (e) {
    //             var base64Image = e.target.result;
    //             imagebase64.value = base64Image
    //             console.log('Base64 Image:', base64Image);

    //             displayBase64Image(base64Image);
                
            
    //         };

    //         reader.readAsDataURL(input.files[0]);
    //     }  
    // }

    function handleImageUpload(event) {
        const input = event.target;
        const file = input.files[0];
        const maxSizeInBytes = 3000000; // 3Mb
        var imagebase64 = document.getElementById('imagebase64');

        console.log()

        if (file) {
            if (file.size > maxSizeInBytes) {
                console.log("MORE THAN 3 MB")
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
                    // img.style.display = 'none';
                    // var myImage = document.querySelector('img');
                    // if (myImage) {
                    //     myImage.style.display = 'none';
                    // }
                };

                reader.readAsDataURL(input.files[0]);
            } else {
                console.log("LESS THAN 3 MB")
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
    }
</script>