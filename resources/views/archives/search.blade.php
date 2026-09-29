<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pencarian - Sistem Pengarsipan Digital</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="min-h-screen bg-slate-50 font-sans text-slate-800 antialiased">
    <x-app-header />

    <main class="mx-auto w-full max-w-4xl px-4 py-6 sm:px-6 sm:py-9">
        <a href="{{ route('dashboard') }}" class="mb-5 inline-flex items-center gap-2 text-sm font-medium text-slate-600 transition hover:text-blue-800">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            <span>Kembali ke Kecamatan</span>
        </a>

        <h1 class="mb-1 text-2xl font-bold text-slate-900 sm:text-3xl">Hasil Pencarian</h1>
        @if ($query !== '')
            <p class="mb-6 text-sm text-slate-500">{{ $results->count() }} hasil untuk “{{ $query }}”</p>
        @else
            <p class="mb-6 text-sm text-slate-500">Masukkan nama kecamatan, kelurahan, kode boks, atau informasi arsip.</p>
        @endif

        @if ($query !== '' && $results->isEmpty())
            <div class="rounded-lg border border-dashed border-slate-300 bg-white px-4 py-10 text-center text-sm text-slate-500">
                Tidak ada data yang cocok dengan pencarian tersebut.
            </div>
        @elseif ($results->isNotEmpty())
            <section aria-label="Hasil pencarian" class="divide-y divide-slate-100 rounded-lg border border-slate-200 bg-white">
                @foreach ($results as $result)
                    <a href="{{ $result['href'] }}" class="flex items-start gap-4 px-4 py-4 transition hover:bg-slate-50 sm:px-5">
                        <span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-blue-50 text-blue-700">
                            <i class="fa-solid {{ $result['type'] === 'Arsip' ? 'fa-file-lines' : ($result['type'] === 'Boks' ? 'fa-box-archive' : 'fa-folder') }}"></i>
                        </span>
                        <span class="min-w-0 flex-1">
                            <span class="mb-1 block text-xs font-semibold uppercase text-blue-800">{{ $result['type'] }}</span>
                            <span class="block break-words font-semibold text-slate-800">{{ $result['label'] }}</span>
                            <span class="mt-1 block break-words text-sm text-slate-500">{{ $result['details'] }}</span>
                        </span>
                        <i class="fa-solid fa-chevron-right mt-3 shrink-0 text-xs text-slate-400"></i>
                    </a>
                @endforeach
            </section>
            @if ($results->count() >= 100)
                <p class="mt-3 text-xs text-slate-500">Hasil dibatasi hingga 20 data per kategori. Persempit kata kunci untuk hasil yang lebih spesifik.</p>
            @endif
        @endif
    </main>
</body>
</html>