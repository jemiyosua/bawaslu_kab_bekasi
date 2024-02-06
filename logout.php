<?php

session_start();

require_once('koneksi.php');

$Username = $_SESSION['username'];
$Password = $_SESSION['password'];
$sql = mysqli_query($conn, "UPDATE db_login SET flag_login = '0' WHERE username = '$Username' AND password = '$Password'");

unset($Username);
unset($Password);

session_unset();
session_destroy();

mysqli_close($conn);

header("location:login.php");