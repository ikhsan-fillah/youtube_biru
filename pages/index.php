<?php
//mulaikan session
session_start();
//mengkoneksikan ke database 
require_once '../config/database.php';

//memeriksa apakah pengguna sudah login dengan memeriksa session username
$sudahLogin = isset($_SESSION['username']);
//mengatur var username berdasarkan nilai true atau false $sudahLogin
$username = $sudahLogin ? $_SESSION['username'] : '';

//jika pengguna belum login, redirect ke halaman login
if (!$sudahLogin) {
    header("Location: ../auth/login.php");
    exit(); //mengakhiri eksekusi
}

//query untuk mengambil data video dan user yang mengupload video dengan join tabel videos dan users
$sql = "SELECT videos.*, users.username, users.user_id FROM videos JOIN users ON videos.user_id = users.user_id ORDER BY upload_date DESC";
//menjalankan query dan disimpan ke variabel $result
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouBlue</title>
    <link rel="stylesheet" href="../assets/css/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jersey+10&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=Prompt:wght@500&family=Source+Code+Pro:ital,wght@0,200..900&display=swap" rel="stylesheet">
    <style>
        *{
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body>
    <?php include '../includes/navbarAfterLgn.php'; ?>
    <div class="flex h-screen"> <!-- Side Bar -->
        <?php include '../includes/sidebar.php'; ?>
        <!-- Main Content -->
        <div class="flex-1 p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!--  -->
                <?php 
                //mengambil data video dari hasil query dan disimpan ke variabel $row
                while ($row = $result->fetch_assoc()): 
                ?>
                    <div class="bg-white p-4 rounded-lg shadow-lg">
                        <!-- link ke halaman watch dan mengambil id video dari var $row dengan parameter video_id -->
                        <a href="watch.php?id=<?php echo $row['video_id']; ?>">
                            <!-- mengambil dan menampilkan thumbnail dari var $row dengan parameter thumbnail_path -->
                            <img src="../assets/uploads/thumbnails/<?php echo htmlspecialchars($row['thumbnail_path']); ?>" alt="Thumbnail" class="mb-4 w-full h-48 object-cover">
                        </a>
                        <!-- menampilkan judul video dari var $row dengan parameter title -->
                        <h2 class="text-xl font-bold mb-2"><?php echo htmlspecialchars($row['title']); ?></h2>
                        <!-- link ke halaman profile dan mengambil user_id dari var $row -->
                        <a href="profile.php?id=<?php echo $row['user_id']; ?>"><p class="text-gray-700 mb-2"><?php echo htmlspecialchars($row['username']); ?></p></a>
                        <div class="flex items-center justify-between text-gray-600">
                            <!-- menampilkan views dan likes dari var $row -->
                            <span>Views: <?php echo $row['views']; ?></span>
                            <span>Likes: <?php echo $row['likes']; ?></span>
                        </div>
                    </div>
                <!-- memberhentikan perulangan -->
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</body>
</html>

<?php
//menutup koneksi database
$conn->close();
?>