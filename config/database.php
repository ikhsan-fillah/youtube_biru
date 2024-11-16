<?php
// Konfigurasi database
$serverName = "localhost";
$username = "root";
$password = "";
$dbname = "youtube_biru";

// Membuat koneksi ke database
$conn = new mysqli($serverName, $username, $password, $dbname);

// Jika koneksi gagal tampilkan pesan eror
if ($conn->connect_error) {
    die('maaf koneksi gagal: '.$conn->connect_error);
}
?>