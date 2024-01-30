<?php

require_once('header.php');

require_once('navbar-form.php');

require_once('sidebar-form.php');

require_once('koneksi.php');

session_start();
$_SESSION['page'] = "";
$_SESSION['page'] = "form-suara";

$NomorKTP = $_SESSION['nomor_ktp'];
$PasanganCalon = $_GET['pc'];
$KategoriCapil = "PPWP";
$Src = $_GET['src'];
$IdPPWP = $_GET['id'];

$Judul = "";
if ($PasanganCalon == "1") {
    $Judul = "Pasangan Calon 01";
    $KodePartai = "PPWP01";
} else if ($PasanganCalon == "2") {
    $Judul = "Pasangan Calon 02";
    $KodePartai = "PPWP02";
} else if ($PasanganCalon == "3") {
    $Judul = "Pasangan Calon 03";
    $KodePartai = "PPWP03";
}

?>

<main id="main" class="main">

	<div class="pagetitle">
	    <h1>Form Suara <?= $Judul ?></h1>
	</div>

    <hr/>

	<section class="section dashboard">
		<div class="row">

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
            
            $sql = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_hasil_rekap_hdr WHERE no_ktp = '$NomorKTP' AND kategori_capil = 'PPWP' AND kode_partai = '$KodePartai'");
            $row = mysqli_fetch_assoc($sql);
            $CountIsi = $row['cnt'];

            if ($CountIsi > 0) {

                ?>
                
                <div class="alert alert-danger" role="alert">
                    <div style="font-weight: bold;">Anda Sudah Melakukan Pengisian Form Jumlah Suara Untuk <?= $Judul ?></div>
                </div>

                <?php

            } else {

                ?>

                <div class="col-sm-12 mb-6 mb-sm-0 mt-3">
                    <div class="card">

                        <form method="POST" action="proses.php" id="submit-form-suara">
                            <div class="card-body">
                            
                                <div class="row">

                                    

                                    <div class="row">

                                        <div class="col-sm-6 mb-6 mb-sm-0 mt-3">
                                            <img src="<?=$Src?>" width="100%" />
                                        </div>
                                        <div class="col-sm-6 mb-6 mb-sm-0 mt-3">
                                            <form method="POST" action="proses.php" id="submit-form-suara">
                                                <div class="mb-3">
                                                    <label class="form-label" style="font-weight: bold;">Jumlah DPT <?= $KategoriCapil ?></label>
                                                    <input type="text" class="form-control" id="jumlah_dpt" name="jumlah_dpt" onkeypress="return isNumberKey(event)" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" style="font-weight: bold;">Jumlah DPTB <?= $KategoriCapil ?></label>
                                                    <input type="text" class="form-control" id="jumlah_dptb" name="jumlah_dptb" onkeypress="return isNumberKey(event)" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" style="font-weight: bold;">Jumlah DPK <?= $KategoriCapil ?></label>
                                                    <input type="text" class="form-control" id="jumlah_dpk" name="jumlah_dpk" onkeypress="return isNumberKey(event)" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" style="font-weight: bold;">Jumlah Pemilih</label>
                                                    <input type="text" class="form-control" id="jumlah_pemilih" name="jumlah_pemilih" onkeypress="return isNumberKey(event)" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" style="font-weight: bold;">Jumlah Suara Sah <?= $KategoriCapil ?></label>
                                                    <input type="text" class="form-control" id="jumlah_suara_sah" name="jumlah_suara_sah" onkeypress="return isNumberKey(event)" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" style="font-weight: bold;">Jumlah Suara Tidak Sah <?= $KategoriCapil ?></label>
                                                    <input type="text" class="form-control" id="jumlah_suara_tidak_sah" name="jumlah_suara_tidak_sah" onkeypress="return isNumberKey(event)" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" style="font-weight: bold;">Jumlah Pengguna Hak Pilih</label>
                                                    <input type="text" class="form-control" id="jumlah_pengguna_hak_pilih" name="jumlah_pengguna_hak_pilih" onkeypress="return isNumberKey(event)" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" style="font-weight: bold;">Foto Hasil Suara <?= $KategoriCapil ?></label>
                                                    <input type="file" class="form-control" id="foto" name="foto" accept="image/*" onchange="validateImageSize(this, event), handleImageUpload()" required>
                                                    <div class="col-sm-12 mb-6 mb-sm-0 mt-3" id="output" style="color: red;"></div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="d-flex justify-content-center align-items-center">
                                                        <img id="image-preview" style="width:200px;transition: transform 0.5s ease;" onclick="zoomImage(this)">
                                                    </div>
                                                </div>
                                                <div id="zoom-container" style="display: none;position: fixed;width: 50%;height: 50%;background: rgba(0, 0, 0, 0.8);justify-content: center;align-items: center;cursor: pointer;" onclick="closeZoom()">
                                                    <img id="zoomed-image" style="max-width: 100%;max-height: 100%;cursor: pointer;">
                                                </div>

                                                <input type="hidden" class="form-control" name="no_ktp" id="no_ktp" value="<?= $NomorKTP ?>">
                                                <input type="hidden" class="form-control" name="kategori_capil" id="kategori_capil" value="<?= $KategoriCapil ?>">
                                                <input type="hidden" class="form-control" name="kode_partai" id="kode_partai" value="<?= $KodePartai ?>">
                                                <input type="hidden" class="form-control" name="id_capil" id="id_capil" value="<?= $IdPPWP ?>">
                                                <input type="hidden" class="form-control" name="pc" id="pc" value="<?= $PasanganCalon ?>">
                                                <input type="hidden" class="form-control" name="src" id="src" value="<?= $Src ?>">
                                                <input type="hidden" class="form-control" name="imagebase64" id="imagebase64">
                                                <input type="hidden" class="form-control" name="submit-input-suara" value="submit-input-suara">

                                                <div class="card-footer text-body-secondary">
                                                    <button type="submit" class="btn btn-success" id="submit-input-suara" onclick="disableButton()"><i class="bi bi-check-circle-fill"></i> Submit</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>

                                    </div>

                                    <!--

                                    

                                    <div class="col-sm-6 mb-6 mb-sm-0 mt-3">
                                        
                                    </div>

                                    <div class="col-sm-6 mb-6 mb-sm-0 mt-3">
                                        
                                    </div>

                                    <hr/>

                                    <div class="col-sm-6 mb-6 mb-sm-0 mt-3">
                                        
                                    </div>

                                    <div class="col-sm-6 mb-6 mb-sm-0 mt-3">
                                        
                                    </div>

                                    <div class="col-sm-6 mb-6 mb-sm-0 mt-3">
                                        
                                    </div>

                                    <hr/>

                                    <div class="col-sm-12 mb-6 mb-sm-0 mt-3">
                                       
                                    </div>

                                    <div class="col-sm-12 mb-6 mb-sm-0">
                                        
                                    </div>

                                    

                                     -->
                                
                                <!-- </div> -->
                            
                            </div>
                            
                        </form>
                    </div>
                </div>

                <?php
            }
            
            ?>

		</div>
	</section>

