<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouBlue</title>
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
    <?php include 'includes/navbarBeforeLgn.php'; ?>
    <div class="flex h-screen"> <!-- Side Bar -->
        <?php include 'includes/sidebar.php'; ?>
        <!-- Main Content -->
        <div class="flex-1 p-8 text-center">
            <div class="bg-blue-300 mx-96 p-8 rounded-lg">
                <h1 class="text-3xl font-bold mb-4">Welcome to YouBlue!</h1>
                <p class="text-lg font-bold ">Coba telusuri untuk memulai</p>
                <p>Mulailah menonton video untuk membantu kami membuat feed berisi</p>
                <p>video yang Anda sukai.</p>
            </div>
        </div>
    </div>
</body>
</html>