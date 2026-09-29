<header class="sticky top-0 z-50 border-b border-slate-200 bg-white px-3 py-2 shadow-sm sm:px-8 sm:py-3">
    <div class="mx-auto flex max-w-6xl items-center justify-between gap-2 sm:gap-4">
        <a href="{{ route('dashboard') }}" class="flex min-w-0 items-center gap-2 sm:gap-3">
            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-blue-700 text-white sm:h-9 sm:w-9">
                <i class="fa-solid fa-folder-closed"></i>
            </span>
            <span class="truncate text-xs font-bold text-slate-800 sm:text-base">Sistem Pengarsipan Digital</span>
        </a>

        <div class="relative shrink-0">
            <button id="userMenuBtn" type="button" aria-label="Menu akun {{ Auth::user()->name ?? 'Admin' }}" aria-expanded="false" aria-controls="userDropdown" class="flex items-center gap-1.5 rounded-lg border border-slate-200 bg-slate-50 p-1.5 transition hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500 sm:gap-2 sm:p-2">
                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-slate-200 text-slate-600">
                    <i class="fa-solid fa-user text-xs"></i>
                </span>
                <span class="hidden max-w-40 truncate text-sm font-medium text-slate-700 sm:inline">{{ Auth::user()->name ?? 'Admin' }}</span>
                <i class="fa-solid fa-chevron-down text-[10px] text-slate-500"></i>
            </button>

            <div id="userDropdown" class="absolute right-0 z-50 mt-2 hidden w-56 overflow-hidden rounded-lg border border-slate-200 bg-white py-1 shadow-lg">
                <div class="border-b border-slate-100 px-4 py-3">
                    <p class="text-xs text-slate-400">Login sebagai</p>
                    <p class="truncate text-sm font-semibold text-slate-800">{{ Auth::user()->email ?? 'admin@dukcapil.go.id' }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-2 px-4 py-2.5 text-left text-sm text-red-600 transition hover:bg-red-50">
                        <i class="fa-solid fa-right-from-bracket text-xs"></i>
                        <span>Keluar (Logout)</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

<script>
    (() => {
        const button = document.getElementById('userMenuBtn');
        const dropdown = document.getElementById('userDropdown');

        if (!button || !dropdown) return;

        const closeMenu = () => {
            dropdown.classList.add('hidden');
            button.setAttribute('aria-expanded', 'false');
        };

        button.addEventListener('click', () => {
            const isOpen = button.getAttribute('aria-expanded') === 'true';
            button.setAttribute('aria-expanded', String(!isOpen));
            dropdown.classList.toggle('hidden', isOpen);
        });

        document.addEventListener('click', (event) => {
            if (!button.contains(event.target) && !dropdown.contains(event.target)) closeMenu();
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') closeMenu();
        });
    })();
</script>