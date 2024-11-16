<?php
//mulai session
session_start();

//koneksikan ke database
require_once '../config/database.php';

//jika user belum login, redirect ke halaman login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

//query untuk mengambil data user berdasarkan username
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql); //menyiapkan statement untuk query
$stmt->bind_param("s", $username); //mengikat parameter string username ke query
$stmt->execute(); //mengeksekusi query
$result = $stmt->get_result(); //mengambil hasil query dan disimpan ke variabel $result
$user = $result->fetch_assoc(); //mengambil data user dari hasil query dan disimpan ke variabel $user

//jika metode permintaannya POST, maka jalankan kode dalam blok
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_username = $_POST['username']; //mengambil nilai username baru dari form
    $new_email = $_POST['email'];//mengambil nilai email baru dari form
    //mengenkripsi password baru dengan bcrypt
    $new_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    //query untuk mengupdate username, email, dan password data user berdasarkan user_id
    $sql_update = "UPDATE users SET username = ?, email = ?, password = ? WHERE user_id = ?";
    $stmt_update = $conn->prepare($sql_update); //menyiapkan statement untuk query
    //mengikat parameter string username, email, password, dan integer user_id ke query
    $stmt_update->bind_param("sssi", $new_username, $new_email, $new_password, $user['user_id']);
    //menjalankan query
    if ($stmt_update->execute()) {
        $_SESSION['username'] = $new_username; //mengupdate session username
        header("Location: ../pages/profile.php"); //redirect ke halaman profile
        exit();//mengakhiri eksekusi
    } else {
        echo 'error'; //jika gagal menampilkan pesan error
    }
    //menutup statement update
    $stmt_update->close();
}

$stmt->close(); //menutup statement
$conn->close();//menutup koneksi
?>