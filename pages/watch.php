<?php
//mulai session
session_start();
//koneksikan ke database
require_once '../config/database.php';

//jika pengguna belum login, redirect ke halaman login
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    header("Location: ../auth/login.php");
    exit();
}

//mengambil data user_id dan username dari session
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

//memeriksa parameter id dalam URL, jika ada, ambil nilai id dan dikoversikan ke int, jika tidak, set nilai id ke 0
$video_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

//query untuk mengambil data video berdasarkan video_id dan disimpan ke variabel $sql
$sql = "SELECT videos.*, users.username, users.subscribers FROM videos JOIN users ON videos.user_id = users.user_id WHERE videos.video_id = ?";
$stmt = $conn->prepare($sql); //menyiapkan statment untuk query
$stmt->bind_param("i", $video_id); //mengikat parameter integer dari video_id ke query
$stmt->execute(); //menjalankan query
$result = $stmt->get_result(); //mengambil hasil query dan disimpan ke variabel $result
$video = $result->fetch_assoc(); //mengambil data video dari hasil query dan disimpan ke variabel $video 

//jika video tidak ditemukan, redirect ke halaman index
if (!$video) {
    header("Location: index.php");
    exit();
}

//memeriksa apakah form disubmit dan cek action ada di dalam POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    //mengambil nilai action dari dalam form
    $action = $_POST['action'];

    //jika action adalah like
    if ($action === 'like') {
        //query untuk memeriksa jumlah like dan dislike pada video
        $sql_check = "SELECT likes, dislikes FROM videos WHERE video_id = ?";
        $stmt_check = $conn->prepare($sql_check); //menyiapkan statment untuk query
        $stmt_check->bind_param("i", $video_id); //mengikat parameter integer dari video_id ke query
        $stmt_check->execute(); //menjalankan query
        $result_check = $stmt_check->get_result(); //mengambil hasil query dan disimpan ke variabel $result_check
        $video_data = $result_check->fetch_assoc(); //mengambil data video dari hasil query dan disimpan ke variabel $video_data

        //jika jumlah like lebih dari 0
        if ($video_data['likes'] > 0) {
            //query untuk kurangi jumlah like
            $sql = "UPDATE videos SET likes = likes - 1 WHERE video_id = ?";
            $stmt = $conn->prepare($sql); //menyiapkan statment untuk query
            $stmt->bind_param("i", $video_id); //mengikat parameter integer dari video_id ke query
            $stmt->execute();//menjalankan query
            $stmt->close();//menutup statment
        } else {
            //query untuk tambah jumlah like dan kurangi jumlah dislike jika vidio belum di like
            $sql = "UPDATE videos SET likes = likes + 1, dislikes = IF(dislikes > 0, dislikes - 1, dislikes) WHERE video_id = ?";
            $stmt = $conn->prepare($sql); //menyiapkan statment untuk query
            $stmt->bind_param("i", $video_id); //mengikat parameter integer dari video_id ke query
            $stmt->execute(); //menjalankan query
            $stmt->close(); //menutup statment
        }
    } elseif ($action === 'dislike') { //jika action adalah dislike
        //query untuk memeriksa jumlah like dan dislike pada video
        $sql_check = "SELECT likes, dislikes FROM videos WHERE video_id = ?";
        $stmt_check = $conn->prepare($sql_check);//menyiapkan statment untuk query
        $stmt_check->bind_param("i", $video_id);//mengikat parameter integer dari video_id ke query
        $stmt_check->execute();//menjalankan query
        $result_check = $stmt_check->get_result();//mengambil hasil query dan disimpan ke variabel $result_check
        $video_data = $result_check->fetch_assoc();//mengambil data video dari hasil query dan disimpan ke variabel $video_data

        //jika jumlah dislike lebih dari 0
        if ($video_data['dislikes'] > 0) {
            //query untuk kurangi jumlah dislike
            $sql = "UPDATE videos SET dislikes = dislikes - 1 WHERE video_id = ?";
            $stmt = $conn->prepare($sql); //menyiapkan statment untuk query
            $stmt->bind_param("i", $video_id); //mengikat parameter integer dari video_id ke query
            $stmt->execute(); //menjalankan query
            $stmt->close(); //menutup statment
        } else {
            //query untuk tambah jumlah dislike dan kurangi jumlah like jika vidio belum di dislike
            $sql = "UPDATE videos SET dislikes = dislikes + 1, likes = IF(likes > 0, likes - 1, likes) WHERE video_id = ?";
            $stmt = $conn->prepare($sql); //menyiapkan statment untuk query
            $stmt->bind_param("i", $video_id); //mengikat parameter integer dari video_id ke query
            $stmt->execute(); //menjalankan query
            $stmt->close(); //menutup statment
        }
    } elseif ($action === 'subscribe') { //jika action adalah subscribe
        //query untuk tambah jumlah subscribers
        $sql = "UPDATE users SET subscribers = subscribers + 1 WHERE user_id = ?";
        $stmt = $conn->prepare($sql); //menyiapkan statment untuk query
        $stmt->bind_param("i", $video['user_id']); //mengikat parameter integer dari user_id ke query
        $stmt->execute(); //menjalankan query
        $stmt->close();//menutup statment
    } elseif ($action === 'unsubscribe') { //jika action adalah unsubscribe
        //query untuk kurangi jumlah subscribers
        $sql = "UPDATE users SET subscribers = subscribers - 1 WHERE user_id = ?";
        $stmt = $conn->prepare($sql); //menyiapkan statment untuk query
        $stmt->bind_param("i", $video['user_id']); //mengikat parameter integer dari user_id ke query
        $stmt->execute();//menjalankan query
        $stmt->close(); //menutup statment
    }

    //redirect ke halaman watch setelah melakukan action dengan parameter video_id untuk menampilkan video sesuai id
    header("Location: watch.php?id=$video_id");
    exit(); //mengakhiri eksekusi
}

