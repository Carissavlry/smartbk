<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru BK — SmartBK</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans">

    <!-- Navbar -->
    <nav class="bg-blue-800 text-white px-6 py-4 flex justify-between items-center shadow">
        <h1 class="text-xl font-bold">SmartBK</h1>
        <div class="flex items-center gap-4">
            <span class="text-sm">{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-sm px-3 py-1 rounded">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <!-- Konten -->
    <div class="max-w-6xl mx-auto mt-10 px-4">
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-2xl font-bold text-blue-800 mb-1">Dashboard Guru BK</h2>
            <p class="text-gray-500 mb-6">Selamat datang, {{ Auth::user()->name }}. Pantau dan kelola konseling siswa di sini.</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <p class="text-sm text-blue-600 font-medium">Total Sesi Konseling</p>
                    <p class="text-3xl font-bold text-blue-800">0</p>
                </div>
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <p class="text-sm text-red-600 font-medium">Siswa Pelanggaran Kritis</p>
                    <p class="text-3xl font-bold text-red-800">0</p>
                </div>
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <p class="text-sm text-green-600 font-medium">Konseling Selesai Bulan Ini</p>
                    <p class="text-3xl font-bold text-green-800">0</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>