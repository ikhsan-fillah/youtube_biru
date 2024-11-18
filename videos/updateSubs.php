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

//memeriksa dan mengambil nilai user_id dan action dari POST dengan ternary operator
$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
$action = isset($_POST['action']) ? $_POST['action'] : '';

//memeriksa apakah user_id lebih dari 0 dan action adalah subscribe atau unsubscribe
if ($user_id > 0 && in_array($action, ['subscribe', 'unsubscribe'])) {
    //jika action subscribe, maka query untuk menambahkan data subscriptions
    if ($action == 'subscribe') {
        //query untuk menambahkan data subscriptions
        $sql = "INSERT INTO subscriptions (user_id, subscribed_to) VALUES (?, ?)";
    } elseif ($action == 'unsubscribe') { //jika action unsubscribe, maka query untuk menghapus data subscriptions
        //query untuk menghapus data subscriptions
        $sql = "DELETE FROM subscriptions WHERE user_id = ? AND subscribed_to = ?";
    }

    $stmt = $conn->prepare($sql); //menyiapkan statement untuk query
    $stmt->bind_param("ii", $_SESSION['user_id'], $user_id); //mengikat parameter integer user_id dan user_id ke query
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