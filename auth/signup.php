<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://horizon-ui.com/shadcn-nextjs-boilerplate/_next/static/css/32144b924e2aa5af.css" />
</head>

<body class="flex items-center justify-center h-screen ">
    <div class="flex flex-col justify-center w-full items-center  h-[100vh]">
        <div class="mx-auto flex w-full flex-col justify-center px-5 pt-0 md:h-[unset] md:max-w-[50%] lg:h-[100vh] min-h-[100vh] lg:max-w-[50%] lg:px-6">
            <a class="mt-6 w-fit text-zinc-950 dark:text-white" href="../index.php">
                <div class="flex w-fit items-center lg:pl-0 lg:pt-0 xl:pt-0">
                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 320 512" class="mr-3 h-[13px] w-[8px] text-zinc-950 dark:text-white" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 246.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z"></path>
                    </svg>
                    <p class="ml-0 text-sm text-zinc-950 dark:text-white">Back to the homepage</p>
                </div>
            </a>
            <div class="bg-blue-500 rounded-lg mb-auto p-8 my-auto flex flex-col md:mt-[70px] w-[350px] max-w-[450px] mx-auto md:max-w-[450px] lg:mt-[110px] lg:max-w-[450px]">
                <p class="text-[32px] font-bold text-zinc-950 dark:text-white">Sign Up</p>
                <p class="mb-2.5 mt-2.5 font-normal text-zinc-950 dark:text-zinc-400">Enter your details to create an account!</p>
                <div class="mt-3">
                    <form action="signupProcess.php" method="POST" class="pb-2">
                        <div class="grid gap-2">
                            <div class="grid gap-1">
                                <label class="text-zinc-950 dark:text-white" for="username">Username</label>
                                <input class="mr-2.5 mb-2 h-full min-h-[44px] w-full rounded-lg border border-zinc-200 bg-white px-4 py-3 text-sm font-medium text-zinc-950 placeholder:text-zinc-400 focus:outline-0 dark:border-zinc-800 dark:bg-transparent dark:text-white dark:placeholder:text-zinc-400" id="username" placeholder="Username" type="text" name="username" required>
                                <label class="text-zinc-950 dark:text-white mt-2" for="email">Email</label>
                                <input class="mr-2.5 mb-2 h-full min-h-[44px] w-full rounded-lg border border-zinc-200 bg-white px-4 py-3 text-sm font-medium text-zinc-950 placeholder:text-zinc-400 focus:outline-0 dark:border-zinc-800 dark:bg-transparent dark:text-white dark:placeholder:text-zinc-400" id="email" placeholder="name@example.com" type="email" name="email" required>
                                <label class="text-zinc-950 mt-2 dark:text-white" for="password">Password</label>
                                <input id="password" placeholder="Password" type="password" autocomplete="new-password" class="mr-2.5 mb-2 h-full min-h-[44px] w-full rounded-lg border border-zinc-200 bg-white px-4 py-3 text-sm font-medium text-zinc-950 placeholder:text-zinc-400 focus:outline-0 dark:border-zinc-800 dark:bg-transparent dark:text-white dark:placeholder:text-zinc-400" name="password" required>
                                <label for="password" class="text-sm text-zinc-750 dark:text-zinc-400">Minimal panjang password 8 huruf dan harus terdapat angka</label>
                            </div>
                            <button class="whitespace-nowrap ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 mt-2 flex h-[unset] w-full items-center justify-center rounded-lg px-4 py-4 text-sm font-medium" type="submit">Sign Up</button>
                        </div>
                    </form>
                    <p><a href="login.php" class="font-medium text-zinc-950 dark:text-white text-sm">Already have an account? Sign in</a></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
