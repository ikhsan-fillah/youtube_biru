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