<?php
session_start();

// Periksa apakah pengguna sudah login
$isLoggedIn = isset($_SESSION['username']);
$username = $isLoggedIn ? $_SESSION['username'] : '';

// Jika pengguna belum login, arahkan ke halaman login
if (!$isLoggedIn) {
    header("Location: ../auth/login.php");
    exit();
}
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
    <link href="https://fonts.googleapis.com/css2?family=Jersey+10&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=Prompt:wght@500&family=Source+Code+Pro:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
    <style>
        *{
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body>
    <nav class="bg-ytBlue h-16 py-4 px-6 flex justify-between items-center"> 
        <div class="flex items-center ml-10"> 
            <a href="index.php">
                <img src="../assets/img/youtube.png" alt="Logo Youtube" class="h-14 mr-6" />
            </a>
        </div>
        <div class="flex items-center">
            <div class="relative">
                <input type="text" placeholder="Search" class="font-poppins bg-gray-100 text-gray-800 rounded-full w-96 py-2 px-4 -mr-6 focus:outline-none focus:ring-2 focus:ring-red-500" />
                <button class="bg-red-500 text-white rounded-full py-2 px-4 -ml-6 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500"><i class="fa-solid fa-magnifying-glass"></i></button>
                <button class="bg-red-500 text-white rounded-full py-2 px-4 ml-3 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500"><i class="fa-solid fa-microphone"></i></button>
            </div>
        </div>
        <div>
            <div class="flex items-center mr-9">
                <button type="button" class="text-white focus:outline-none bg-red-500 rounded-full py-2 px-4 mr-4 hover:bg-red-600 focus:ring-2 focus:ring-red-500"><i class="fa-solid fa-video"></i></button>
                <span class="text-white mr-4"><?php echo htmlspecialchars($username); ?></span>
                <a href="../auth/logout.php"><button type="button" class="text-white focus:outline-none bg-red-500 rounded-full py-2 px-4 hover:bg-red-600 focus:ring-2 focus:ring-red-500">Logout</button></a>
            </div>
        </div>
    </nav>
    <div class="flex h-screen"> <!-- Side Bar -->
        <div class="bg-ytBlue text-white w-72 p-6 overflow-y-scroll scrollbar-thin scrollbar-thumb-red-500 scrollbar-track-blue-600">
            <div class="mb-5 mt-1">
                <a href="#" class="flex items-center">
                    <i class="fas fa-home mr-2 text-2xl ml-3"></i>
                    <span class="font-bold text-lg ml-3">Beranda</span>
                </a>
            </div>
            <div class="mb-5">
                <a href="#" class="flex items-center">
                    <i class="fas fa-play-circle mr-2 text-2xl ml-3"></i>
                    <span class="font-bold text-lg ml-3">Shorts</span>
                </a>
            </div>
            <div class="mb-5">
                <a href="#" class="flex items-center">
                    <i class="fas fa-tv mr-2 text-2xl ml-3"></i>
                    <span class="font-bold text-lg ml-3">Subscription</span>
                </a>
            </div>
            <div class="w-full h-px bg-red-500 mt-6 mb-5"></div>
            <div class="font-bold text-xl mb-5">Anda ></div>
            <div class="mb-5">
                <a href="#" class="flex items-center">
                    <i class="fa-solid fa-clock-rotate-left mr-2 text-2xl ml-3"></i>
                    <span class="font-bold text-lg ml-3">Histori</span>
                </a>
            </div>
            <div class="mb-5">
                <a href="#" class="flex items-center">
                    <i class="fas fa-list mr-2 text-2xl ml-3"></i>
                    <span class="font-bold text-lg ml-3">Playlist</span>
                </a>
            </div>
            <div class="mb-5">
                <a href="#" class="flex items-center">
                    <i class="fas fa-video mr-2 text-2xl ml-3"></i>
                    <span class="font-bold text-lg ml-3">Video Anda</span>
                </a>
            </div>
            <div class="mb-5">
                <a href="#" class="flex items-center">
                    <i class="fa-regular fa-clock mr-2 text-2xl ml-3"></i>
                    <span class="font-bold text-lg ml-3">Tonton Nanti</span>
                </a>
            </div>
            <div class="mb-5">
                <a href="#" class="flex items-center">
                    <i class="fas fa-thumbs-up mr-2 text-2xl ml-3"></i>
                    <span class="font-bold text-lg ml-1">Video yang disukai</span>
                </a>
            </div>
            <div class="mb-5">
                <a href="#" class="flex items-center">
                    <i class="fa-duotone fa-solid fa-scissors mr-2 text-2xl ml-3"></i>
                    <span class="font-bold text-lg ml-3">Klip Anda</span>
                </a>
            </div>
            <div class="w-full h-px bg-red-500 mt-6 mb-5"></div>
            <div class="font-bold text-xl mb-5">Eksplorasi</div>
            <div class="mb-5">
                <a href="#" class="flex items-center">
                    <i class="fa-solid fa-regular fa-fire mr-2 text-2xl ml-3"></i>
                    <span class="font-bold text-lg ml-6">Trending</span>
                </a>
            </div>
            <div class="mb-5">
                <a href="#" class="flex items-center">
                    <i class="fa-solid fa-music mr-2 text-2xl ml-3"></i>
                    <span class="font-bold text-lg ml-5">Musik</span>
                </a>
            </div>
            <div class="mb-5">
                <a href="#" class="flex items-center">
                    <i class="fa-solid fa-clapperboard mr-2 text-2xl ml-3"></i>
                    <span class="font-bold text-lg ml-5">Film</span>
                </a>
            </div>
            <div class="mb-5">
                <a href="#" class="flex items-center">
                    <i class="fa-solid fa-gamepad mr-2 text-2xl ml-3"></i>
                    <span class="font-bold text-lg ml-3">Game</span>
                </a>
            </div>
            <div class="mb-5">
                <a href="#" class="flex items-center">
                    <i class="fa-solid fa-trophy mr-2 text-2xl ml-3"></i>
                    <span class="font-bold text-lg ml-4">Olahraga</span>
                </a>
            </div>
            <div class="w-full h-px bg-red-500 mt-6 mb-5"></div>
            <div class="mb-5">
                <a href="#" class="flex items-center">
                    <i class="fa-solid fa-gear mr-2 text-2xl ml-3"></i>
                    <span class="font-bold text-lg ml-3">Setelan</span>
                </a>
            </div>
            <div class="mb-5">
                <a href="#" class="flex items-center">
                    <i class="fa-regular fa-flag mr-2 text-2xl ml-3"></i>
                    <span class="font-bold text-lg ml-3">Histori Laporan</span>
                </a>
            </div>
            <div class="mb-5">
                <a href="#" class="flex items-center">
                    <i class="fa-regular fa-circle-question mr-2 text-2xl ml-3"></i>
                    <span class="font-bold text-lg ml-3">Bantuan</span>
                </a>
            </div>
            <div class="mb-5">
                <a href="#" class="flex items-center">
                    <i class="fa-solid fa-circle-info mr-2 text-2xl ml-3"></i>
                    <span class="font-bold text-lg ml-3">Kirim Masukan</span>
                </a>
            </div>
            <div class="w-full h-px bg-red-500 mt-6 mb-5"></div>
            <div class="mb-5">
                <a href="https://www.youtube.com/howyoutubeworks/policies/copyright/" class=""><p class="">Tentang Pers Hak Cipta</p></a>
                <a href="https://www.youtube.com/t/contact_us/" class=""><p class="">Hubungi Kami Kreator</p></a>
                <a href="https://developers.google.com/youtube?hl=id" class=""><p class="">Beriklan Developer</p></a>
                <br>
                <a href="https://policies.google.com/privacy?hl=id" class=""><p class="">Persyaratan Privasi</p></a>
                <a href="https://www.youtube.com/howyoutubeworks/policies/community-guidelines/" class=""><p class="">Kebijakan & Keamanan</p></a>
                <a href="https://www.youtube.com/howyoutubeworks/?utm_campaign=ytgen&utm_source=ythp&utm_medium=LeftNav&utm_content=txt&u=https%3A%2F%2Fwww.youtube.com%2Fhowyoutubeworks%3Futm_source%3Dythp%26utm_medium%3DLeftNav%26utm_campaign%3Dytgen" class=""><p class="">Cara Kerja YouBlue</p></a>
                <a href="https://www.youtube.com/new" class=""><p class="">Uji Fitur baru</p></a>
                <br>
                <p class="text-gray-400"><i class="fa-regular fa-copyright"></i>    2024 Google LLC</p>
                <br>
            </div>
        </div>
        <!-- Main Content -->
        <div class="flex-1 p-6">
            <h1 class="text-2xl font-bold mb-4">Welcome to YouBlue!</h1>
            <p>This is where your main content will go.</p>
        </div>
    </div>
</body>
</html>