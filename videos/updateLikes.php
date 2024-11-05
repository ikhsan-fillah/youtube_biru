<?php
session_start();
require_once '../config/database.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    echo 'error';
    exit();
}

$video_id = isset($_POST['video_id']) ? intval($_POST['video_id']) : 0;
$action = isset($_POST['action']) ? $_POST['action'] : '';

if ($video_id > 0 && ($action == 'like' || $action == 'unlike' || $action == 'dislike' || $action == 'undislike')) {
    if ($action == 'like') {
        $sql = "UPDATE videos SET likes = likes + 1 WHERE video_id = ?";
    } elseif ($action == 'unlike') {
        $sql = "UPDATE videos SET likes = likes - 1 WHERE video_id = ?";
    } elseif ($action == 'dislike') {
        $sql = "UPDATE videos SET dislikes = dislikes + 1 WHERE video_id = ?";
    } elseif ($action == 'undislike') {
        $sql = "UPDATE videos SET dislikes = dislikes - 1 WHERE video_id = ?";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $video_id);
    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }
    $stmt->close();
} else {
    echo 'error';
}

$conn->close();
?>