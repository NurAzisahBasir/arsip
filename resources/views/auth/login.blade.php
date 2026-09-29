<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Pengarsipan Digital</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-blue-50/50 font-sans text-slate-800 antialiased min-h-screen flex flex-col justify-between relative overflow-x-hidden">

    <!-- Ornaments Background Transparan -->
    <div class="absolute -top-20 -left-20 w-60 sm:w-80 h-60 sm:h-80 bg-blue-100 rounded-full blur-3xl opacity-60 pointer-events-none"></div>
    <div class="absolute -bottom-20 -right-20 w-60 sm:w-80 h-60 sm:h-80 bg-blue-100 rounded-full blur-3xl opacity-60 pointer-events-none"></div>

    <!-- Header Logo -->
    <header class="p-4 sm:p-8 relative z-10 max-w-7xl mx-auto w-full">
        <div class="flex items-center space-x-2.5 sm:space-x-3">
            <div class="bg-blue-600 text-white p-2 sm:p-2.5 rounded-xl shadow-md shadow-blue-500/20 flex-shrink-0">
                <i class="fa-solid fa-folder-closed text-base sm:text-lg"></i>
            </div>
            <span class="font-extrabold text-slate-900 text-base sm:text-xl tracking-tight truncate">Sistem Pengarsipan Digital</span>
        </div>
    </header>

    <!-- Main Container Layout Responsif -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 py-2 sm:py-6 w-full flex-grow flex items-center justify-center relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-10 lg:gap-12 items-center w-full">
            
            <!-- SISI KIRI: Branding & Ilustrasi -->
            <div class="lg:col-span-6 space-y-4 sm:space-y-6 text-center lg:text-left">
                <div>
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-blue-950 tracking-tight leading-tight mb-2 sm:mb-3">
                        Selamat Datang
                    </h1>
                    <p class="text-slate-600 text-base sm:text-lg lg:text-xl font-medium">
                        Masuk untuk mengakses sistem pengarsipan digital
                    </p>
                    <p class="text-slate-400 text-xs sm:text-sm lg:text-base mt-1.5 sm:mt-2 max-w-md mx-auto lg:mx-0">
                        Kelola dokumen dengan lebih mudah, cepat, dan aman.
                    </p>
                </div>

                <!-- Ilustrasi Folder Fleksibel -->
                <div class="pt-2 sm:pt-4 flex justify-center lg:justify-start">
                    <div class="relative w-48 sm:w-64 lg:w-80 h-36 sm:h-48 lg:h-60 flex items-center justify-center">
                        <div class="absolute inset-0 bg-blue-100/60 rounded-full blur-xl transform scale-90"></div>
                        
                        <svg class="w-full h-full relative z-10 drop-shadow-xl" viewBox="0 0 300 220" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- Background Leaf Accents -->
                            <path d="M40 180C20 150 30 100 60 90C70 120 60 160 40 180Z" fill="#C7D2FE" opacity="0.5"/>
                            <path d="M260 180C280 150 270 100 240 90C230 120 240 160 260 180Z" fill="#C7D2FE" opacity="0.5"/>
                            
                            <!-- Document Paper -->
                            <rect x="85" y="30" width="130" height="130" rx="12" fill="#E0E7FF" />
                            <rect x="105" y="55" width="90" height="8" rx="4" fill="#A5B4FC" />
                            <rect x="105" y="75" width="70" height="8" rx="4" fill="#C7D2FE" />
                            <rect x="105" y="95" width="80" height="8" rx="4" fill="#C7D2FE" />

                            <!-- Main Blue Folder Front -->
                            <path d="M50 110C50 101.716 56.7157 95 65 95H125L145 110H235C243.284 110 250 116.716 250 125V180C250 188.284 243.284 195 235 195H65C56.7157 195 50 188.284 50 180V110Z" fill="#2563EB" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- SISI KANAN: Card Form Login -->
            <div class="lg:col-span-6 flex justify-center lg:justify-end w-full">
                <div class="bg-white rounded-2xl sm:rounded-3xl p-6 sm:p-8 lg:p-10 shadow-xl shadow-blue-900/5 border border-slate-100 w-full max-w-xs sm:max-w-md">
                    
                    <!-- Icon Folder Atas Card -->
                    <div class="flex justify-center mb-3 sm:mb-4">
                        <div class="bg-blue-50 p-3 sm:p-4 rounded-xl sm:rounded-2xl text-blue-600 border border-blue-100">
                            <i class="fa-solid fa-folder-closed text-2xl sm:text-3xl"></i>
                        </div>
                    </div>

                    <div class="text-center mb-6 sm:mb-8">
                        <h2 class="text-xl sm:text-2xl font-bold text-slate-900">Login</h2>
                        <p class="text-slate-400 text-xs sm:text-sm mt-1">
                            Masukkan email dan password anda untuk melanjutkan
                        </p>
                    </div>

                    <!-- Session Status Notification -->
                    <x-auth-session-status class="mb-4 text-xs sm:text-sm" :status="session('status')" />

                    <!-- Form Login -->
                    <form method="POST" action="{{ route('login') }}" class="space-y-3.5 sm:space-y-4">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-regular fa-envelope text-xs sm:text-sm"></i>
                                </div>
                                <input 
                                    id="email" 
                                    type="email" 
                                    name="email" 
                                    value="{{ old('email') }}" 
                                    required 
                                    autofocus 
                                    autocomplete="username"
                                    placeholder="Email" 
                                    class="w-full pl-9 sm:pl-10 pr-3.5 sm:pr-4 py-2.5 sm:py-3 bg-white border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition duration-200"
                                >
                            </div>
                            <span class="text-[10px] sm:text-xs text-slate-400 block mt-1 pl-1">contoh: nama@domain.com</span>
                            <x-input-error :messages="$errors->get('email')" class="mt-1" />
                        </div>

                        <!-- Password -->
                        <div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-lock text-xs sm:text-sm"></i>
                                </div>
                                <input 
                                    id="password" 
                                    type="password" 
                                    name="password" 
                                    required 
                                    autocomplete="current-password"
                                    placeholder="Password" 
                                    class="w-full pl-9 sm:pl-10 pr-9 sm:pr-10 py-2.5 sm:py-3 bg-white border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition duration-200"
                                >
                                <!-- Toggle Intip Password -->
                                <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                                    <i id="eyeIcon" class="fa-regular fa-eye-slash text-xs sm:text-sm"></i>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />
                        </div>

                        <!-- Checkbox Remember Me (Hidden/Default checked) -->
                        <div class="hidden">
                            <input id="remember_me" type="checkbox" name="remember" checked>
                        </div>

                        <!-- Button Submit -->
                        <button 
                            type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 sm:py-3 px-4 rounded-xl shadow-lg shadow-blue-600/30 hover:shadow-blue-700/40 transition duration-200 flex items-center justify-center space-x-2 text-xs sm:text-sm mt-2"
                        >
                            <span>Login</span>
                            <i class="fa-solid fa-arrow-right text-[10px] sm:text-xs"></i>
                        </button>

                        <!-- Lupa Password Link -->
                        <div class="text-center pt-2 sm:pt-4">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition">
                                    Lupa password?
                                </a>
                            @endif
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer Spacer -->
    <footer class="py-2 sm:py-4"></footer>

    <!-- JS Intip Password -->
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            }
        }
    </script>

</body>
</html>