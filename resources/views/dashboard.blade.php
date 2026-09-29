<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pengarsipan Digital</title>
    @vite('resources/css/app.css')
    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-50 font-sans text-slate-800 antialiased min-h-screen flex flex-col">

    <!-- Header / Navbar Responsif -->
    <header class="bg-white border-b border-slate-200 px-4 sm:px-8 py-4 flex justify-between items-center shadow-sm sticky top-0 z-50">
        <div class="flex items-center space-x-3">
            <div class="bg-blue-600 text-white p-2 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-folder-closed text-base sm:text-lg"></i>
            </div>
            <span class="font-bold text-slate-800 text-base sm:text-lg truncate">Sistem Pengarsipan Digital</span>
        </div>
        
        <!-- User Menu -->
        <div class="flex items-center space-x-2 cursor-pointer bg-slate-50 hover:bg-slate-100 p-1.5 sm:p-2 rounded-xl border border-slate-100 transition">
            <div class="bg-slate-200 p-1.5 rounded-full text-slate-600 flex items-center justify-center">
                <i class="fa-solid fa-user text-xs sm:text-sm"></i>
            </div>
            <span class="text-xs sm:text-sm font-medium text-slate-700">Admin</span>
            <i class="fa-solid fa-chevron-down text-xs text-slate-500"></i>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="max-w-6xl mx-auto px-4 sm:px-6 py-6 sm:py-10 w-full flex-grow">
        
        <!-- Hero Section -->
        <div class="flex justify-between items-center mb-6 sm:mb-8">
            <div>
                <h1 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Selamat Datang</h1>
                <p class="text-slate-500 mt-1 sm:mt-2 text-sm sm:text-lg">Pilih Kecamatan untuk mengakses arsip</p>
            </div>
            <!-- Illustration Icon (Sembunyi di HP kecil) -->
            <div class="hidden sm:block text-blue-500 opacity-90">
                <svg width="100" height="75" viewBox="0 0 120 90" fill="none" xmlns="http://www.w3.org/2000/svg" class="sm:w-24 sm:h-20 lg:w-30 lg:h-24">
                    <rect x="10" y="20" width="100" height="65" rx="8" fill="#2563EB" />
                    <path d="M10 28C10 23.5817 13.5817 20 18 20H45L55 30H102C106.418 30 110 33.5817 110 38V80C110 84.4183 106.418 88 102 88H18C13.5817 88 10 84.4183 10 80V28Z" fill="#3B82F6" />
                    <rect x="30" y="10" width="60" height="30" rx="4" fill="#E2E8F0" opacity="0.8"/>
                </svg>
            </div>
        </div>

        <!-- Global Search Bar Responsif -->
        <div class="bg-white p-2 rounded-2xl shadow-sm border border-slate-200 flex flex-col sm:flex-row items-center gap-2 mb-3">
            <div class="flex items-center w-full pl-2 sm:pl-4">
                <i class="fa-solid fa-magnifying-glass text-blue-600 text-base sm:text-lg mr-2"></i>
                <input 
                    type="text" 
                    placeholder="Cari Kecamatan, Kelurahan, NIK, No. KK, atau Nama..." 
                    class="w-full py-2.5 sm:py-3 px-1 text-slate-700 placeholder-slate-400 focus:outline-none text-sm sm:text-base"
                >
            </div>
            <button class="w-full sm:w-auto bg-blue-800 hover:bg-blue-900 text-white font-semibold px-6 sm:px-8 py-2.5 sm:py-3 rounded-xl transition duration-200 text-sm sm:text-base whitespace-nowrap">
                Cari
            </button>
        </div>

        <!-- Search Hint -->
        <div class="flex items-start sm:items-center space-x-2 text-slate-500 text-xs sm:text-sm mb-8 sm:mb-10 pl-1">
            <i class="fa-regular fa-lightbulb text-amber-500 mt-0.5 sm:mt-0"></i>
            <span>Contoh pencarian: <strong class="text-slate-600">Ahmad</strong> $\rightarrow$ akan menemukan Ahmad, Kel. Bonto-Bontoa, Boks-001, KK</span>
        </div>

        <!-- Section List Kecamatan -->
        <h2 class="text-lg sm:text-xl font-bold text-slate-800 mb-4 sm:mb-6">Daftar Kecamatan</h2>

        <!-- Grid Responsif: 1 Kolom (HP), 2 Kolom (Tablet), 4 Kolom (Desktop) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            
            <!-- Card 1 -->
            <div class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200 shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between">
                <div>
                    <div class="bg-blue-100 text-blue-600 w-10 h-10 sm:w-12 sm:h-12 rounded-xl flex items-center justify-center mb-4">
                        <i class="fa-solid fa-folder text-lg sm:text-xl"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base sm:text-lg">Kec. Bacukiki</h3>
                    <p class="text-slate-400 text-xs sm:text-sm mt-1 mb-6">1.245 Arsip</p>
                </div>
                <a href="#" class="bg-blue-800 hover:bg-blue-900 text-white font-medium py-2.5 px-4 rounded-xl flex items-center justify-center space-x-2 transition duration-200 text-xs sm:text-sm">
                    <span>Lihat Arsip</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>

            <!-- Card 2 -->
            <div class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200 shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between">
                <div>
                    <div class="bg-blue-100 text-blue-600 w-10 h-10 sm:w-12 sm:h-12 rounded-xl flex items-center justify-center mb-4">
                        <i class="fa-solid fa-folder text-lg sm:text-xl"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base sm:text-lg">Kec. Soreang</h3>
                    <p class="text-slate-400 text-xs sm:text-sm mt-1 mb-6">856 Arsip</p>
                </div>
                <a href="#" class="bg-blue-800 hover:bg-blue-900 text-white font-medium py-2.5 px-4 rounded-xl flex items-center justify-center space-x-2 transition duration-200 text-xs sm:text-sm">
                    <span>Lihat Arsip</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>

            <!-- Card 3 -->
            <div class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200 shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between">
                <div>
                    <div class="bg-blue-100 text-blue-600 w-10 h-10 sm:w-12 sm:h-12 rounded-xl flex items-center justify-center mb-4">
                        <i class="fa-solid fa-folder text-lg sm:text-xl"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base sm:text-lg">Kec. Ujung</h3>
                    <p class="text-slate-400 text-xs sm:text-sm mt-1 mb-6">932 Arsip</p>
                </div>
                <a href="#" class="bg-blue-800 hover:bg-blue-900 text-white font-medium py-2.5 px-4 rounded-xl flex items-center justify-center space-x-2 transition duration-200 text-xs sm:text-sm">
                    <span>Lihat Arsip</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>

            <!-- Card 4 -->
            <div class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200 shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between">
                <div>
                    <div class="bg-blue-100 text-blue-600 w-10 h-10 sm:w-12 sm:h-12 rounded-xl flex items-center justify-center mb-4">
                        <i class="fa-solid fa-folder text-lg sm:text-xl"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base sm:text-lg">Kec. Bacukiki Barat</h3>
                    <p class="text-slate-400 text-xs sm:text-sm mt-1 mb-6">721 Arsip</p>
                </div>
                <a href="#" class="bg-blue-800 hover:bg-blue-900 text-white font-medium py-2.5 px-4 rounded-xl flex items-center justify-center space-x-2 transition duration-200 text-xs sm:text-sm">
                    <span>Lihat Arsip</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>

        </div>

    </main>

</body>
</html>