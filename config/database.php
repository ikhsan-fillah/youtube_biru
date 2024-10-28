<?php
// config.php

$host = 'localhost'; // Your database host
$dbname = 'youtube_biru'; // Your database name
$username = 'root'; // Your database username
$password = ''; // Your database password

$connect = new mysqli($host,$dbname,$username,$password);
if ($connect->connect_error) {
    die('maaf koneksi gagal: '.$connect->connect_error);
}
?>