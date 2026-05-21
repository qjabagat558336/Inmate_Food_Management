<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-gray-900 text-white p-6 space-y-6">

        <h1 class="text-xl font-bold">🍽 Admin Panel</h1>

        <nav class="space-y-3 text-sm">
            <a href="/dashboard" class="block hover:text-indigo-400">Dashboard</a>
            <a href="/meals" class="block hover:text-indigo-400">Meals</a>
        </nav>

    </aside>

    <!-- MAIN -->
    <main class="flex-1 p-8">
        {{ $slot }}
    </main>

</div>

</body>
</html>