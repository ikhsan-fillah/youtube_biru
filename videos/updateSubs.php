<?php
session_start();
require_once '../config/database.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    echo 'error';
    exit();
}

$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
$action = isset($_POST['action']) ? $_POST['action'] : '';

if ($user_id > 0 && ($action == 'subscribe' || $action == 'unsubscribe')) {
    if ($action == 'subscribe') {
        // Periksa apakah pengguna sudah subscribe
        $sql_check = "SELECT * FROM subscriptions WHERE user_id = ? AND subscribed_to = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("ii", $_SESSION['user_id'], $user_id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        
        if ($result_check->num_rows == 0) {
            // Tambahkan subscriber ke tabel subscriptions
            $sql = "INSERT INTO subscriptions (user_id, subscribed_to) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $_SESSION['user_id'], $user_id);
            if ($stmt->execute()) {
                // Tambahkan jumlah subscriber di tabel users
                $sql_update = "UPDATE users SET subscribers = subscribers + 1 WHERE user_id = ?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param("i", $user_id);
                $stmt_update->execute();
                $stmt_update->close();
                echo 'success';
            } else {
                echo 'error';
            }
            $stmt->close();
        } else {
            echo 'already_subscribed';
        }
        $stmt_check->close();
    } elseif ($action == 'unsubscribe') {
        // Hapus subscriber dari tabel subscriptions
        $sql = "DELETE FROM subscriptions WHERE user_id = ? AND subscribed_to = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $_SESSION['user_id'], $user_id);
        if ($stmt->execute()) {
            // Kurangi jumlah subscriber di tabel users
            $sql_update = "UPDATE users SET subscribers = subscribers - 1 WHERE user_id = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("i", $user_id);
            $stmt_update->execute();
            $stmt_update->close();
            echo 'success';
        } else {
            echo 'error';
        }
        $stmt->close();
    }
} else {
    echo 'error';
}

$conn->close();
?>