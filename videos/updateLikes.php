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

//memeriksa dan mengambil nilai video_id dan action dari POST dengan ternary operator
$video_id = isset($_POST['video_id']) ? intval($_POST['video_id']) : 0;
$action = isset($_POST['action']) ? $_POST['action'] : '';

//memeriksa apakah video_id lebih dari 0 dan action adalah like, dislike, unlike, atau undislike
if ($video_id > 0 && in_array($action, ['like', 'dislike', 'unlike', 'undislike'])) {
    //jika action like, maka query untuk menambahkan jumlah likes pada video
    if ($action == 'like') {
        $sql = "UPDATE videos SET likes = likes + 1 WHERE video_id = ?";
    } elseif ($action == 'dislike') { //jika action dislike, maka query untuk menambahkan jumlah dislikes pada video
        $sql = "UPDATE videos SET dislikes = dislikes + 1 WHERE video_id = ?";
    } elseif ($action == 'unlike') { //jika action unlike, maka query untuk mengurangi jumlah likes pada video
        $sql = "UPDATE videos SET likes = likes - 1 WHERE video_id = ?";
    } elseif ($action == 'undislike') { //jika action undislike, maka query untuk mengurangi jumlah dislikes pada video
        $sql = "UPDATE videos SET dislikes = dislikes - 1 WHERE video_id = ?";
    }

    $stmt = $conn->prepare($sql); //menyiapkan statement untuk query
    $stmt->bind_param("i", $video_id); //mengikat parameter integer video_id ke query
    //menjalankan query dan jika berhasil menampilkan pesan success
    if ($stmt->execute()) { 
        echo 'berhasil';
    } else {
        echo 'error';
    }
    $stmt->close(); //menutup statement query
} else {
    echo 'error';
}

$conn->close(); //menutup koneksi database
?>