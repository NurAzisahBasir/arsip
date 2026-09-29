<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - Sistem Pengarsipan Digital</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-50 font-sans text-slate-800 antialiased min-h-screen flex flex-col">
    <x-app-header />

    <main class="max-w-6xl mx-auto px-4 sm:px-6 py-6 sm:py-10 w-full flex-grow">
        <nav aria-label="Breadcrumb" class="text-sm text-slate-500 mb-6 flex flex-wrap items-center gap-2">
            @foreach ($breadcrumbs as $breadcrumb)
                <a href="{{ $breadcrumb['href'] }}" class="hover:text-blue-800">{{ $breadcrumb['label'] }}</a>
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
            @endforeach
            <span class="text-slate-700 font-medium">{{ $context }}</span>
        </nav>

        <div class="flex flex-wrap justify-between items-end gap-3 mb-6">
            <div>
                <p class="text-sm text-slate-500 mb-1">{{ $context }}</p>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">{{ $title }}</h1>
            </div>
            <span class="text-sm text-slate-500">{{ count($items) }} data</span>
        </div>

        <section class="bg-white border border-slate-200 rounded-lg divide-y divide-slate-100">
            @forelse ($items as $item)
                @if ($item['href'])
                    <a href="{{ $item['href'] }}" class="flex items-center justify-between gap-4 px-4 sm:px-6 py-4 hover:bg-slate-50 transition">
                @else
                    <div class="flex items-center justify-between gap-4 px-4 sm:px-6 py-4">
                @endif
                    <div class="min-w-0">
                        <h2 class="font-semibold text-slate-800 break-words">{{ $item['label'] }}</h2>
                        @if ($item['subtitle'])
                            <p class="text-sm text-slate-500 mt-1">{{ $item['subtitle'] }}</p>
                        @endif
                    </div>
                    @if ($item['href'])
                        <i class="fa-solid fa-chevron-right text-slate-400 text-sm"></i>
                    @endif
                @if ($item['href'])
                    </a>
                @else
                    </div>
                @endif
            @empty
                <p class="px-4 sm:px-6 py-8 text-center text-slate-500">{{ $emptyMessage }}</p>
            @endforelse
        </section>
    </main>
</body>
</html>