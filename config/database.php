<?php
require_once 'config.php';

// Menggunakan pengaturan dari config.php
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die('maaf koneksi gagal: '.$conn->connect_error);
} else {
    echo 'koneksi berhasil';
}
?>