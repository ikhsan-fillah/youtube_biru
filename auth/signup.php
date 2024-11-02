<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6">Sign Up</h2>
        <form action="signupProcess.php" method="post">
            <div class="mb-4">
                <input type="text" name="username" placeholder="Username" required class="w-full p-3 border border-gray-300 rounded-lg">
            </div>
            <div class="mb-4">
                <input type="email" name="email" placeholder="Email" required class="w-full p-3 border border-gray-300 rounded-lg">
            </div>
            <div class="mb-6">
                <input type="password" name="password" placeholder="Password" required class="w-full p-3 border border-gray-300 rounded-lg">
                <label for="password" class="text-sm text-gray-400">minimal password length 8 dan harus terdapat angka</label>
            </div>
            <div>
                <input type="submit" value="Sign Up" class="w-full p-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 cursor-pointer">
            </div>
        </form>
    </div>
</body>
</html>
