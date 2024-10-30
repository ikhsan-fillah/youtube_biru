<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jersey+10&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Prompt:wght@500&family=Source+Code+Pro:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
    <style>
        *{
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body>
    <nav class="bg-ytBlue h-16 py-4 px-6 flex justify-between items-center">
        <div class="flex items-center ml-10"> <!-- Menggunakan ml-auto untuk mendorong ke kanan -->
            <a href="index.php">
                <img src="assets/img/youtube.png" alt="Logo Youtube" class="h-14 mr-6" />
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
                <button type="button" class="text-white focus:outline-none bg-red-500 rounded-full py-2 px-4 mr-4 hover:bg-red-600 focus:ring-2 focus:ring-red-500">Sign In</button>
                <button type="button" class="text-white focus:outline-none bg-red-500 rounded-full py-2 px-4 hover:bg-red-600 focus:ring-2 focus:ring-red-500">Sign Up</button>
            </div>
        </div>
    </nav>
</body>
</html>