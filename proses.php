<?php

require_once('koneksi.php');

session_start();

if (isset($_POST['login-admin'])) {

    $Username = $_POST['username'];
    $Password = $_POST['password'];

    $sql = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_login WHERE username = '$Username' AND password = '$Password'");
    $row = mysqli_fetch_assoc($sql);
    $CountAdmin = $row["cnt"];

    if ($CountAdmin > 0) {
        $_SESSION['username'] = $Username;
        $_SESSION['password'] = $Password;
        header('location: main.php');
    } else {
        $_SESSION['pesanError'] = "Username atau Password Anda Salah!";
        header('location: login.php');
    }
} else if (isset($_POST['cek-ktp'])) {

    $NomorKTP = $_POST['no_ktp'];

    $sql = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM db_ptps WHERE no_ktp = '$NomorKTP'");
    $row = mysqli_fetch_assoc($sql);
    $CountKTP = $row["cnt"];

    if ($CountKTP > 0) {
        // $_SESSION['pesan'] = "Nomor KTP Anda Terdaftar!";
        $_SESSION['nomor_ktp'] = $NomorKTP;
        header('location: detail-data-ptps.php');
    } else {
        $_SESSION['pesanError'] = "Nomor KTP Anda Tidak Terdaftar!";
        header('location: input-ktp.php');
    }
}