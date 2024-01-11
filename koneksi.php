<?php

$server = "localhost";
$user = "root";
$password = "";
$database = "project-uas";

//buat koneksi
$koneksi = mysqli_connect($server,$user,$password,$database) or die(mysqli_error($koneksi));
