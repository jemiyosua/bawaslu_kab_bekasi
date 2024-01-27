<?php

session_start();

if (!isset($_SESSION['username']) && (!isset($_SESSION['password']))) {

    header('location:login.php');
}

require_once('header.php');

require_once('navbar.php');

require_once('sidebar.php');

require_once('home.php');

require_once('footer.php');