//query untuk update views setiap kali video ditonton
$sql_update_views = "UPDATE videos SET views = views + 1 WHERE video_id = ?";
$stmt_update_views = $conn->prepare($sql_update_views); //menyiapkan statment untuk query
$stmt_update_views->bind_param("i", $video_id); //mengikat parameter integer dari video_id ke query
$stmt_update_views->execute();//menjalankan query
$stmt_update_views->close();//menutup statment

//query untuk mengambil jumlah subscribers dari user yang mengupload video
$sql_subscribe = "SELECT subscribers FROM users WHERE user_id = ?";
$stmt_subscribe = $conn->prepare($sql_subscribe); //menyiapkan statment untuk query
$stmt_subscribe->bind_param("i", $video['user_id']); //mengikat parameter integer dari user_id ke query
$stmt_subscribe->execute(); //menjalankan query
$result_subscribe = $stmt_subscribe->get_result(); //mengambil hasil query dan disimpan ke variabel $result_subscribe
$user_subscribe = $result_subscribe->fetch_assoc(); //mengambil data user dari hasil query dan disimpan ke variabel $user_subscribe
$is_subscribed = $user_subscribe['subscribers'] > 0; //memeriksa apakah user telah subscribe

//query untuk memeriksa apakah video telah di like atau dislike
$sql_like_dislike = "SELECT likes, dislikes FROM videos WHERE video_id = ?";
$stmt_like_dislike = $conn->prepare($sql_like_dislike); //menyiapkan statment untuk query
$stmt_like_dislike->bind_param("i", $video_id); //mengikat parameter integer dari video_id ke query
$stmt_like_dislike->execute(); //menjalankan query
$result_like_dislike = $stmt_like_dislike->get_result(); //mengambil hasil query dan disimpan ke variabel $result_like_dislike
$like_dislike_action = $result_like_dislike->fetch_assoc(); //mengambil data dari hasil query dan disimpan ke variabel $like_dislike_action
$is_liked = $like_dislike_action['likes'] > 0; //memeriksa apakah video sudah di like
$is_disliked = $like_dislike_action['dislikes'] > 0; //memeriksa apakah video sudah di dislike

