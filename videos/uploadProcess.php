<?php
// Memulai session
session_start();
// Koneksikan ke database
require_once '../config/database.php';

//jika user belum login, redirect ke halaman login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

//jika metode permintaannya POST, maka jalankan kode dalam blok
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title']; //mengambil nilai judul dari POST
    $description = $_POST['description']; //mengambil nilai deskripsi dari POST
    $user_id = $_SESSION['user_id']; //mengambil user_id dari session

    //memeriksa apakah file video diunggah jika tidak ada kesalahan.
    if (isset($_FILES['video']) && $_FILES['video']['error'] == 0) { 
        $allowed_video = ['mp4', 'avi', 'mov', 'wmv']; //membuat array yang berisi ekstensi file video yang diperbolehkan
        $video_filename = $_FILES['video']['name']; //mengambil nama file video yang diunggah
        $video_filetype = pathinfo($video_filename, PATHINFO_EXTENSION); //mengambil ekstensi file video yang diunggah

        //memeriksa apakah ekstensi file video yang diunggah sesuai dengan yang diperbolehkan
        if (in_array($video_filetype, $allowed_video)) { 
            $new_video_filename = uniqid() . '.' . $video_filetype; //membuat nama file video baru dengan menambahkan id unik
            $video_destination = realpath('../assets/uploads/videos') . '/' . $new_video_filename; //menentukan path lengkap untuk menyimpan file video baru

            //memindahkan file video yang diunggah dari direktori sementara ke direktori tujuan
            if (move_uploaded_file($_FILES['video']['tmp_name'], $video_destination)) {
                //memeriksa apakah file thumbnail diunggah jika tidak ada kesalahan.
                if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == 0) {
                    $allowed_image = ['jpg', 'jpeg', 'png', 'gif']; //membuat array yang berisi ekstensi file thumbnail yang diperbolehkan
                    $thumbnail_filename = $_FILES['thumbnail']['name']; //mengambil nama file thumbnail yang diunggah
                    $thumbnail_filetype = pathinfo($thumbnail_filename, PATHINFO_EXTENSION); //mengambil ekstensi file thumbnail yang diunggah

                    //memeriksa apakah ekstensi file thumbnail yang diunggah sesuai dengan yang diperbolehkan
                    if (in_array($thumbnail_filetype, $allowed_image)) {
                        $new_thumbnail_filename = uniqid() . '.' . $thumbnail_filetype; //membuat nama file thumbnail baru dengan menambahkan id unik
                        $thumbnail_destination = realpath('../assets/uploads/thumbnails') . '/' . $new_thumbnail_filename; //menentukan path lengkap untuk menyimpan file thumbnail baru

                        //memindahkan file thumbnail yang diunggah dari direktori sementara ke direktori tujuan
                        if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $thumbnail_destination)) {
                            //query untuk menambahkan data video baru ke database
                            $sql = "INSERT INTO videos (user_id, title, description, video_path, thumbnail_path, views, likes, dislikes, created_at, updated_at, upload_date) VALUES (?, ?, ?, ?, ?, 0, 0, 0, NOW(), NOW(), NOW())";
                            //menyiapkan statement untuk query
                            if ($stmt = $conn->prepare($sql)) {
                                //mengikat parameter integer, string, string, string, dan string ke query
                                $stmt->bind_param("issss", $user_id, $title, $description, $new_video_filename, $new_thumbnail_filename);
                                //menjalankan query dan jika berhasil redirect ke halaman index
                                if ($stmt->execute()) {
                                    header("Location: ../pages/index.php");
                                    exit();
                                } else {
                                    echo "<script>alert('ada kesalahan, silahkan coba lagi'); window.location.href = 'upload.php';</script>";
                                }
                                $stmt->close(); //menutup statement query
                            }
                        } else { //jika gagal memindahkan file thumbnail
                            echo "<script>alert('gagal memindahkan file thumbnail.'); window.location.href = 'upload.php';</script>";
                        }
                    } else { //jika ekstensi file thumbnail tidak sesuai
                        echo "<script>alert('ekstensi file thumbnail tidak sesuai.'); window.location.href = 'upload.php';</script>";
                    }
                } else { //jika thumbnail tidak diunggah
                    echo "<script>alert('tolong unggah thumbnail.'); window.location.href = 'upload.php';</script>";
                }
            } else { //jika gagal memindahkan file video
                echo "<script>alert('gagal memindahkan file video.'); window.location.href = 'upload.php';</script>";
            }
        } else { //jika ekstensi file video tidak sesuai
            echo "<script>alert('ekstensi file video tidak sesuai.'); window.location.href = 'upload.php';</script>";
        }
    } else { //jika video tidak diunggah
        echo "<script>alert('tolong unggah video.'); window.location.href = 'upload.php';</script>";
    }
    $conn->close(); //menutup koneksi database
}
?>