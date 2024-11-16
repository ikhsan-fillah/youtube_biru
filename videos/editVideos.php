<?php
//mulaikan session
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
    $new_title = $_POST['title']; //mengambil judul baru dan dimasukan ke var
    $new_description = $_POST['description']; //mengambil deskripsi baru dan dimasukan ke var
    $new_thumbnail = $_FILES['thumbnail']['name']; //mengambil thumbnail baru dan dimasukan ke var

    //memeriksa apakah thumbnail baru diupload
    if ($new_thumbnail) {
        $target_dir = "../assets/uploads/thumbnails/"; //menenenetukan direktori tujuan file utk thumbnail
        //menentukan path lengkap file thumbnail baru yg diupload
        $target_file = $target_dir . basename($new_thumbnail);
        //memindahkan file thumbnail baru dari direktori sementara ke direktori tujuan
        move_uploaded_file($_FILES['thumbnail']['tmp_name'], $target_file);
    }

    //query untuk mengupdate judul, deskripsi, dan thumbnail video berdasarkan video_id nya
    $sql_update = "UPDATE videos SET title = ?, description = ?, thumbnail_path = ? WHERE video_id = ?";
    $stmt_update = $conn->prepare($sql_update); //menyiapkan statement update untuk query
    $stmt_update->bind_param("sssi", $new_title, $new_description, $new_thumbnail, $video_id); //mengikat parameter string judul, deskripsi, thumbnail, dan integer video_id ke query
    
    //menjalankan query dan jika berhasil redirect ke halaman profile
    if ($stmt_update->execute()) { 
        header("Location: ../pages/profile.php");
        exit();
    } else {
        echo 'error';
    }
    $stmt_update->close(); //menutup statement query update
}

$conn->close(); //menutup koneksi database
?>