<?php
session_start();
require_once '../config/database.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: ../auth/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user_id'];

    // Validasi file video
    if (isset($_FILES['video']) && $_FILES['video']['error'] == 0) {
        $allowed_video = ['mp4', 'avi', 'mov', 'wmv'];
        $video_filename = $_FILES['video']['name'];
        $video_filetype = pathinfo($video_filename, PATHINFO_EXTENSION);

        if (in_array($video_filetype, $allowed_video)) {
            $new_video_filename = uniqid() . '.' . $video_filetype;
            $video_destination = realpath('../assets/uploads/videos') . '/' . $new_video_filename;

            if (move_uploaded_file($_FILES['video']['tmp_name'], $video_destination)) {
                // Validasi file thumbnail
                if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == 0) {
                    $allowed_image = ['jpg', 'jpeg', 'png', 'gif'];
                    $thumbnail_filename = $_FILES['thumbnail']['name'];
                    $thumbnail_filetype = pathinfo($thumbnail_filename, PATHINFO_EXTENSION);

                    if (in_array($thumbnail_filetype, $allowed_image)) {
                        $new_thumbnail_filename = uniqid() . '.' . $thumbnail_filetype;
                        $thumbnail_destination = realpath('../assets/uploads/thumbnails') . '/' . $new_thumbnail_filename;

                        if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $thumbnail_destination)) {
                            // Simpan informasi video ke database
                            $sql = "INSERT INTO videos (user_id, title, description, video_path, thumbnail_path, views, likes, dislikes, created_at, updated_at, upload_date) VALUES (?, ?, ?, ?, ?, 0, 0, 0, NOW(), NOW(), NOW())";
                            if ($stmt = $conn->prepare($sql)) {
                                $stmt->bind_param("issss", $user_id, $title, $description, $new_video_filename, $new_thumbnail_filename);
                                if ($stmt->execute()) {
                                    header("Location: ../pages/index.php");
                                    exit();
                                } else {
                                    echo "<script>alert('Something went wrong. Please try again later.'); window.location.href = 'upload.php';</script>";
                                }
                                $stmt->close();
                            }
                        } else {
                            echo "<script>alert('Failed to move uploaded thumbnail file.'); window.location.href = 'upload.php';</script>";
                        }
                    } else {
                        echo "<script>alert('Invalid thumbnail file type. Only JPG, JPEG, PNG, and GIF are allowed.'); window.location.href = 'upload.php';</script>";
                    }
                } else {
                    echo "<script>alert('Please select a thumbnail file to upload.'); window.location.href = 'upload.php';</script>";
                }
            } else {
                echo "<script>alert('Failed to move uploaded video file.'); window.location.href = 'upload.php';</script>";
            }
        } else {
            echo "<script>alert('Invalid video file type. Only MP4, AVI, MOV, and WMV are allowed.'); window.location.href = 'upload.php';</script>";
        }
    } else {
        echo "<script>alert('Please select a video file to upload.'); window.location.href = 'upload.php';</script>";
    }
    $conn->close();
}
?>