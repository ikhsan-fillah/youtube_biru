<?php
session_start();
require_once '../config/database.php';

// Periksa apakah pengguna sudah login
$isLoggedIn = isset($_SESSION['username']);
$username = $isLoggedIn ? $_SESSION['username'] : '';

// Jika pengguna belum login, arahkan ke halaman login
if (!$isLoggedIn) {
    echo 'error';
    exit();
}

// Jika form disubmit, hapus video dari database
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $video_id = $_POST['video_id'];

    // Hapus video dari database
    $sql_delete = "DELETE FROM videos WHERE video_id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $video_id);
    if ($stmt_delete->execute()) {
        header("Location: ../pages/profile.php");
        exit();
    } else {
        echo 'error';
    }
    $stmt_delete->close();
}

$conn->close();
?>