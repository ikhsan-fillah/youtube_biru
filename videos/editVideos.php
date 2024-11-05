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

// Jika form disubmit, perbarui data video
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $video_id = $_POST['video_id'];
    $new_title = $_POST['title'];
    $new_description = $_POST['description'];
    $new_thumbnail = $_FILES['thumbnail']['name'];

    // Upload thumbnail
    if ($new_thumbnail) {
        $target_dir = "../assets/uploads/thumbnails/";
        $target_file = $target_dir . basename($new_thumbnail);
        move_uploaded_file($_FILES['thumbnail']['tmp_name'], $target_file);
    }

    $sql_update = "UPDATE videos SET title = ?, description = ?, thumbnail_path = ? WHERE video_id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sssi", $new_title, $new_description, $new_thumbnail, $video_id);
    if ($stmt_update->execute()) {
        header("Location: ../pages/profile.php");
        exit();
    } else {
        echo 'error';
    }
    $stmt_update->close();
}

$conn->close();
?>