//query untuk mengambil semua video kecuali video yang sedang ditonton dan diurutkan berdasarkan tanggal upload paling baru
$sql_all_videos = "SELECT * FROM videos WHERE video_id != ? ORDER BY upload_date DESC";
$stmt_all_videos = $conn->prepare($sql_all_videos); //menyiapkan statment untuk query 
$stmt_all_videos->bind_param("i", $video_id); //mengikat parameter integer dari video_id ke query
$stmt_all_videos->execute(); //menjalankan query
$result_all_videos = $stmt_all_videos->get_result(); //mengambil hasil query dan disimpan ke variabel $result_all_videos
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- judul halaman berdasarkan judul video -->
    <title><?php echo htmlspecialchars($video['title']); ?> - YouBlue</title>
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
    <div class="flex flex-col md:flex-row h-screen">
        <!-- Main Content -->
        <div class="flex-1 pl-28 pt-6 pr-12 rounded-lg">
            <div class="bg-white p-4 rounded-lg shadow-lg mb-6">
                <video class="rounded-lg" width="100%" controls>
                    <!-- menampilkan vidio dari folder uploads video dengan menggunakan vidio_path  dan mengatur tipe video -->
                    <source src="../assets/uploads/videos/<?php echo htmlspecialchars($video['video_path']); ?>" type="video/<?php echo pathinfo($video['video_path'], PATHINFO_EXTENSION); ?>">
                    Your browser does not support the video tag.
                </video>
                <!-- menampilkan judul video -->
                <h1 class="text-2xl font-bold mt-4"><?php echo htmlspecialchars($video['title']); ?></h1>
                <div class="flex items-center justify-between mt-2">
                    <div class="flex items-center">
                        <!-- menampilkan username -->
                        <p class="text-gray-700">By <?php echo htmlspecialchars($video['username']); ?></p>
                        <form action="watch.php?id=<?php echo $video_id; ?>" method="post" style="display: inline;">
                            <input type="hidden" name="action" value="<?php echo $is_subscribed ? 'unsubscribe' : 'subscribe'; ?>">
                            <button type="submit" class="bg-red-500 text-white rounded-full py-2 px-4 ml-4 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500">
                                <!-- ternary operator untuk subscribe atau unsubscribe -->
                                <?php echo $is_subscribed ? 'Subscribed' : 'Subscribe'; ?>
                            </button>
                        </form>
                        <!-- menampilkan jumlah views -->
                        <span class="text-gray-700 mx-4">Views: <?php echo $video['views']; ?></span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <form action="watch.php?id=<?php echo $video_id; ?>" method="post" style="display: inline;">
                            <input type="hidden" name="action" value="like">
                            <button type="submit" class="bg-gray-200 text-gray-700 rounded-full py-2 px-4 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                <!-- menampilkan jumlah likes -->
                                <i class="fa-solid fa-thumbs-up"></i> <?php echo $video['likes']; ?>
                            </button>
                        </form>
                        <form action="watch.php?id=<?php echo $video_id; ?>" method="post" style="display: inline;">
                            <input type="hidden" name="action" value="dislike">
                            <button type="submit" class="bg-gray-200 text-gray-700 rounded-full py-2 px-4 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                <!-- menampilkan jumlah dislikes -->
                                <i class="fa-solid fa-thumbs-down"></i> <?php echo $video['dislikes']; ?>
                            </button>
                        </form>
                        <button class="bg-gray-200 text-gray-700 rounded-full py-2 px-4 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500"><i class="fa-solid fa-share"></i> Share</button>
                        <button class="bg-gray-200 text-gray-700 rounded-full py-2 px-4 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500"><i class="fa-solid fa-download"></i> Download</button>
                    </div>
                </div>
                <div class="mt-4">
                    <h2 class="text-xl font-bold mb-2">Description</h2>
                    <!-- menampilkan isi deskripsi -->
                    <p class="text-gray-700"><?php echo nl2br(htmlspecialchars($video['description'])); ?></p>
                </div>
            </div>
        </div>
        <!-- Sidebar Content -->
        <div class="w-full md:w-1/4 pt-6 pr-20 overflow-y-auto">
            <div class="grid grid-cols-1 gap-6">
                <!-- menampilkan video lain yang telah diupload -->
                <?php while ($row = $result_all_videos->fetch_assoc()): ?>
                    <div class="bg-white p-4 rounded-lg shadow-lg">
                        <!-- menampilkan thumbnail video -->
                        <a href="watch.php?id=<?php echo $row['video_id']; ?>">
                            <img class="rounded-lg mb-2" src="../assets/uploads/thumbnails/<?php echo htmlspecialchars($row['thumbnail_path']); ?>" alt="Thumbnail" class="mb-4 w-full h-48 object-cover">
                        </a>
                        <a href="watch.php?id=<?php echo $row['video_id']; ?>">
                            <!-- menampilkan judul video -->
                            <h2 class="text-xl font-bold mb-2"><?php echo htmlspecialchars($row['title']); ?></h2>
                        </a>
                        <div class="flex items-center justify-between text-gray-600">
                            <!-- menampilkan jumlah views dan likes -->
                            <span>Views: <?php echo $row['views']; ?></span>
                            <span>Likes: <?php echo $row['likes']; ?></span>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</body>
</html>

<?php
$stmt->close(); //menutup statment
$stmt_subscribe->close(); //menutup statment subscribe
$stmt_all_videos->close(); //menutup statment all videos
$conn->close(); //menutup koneksi database
?>