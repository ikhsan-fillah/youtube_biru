<?php
//mulaikan session
session_start();
//koneksikan ke database
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

//query mengambil data pengguna berdasarkan username dan disimpan ke variabel $sql
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql); // menyiapkan statment untuk query
$stmt->bind_param("s", $username); //mengikat parameter string username ke query
$stmt->execute(); //menjalankan query
$result = $stmt->get_result(); // mengambil hasil query dan disimpan ke variabel $result
$user = $result->fetch_assoc(); //mengambil data pengguna dari hasil query

//query mengambil jumlah video yang diupload oleh pengguna dan disimpan ke variabel $sql_videos
$sql_videos = "SELECT COUNT(*) as video_count FROM videos WHERE user_id = ?";
$stmt_videos = $conn->prepare($sql_videos); //menyiapkan statment untuk query
$stmt_videos->bind_param("i", $user['user_id']); //mengikat parameter integer user_id ke query
$stmt_videos->execute(); //menjalankan query
$result_videos = $stmt_videos->get_result(); //mengambil hasil query dan disimpan ke variabel $result_videos
$video_count = $result_videos->fetch_assoc()['video_count']; //mengambil jumlah video dari hasil query

//query mengambil video yang diupload mengurutkan secara desc dan disimpan ke variabel $sql_user_videos
$sql_user_videos = "SELECT * FROM videos WHERE user_id = ? ORDER BY upload_date DESC";
$stmt_user_videos = $conn->prepare($sql_user_videos); //menyiapkan statment untuk query
$stmt_user_videos->bind_param("i", $user['user_id']); //mengikat parameter integer user_id ke query
$stmt_user_videos->execute();//menjalankan query
$result_user_videos = $stmt_user_videos->get_result(); //mengambil hasil query dan disimpan ke variabel $result_user_videos
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- judul halaman berdasarkan username pengguna -->
    <title><?php echo htmlspecialchars($user['username']); ?>'s Profile - YouBlue</title>
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
        .modal {
            display: none;
            position: fixed;
            z-index: 50;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 75%; /* 3:4 aspect ratio */
            max-width: 600px;
            height: 75%; /* 3:4 aspect ratio */
            max-height: 800px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php include '../includes/navbarAfterLgn.php'; ?>
    <div class="flex h-screen"> <!-- Side Bar -->
        <?php include '../includes/sidebar.php'; ?>
        <!-- Main Content -->
        <div class="flex-1 p-6">
            <div class="bg-white p-4 rounded-lg shadow-lg mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <!-- menampilkan username dari $user, jumlah subscriber dari $user, dan jumlah video dari $video_count -->
                        <h1 class="text-2xl font-bold mb-2"><?php echo htmlspecialchars($user['username']); ?></h1>
                        <p class="text-gray-700 mb-2">Subscribers: <?php echo htmlspecialchars($user['subscribers']); ?></p>
                        <p class="text-gray-700 mb-2">Videos Uploaded: <?php echo $video_count; ?></p>
                    </div>
                    <div>
                        <button id="editProfileBtn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 shadow-lg rounded-tl-lg rounded-br-lg focus:outline-none focus:shadow-outline">Edit Profile</button>
                    </div>
                </div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-lg mb-6">
                <nav class="flex space-x-4">
                    <a href="#" class="text-gray-700 hover:text-blue-500">Beranda</a>
                    <a href="#" class="text-gray-700 hover:text-blue-500">Video</a>
                    <a href="#" class="text-gray-700 hover:text-blue-500">Shorts</a>
                    <a href="#" class="text-gray-700 hover:text-blue-500">Playlist</a>
                    <a href="#" class="text-gray-700 hover:text-blue-500">Komunitas</a>
                </nav>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- looping menampilkan vidio yang diupload oleh user -->
                <?php while ($row = $result_user_videos->fetch_assoc()): ?>
                    <div class="bg-white p-4 rounded-lg shadow-lg">
                        <!-- link ke halaman watch dan mengambil id video dari var $row dengan parameter video_id -->
                        <a href="watch.php?id=<?php echo $row['video_id']; ?>">
                            <!-- menampilkan thumbnail dari var $row dengan parameter thumbnail_path -->
                            <img src="../assets/uploads/thumbnails/<?php echo htmlspecialchars($row['thumbnail_path']); ?>" alt="Thumbnail" class="mb-4 w-full h-48 object-cover">
                        </a>
                        <!-- menampilkan judul video dari var $row dengan parameter title -->
                        <a href="watch.php?id=<?php echo $row['video_id']; ?>">
                            <h2 class="text-xl font-bold mb-2"><?php echo htmlspecialchars($row['title']); ?></h2>
                        </a>
                        <div class="flex items-center justify-between text-gray-600">
                            <!-- menampilkan views dan likes dari var $row dengan parameter views dan likes -->
                            <span>Views: <?php echo $row['views']; ?></span>
                            <span>Likes: <?php echo $row['likes']; ?></span>
                        </div>
                        <!-- button untuk mengedit informasi video dengan menampilkan modal berisi judul, deskripsi, dan thumbnail dari var $row -->
                        <button onclick="openEditVideoModal(<?php echo $row['video_id']; ?>, '<?php echo htmlspecialchars($row['title']); ?>', '<?php echo htmlspecialchars($row['description']); ?>', '<?php echo htmlspecialchars($row['thumbnail_path']); ?>')" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 shadow-lg rounded-tl-lg rounded-br-lg focus:outline-none focus:shadow-outline mt-2">Edit Video</button>
                    </div>
                <!-- memberhentikan perulangan -->
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <!-- modal untuk mengedit profile -->
    <div id="editProfileModal" class="modal">
        <div class="modal-content rounded-lg shadow-lg p-6 bg-white">
            <span class="close">&times;</span>
            <h2 class="text-2xl font-bold mb-4">Edit Profile</h2>
            <form id="editProfileForm" action="../user/editProfile.php" method="POST">
                <div class="mb-4">
                    <label for="username" class="block text-gray-700">Username</label>
                    <!-- menampilkan username dari $user -->
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email</label>
                    <!-- menampilkan email dari $user -->
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700">Password</label>
                    <input type="password" id="password" name="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Save</button>
            </form>
        </div>
    </div>

    <!-- modal untuk mengedit video -->
    <div id="editVideosModal" class="modal">
        <div class="modal-content rounded-lg shadow-lg p-6 bg-white">
            <span class="close">&times;</span>
            <h2 class="text-2xl font-bold mb-4">Edit Videos</h2>
            <form id="editVideosForm" action="../videos/editVideos.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="video_id" name="video_id">
                <div class="mb-4">
                    <label for="title" class="block text-gray-700">Title</label>
                    <input type="text" id="title" name="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-gray-700">Description</label>
                    <textarea id="description" name="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                </div>
                <div class="mb-4">
                    <label for="thumbnail" class="block text-gray-700">Thumbnail</label>
                    <input type="file" id="thumbnail" name="thumbnail" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <img id="thumbnail_preview" src="" alt="Thumbnail" class="mt-2 w-32 h-32 object-cover">
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Save</button>
            </form>
            <form id="deleteVideoForm" action="../videos/deleteProcess.php" method="POST" class="mt-4">
                <input type="hidden" id="delete_video_id" name="video_id">
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Delete Video</button>
            </form>
        </div>
    </div>

    <script>
        //mengambil elemen id untuk edit profile dan edit video menggunakan DOM dan disimpan ke variabel
        var profileModal = document.getElementById("editProfileModal");
        var videosModal = document.getElementById("editVideosModal");

        //mengambil elemen id untukk button edit profile menggunakan DOM dan disimpan ke variabel
        var profileBtn = document.getElementById("editProfileBtn");

        //mengambil elemen class untuk close modal menggunakan DOM dan disimpan ke variabel
        var profileSpan = profileModal.getElementsByClassName("close")[0];
        var videosSpan = videosModal.getElementsByClassName("close")[0];

        //ketika user mengklik button edit profile, maka modal akan ditampilkan
        profileBtn.onclick = function() {
            profileModal.style.display = "block";
        }

        //ketika user klik close(x), maka modal akan ditutup
        profileSpan.onclick = function() {
            profileModal.style.display = "none";
        }
        videosSpan.onclick = function() {
            videosModal.style.display = "none";
        }

        //ketika user klik diluar modal, maka modal akan ditutup
        window.onclick = function(event) {
            if (event.target == profileModal) {
                profileModal.style.display = "none";
            }
            if (event.target == videosModal) {
                videosModal.style.display = "none";
            }
        }

        //untuk mengedit video, maka modal akan ditampilkan dengan judul, deskripsi, dan thumbnail dari video yang dipilih
        function openEditVideoModal(videoId, title, description, thumbnailPath) {
            document.getElementById('video_id').value = videoId; //mengambil id video
            document.getElementById('delete_video_id').value = videoId; //mengambil id video
            document.getElementById('title').value = title; //mengambil judul video
            document.getElementById('description').value = description; //mengambil deskripsi video
            document.getElementById('thumbnail_preview').src = "../assets/uploads/thumbnails/" + thumbnailPath; //mengambil thumbnail video
            videosModal.style.display = "block"; //menampilkan modal
        }
    </script>
</body>
</html>

<?php
$stmt->close(); //menutup statment
$stmt_videos->close(); //menutup statment videos
$stmt_user_videos->close(); //menutup statment user videos
$conn->close(); //menutup koneksi database
?>