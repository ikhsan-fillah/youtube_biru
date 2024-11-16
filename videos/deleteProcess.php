<?php
//memeulai session
session_start();
//koneksikan ke database
require_once '../config/database.php';

//jika user belum login, redirect ke halaman login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

//cek apakah metode requestnya POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $video_id = $_POST['video_id']; //mengambil vidionya dan dimasukan ke var

    //query untuk menghapus video berdasarkan video_id nya
    $sql_delete = "DELETE FROM videos WHERE video_id = ?";
    $stmt_delete = $conn->prepare($sql_delete);//menyiapkan statement untuk query
    $stmt_delete->bind_param("i", $video_id);//mengikat parameter integer video_id ke query
    //menjalankan query dan jika berhasil redirect ke halaman profile
    if ($stmt_delete->execute()) {
        header("Location: ../pages/profile.php");
        exit();
    } else { //jika gagal, tampilkan error
        echo 'error';
    }
    $stmt_delete->close(); //menutup statement query delete
}

$conn->close(); //menutup koneksi database
?>