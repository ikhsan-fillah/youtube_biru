<?php
//cek apakah form telah di submit dengan metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //koneksi ke database 
    require_once '../config/database.php';

    //mengambil nilai username, email, dan password 
    //yang telah diinputkan dalam form signup
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    //cek apakah username kosong atau bukan string
    if (empty($username) || !is_string($username)) {
        //jika kosong atau bukan string, tampilkan pesan error, dan redirect ke halaman signup
        echo "<script>alert('username harus terisi dan berupa string.'); window.location.href = 'signup.php';</script>";
        exit(); //mengakhiri eksekusi
    }

    //cek apakah email kosong atau bukan email yang valid
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        //jika kosong atau bukan email, tampilkan pesan error, dan redirect ke halaman signup
        echo "<script>alert('email harus terisi dan berupa email.'); window.location.href = 'signup.php';</script>";
        exit(); //mengakhiri eksekusi
    }

    //cek apakah password kurang dari 8 karakter atau tidak mengandung angka
    if (strlen($password) < 8 || !preg_match('/[0-9]/', $password)) {
        //jika kurang dari 8 karakter atau tidak mengandung angka, tampilkan pesan error, dan redirect ke halaman signup
        echo "<script>alert('password harus terisi dan minimal 8 karakter dan harus mengandung angka.'); window.location.href = 'signup.php';</script>";
        exit(); //mengakhiri eksekusi
    }

    //mengenkripsi password dengan bcrypt biar aman
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    //query untuk menyimpan data user ke database dan disimpan ke variabel $sql
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";

    //menyiapkan statment($stmt) untuk mengeksekusi query
    if ($stmt = $conn->prepare($sql)) {
        //mengikat parameter string dari username, email, dan password ke query
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        //menjalkankan query
        if ($stmt->execute()) {
            //jika berhasil, redirect ke halaman login
            header("location: login.php");
            exit(); //mengakhiri eksekusi
        } else {
            //jika gagal, menampilkan pesan eror
            echo "<script>alert('Pendaftaran gagal, silahkan coba lagi'); window.location.href = 'signup.php';</script>";
        }

        //menutup statment
        $stmt->close();
    }

    //menutup koneksi
    $conn->close();
}
?>