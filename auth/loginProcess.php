<?php

session_start(); //menyimpan pengguna yang login
require_once '../config/database.php'; //include db dan file di load sekali saja

if ($_SERVER['REQUEST_METHOD'] == 'POST') { //memerikas apakah metode permintaan adl POST
    //mengambil niilai email dan password dari form login
    $email = $_POST['email']; 
    $password = $_POST['password'];

    //Cek jika email dan password tidak kosong
    if (!empty($email) && !empty($password)) {
        //menyiapkan query untuk mengambil data user berdasarkan email
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?"); 
        $stmt->bind_param("s", $email); //mengikat parameter email ke query
        $stmt->execute(); //mengeksekusi query
        $result = $stmt->get_result(); //mengambil hasil query

        //cek jika user telah ada
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc(); //mengambil data user dari hasil query
            //cek password yang diinputkan dengan password yang ada di database
            if (password_verify($password, $user['password'])) {
                //jika password benar, simpan data user ke session
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                //redirect ke halaman index setelah login
                header("Location: ../pages/index.php"); 
                exit(); //akhiri eksekusi
            } else {
                //jika password salah
                echo "Password salah.";
            }
        } else {
            //jika user tidak ditemukan
            echo "User tidak ditemukan.";
        }
    } else {
        //jika email dan password kosong
        echo "Email dan password wajib diisikan.";
    }
}
?>