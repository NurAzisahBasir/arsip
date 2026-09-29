<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelurahan {{ $kecamatan->name }} - Sistem Pengarsipan Digital</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="min-h-screen bg-slate-50 font-sans text-slate-800 antialiased">
    <x-app-header />

    <main class="mx-auto w-full max-w-6xl px-4 py-6 sm:px-6 sm:py-9">
        <a href="{{ route('dashboard') }}" class="mb-5 inline-flex items-center gap-2 rounded-md border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-700 transition hover:border-blue-300 hover:text-blue-800">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            <span>Kembali ke Kecamatan</span>
        </a>

        <nav aria-label="Breadcrumb" class="mb-4 flex flex-wrap items-center gap-2 text-sm text-slate-500">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-800">Kecamatan</a>
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
            <span class="font-medium text-slate-700">{{ $kecamatan->name }}</span>
        </nav>

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-900 sm:text-3xl">Kelurahan</h1>
            <p class="mt-1 text-sm text-slate-500 sm:text-base">Pilih Kelurahan untuk melihat lokasi penyimpanan arsip</p>
        </div>

        <form id="kelurahanSearchForm" class="mb-7 flex items-center gap-2 rounded-lg border border-slate-200 bg-white p-1.5 shadow-sm" role="search">
            <label for="kelurahanSearch" class="sr-only">Cari Kelurahan</label>
            <i class="fa-solid fa-magnifying-glass ml-3 text-slate-400"></i>
            <input id="kelurahanSearch" type="search" placeholder="Cari Kelurahan..." autocomplete="off" class="min-w-0 flex-1 border-0 bg-transparent px-2 py-2 text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-0">
            <button type="submit" aria-label="Cari" class="flex h-10 w-11 shrink-0 items-center justify-center rounded-md bg-blue-800 text-white transition hover:bg-blue-900">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>

        <section aria-labelledby="kelurahan-list-heading">
            <div class="mb-4 flex items-center justify-between gap-3">
                <h2 id="kelurahan-list-heading" class="text-lg font-bold text-slate-800">Daftar Kelurahan</h2>
                <span class="text-sm text-slate-500">{{ $kelurahans->count() }} kelurahan</span>
            </div>

            <div id="kelurahanGrid" class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @forelse ($kelurahans as $kelurahan)
                    <article data-kelurahan-card data-search="{{ strtolower($kelurahan['name'].' '.$kelurahan['code']) }}" class="flex min-h-48 flex-col rounded-lg border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                        <div class="mb-3 flex h-11 w-11 items-center justify-center rounded-full bg-blue-50 text-blue-700">
                            <i class="fa-solid fa-folder text-lg"></i>
                        </div>
                        <h3 class="break-words text-sm font-bold text-slate-800 sm:text-base">Kel. {{ $kelurahan['name'] }}</h3>
                        @if ($kelurahan['code'])
                            <p class="mt-1 text-xs text-slate-400">Kode {{ $kelurahan['code'] }}</p>
                        @endif
                        <p class="mt-1 text-sm text-slate-500">{{ $kelurahan['archive_count'] }} Arsip</p>
                        <a href="{{ $kelurahan['href'] }}" class="mt-auto flex items-center justify-center gap-2 rounded-md bg-blue-800 px-3 py-2.5 text-xs font-semibold text-white transition hover:bg-blue-900 sm:text-sm">
                            <span>Lihat Arsip</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </article>
                @empty
                    <p class="col-span-full rounded-lg border border-dashed border-slate-300 bg-white px-4 py-10 text-center text-sm text-slate-500">Belum ada kelurahan pada kecamatan ini.</p>
                @endforelse
            </div>
            <p id="kelurahanNoResults" class="hidden rounded-lg border border-dashed border-slate-300 bg-white px-4 py-10 text-center text-sm text-slate-500">Kelurahan tidak ditemukan.</p>
        </section>
    </main>

    <script>
        const searchForm = document.getElementById('kelurahanSearchForm');
        const searchInput = document.getElementById('kelurahanSearch');
        const kelurahanCards = Array.from(document.querySelectorAll('[data-kelurahan-card]'));
        const noResults = document.getElementById('kelurahanNoResults');

        function filterKelurahans() {
            const query = searchInput.value.trim().toLocaleLowerCase('id');
            let visibleCount = 0;

            kelurahanCards.forEach((card) => {
                const matches = card.dataset.search.toLocaleLowerCase('id').includes(query);
                card.classList.toggle('hidden', !matches);
                visibleCount += matches ? 1 : 0;
            });

            noResults.classList.toggle('hidden', visibleCount > 0 || query === '');
        }

        searchInput.addEventListener('input', filterKelurahans);
        searchForm.addEventListener('submit', (event) => {
            event.preventDefault();
            filterKelurahans();
        });
    </script>
</body>
</html>