</main>

<?php

require_once('footer.php');

?>

<script type="text/JavaScript">

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    }

    function disableButton() {
        var jumlah_dpt = document.getElementById('jumlah_dpt').value()
    
        if (jumlah_dpt == "") {
            return false
        }

        var form = document.getElementById('submit-form-suara');
        if (form) {
            form.submit();
        }

        var submitButton = document.getElementById('submit-input-suara');
        if (submitButton) {
            submitButton.disabled = true;
        }
        return true;
    }

    var zoomed = false;

    function zoomImage(originalImage) {
        var zoomContainer = document.getElementById('zoom-container');
        var zoomedImage = document.getElementById('zoomed-image');

        zoomedImage.src = originalImage.src;
        zoomContainer.style.display = 'flex';
    }

    function validateImageSize(input, event) {
        const maxSizeInBytes = 1024 * 1024; // 1Mb
        const file = input.files[0];
        var imagePreview = document.getElementById('image-preview');
        var outputDiv = document.getElementById('output');
        outputDiv.innerText = "";

        if (file && file.size > maxSizeInBytes) {
            imagePreview.src = "";
            outputDiv.innerText = 'Ukuran gambar terlalu besar, maksimal (1 MB). Silahkan pilih gambar yang lebih kecil!';
            input.value = "";
        } else {
            previewImage(event)
        }
    }

    function previewImage(event) {
        var input = event.target;

        var reader = new FileReader();
        reader.onload = function () {
            var imagePreview = document.getElementById('image-preview');
            imagePreview.src = reader.result;
        };

        reader.readAsDataURL(input.files[0]);
    }

    function closeZoom() {
        var zoomContainer = document.getElementById('zoom-container');
        zoomContainer.style.display = 'none';
    }

    function handleImageUpload() {
        var input = document.getElementById('foto');
        var imagebase64 = document.getElementById('imagebase64');
        
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                var base64Image = e.target.result;
                imagebase64.value = base64Image
                // console.log('Base64 Image:', base64Image);

                displayBase64Image(base64Image);
            };

            reader.readAsDataURL(input.files[0]);
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