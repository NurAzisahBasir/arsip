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
            <div class="flex items-center gap-3">
                <input id="listSearch" type="search" placeholder="Cari..." class="py-2 px-3 rounded-xl border border-slate-200 focus:outline-none text-sm w-56" />
                <button id="addItemBtn" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl text-sm flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i>
                    <span>Tambah {{ Str::contains($title, 'Rak') ? 'Rak' : 'Item' }}</span>
                </button>
                <span class="text-sm text-slate-500">{{ count($items) }} data</span>
            </div>
        </div>

        @if(Str::contains($title, 'Rak') || Str::contains($title, 'Boks'))
            <div class="bg-white border border-slate-200 rounded-lg overflow-hidden">
                <div class="hidden sm:flex items-center px-4 sm:px-6 py-3 text-sm text-slate-500 bg-slate-50 border-b border-slate-100">
                    <div class="w-12">NO</div>
                    <div class="flex-1 font-medium">NOMOR BOKS / RAK</div>
                    <div class="w-40 text-center">JUMLAH ARSIP</div>
                    <div class="w-28 text-center">AKSI</div>
                </div>

                @forelse ($items as $item)
                    <div class="flex items-center px-4 sm:px-6 py-4 border-b last:border-b-0 hover:bg-slate-50 transition">
                        <div class="w-12 text-sm text-slate-500">{{ sprintf('%02d', $loop->iteration) }}</div>
                        <div class="flex-1">
                            <a href="{{ $item['href'] ?? '#' }}" class="font-semibold text-slate-800 hover:underline">{{ $item['label'] }}</a>
                            @if(!empty($item['subtitle']))
                                <div class="text-sm text-slate-400 mt-1">{{ $item['subtitle'] }}</div>
                            @endif
                        </div>
                        <div class="w-40 text-center text-sm text-slate-600">{{ $item['count'] ?? ($item['subtitle_count'] ?? '') }}</div>
                        <div class="w-28 text-center flex items-center justify-center gap-2">
                            @if(!empty($item['href']))
                                <a href="{{ $item['href'] }}" class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">Buka</a>
                            @endif
                            @if(!empty($item['delete_url']))
                                <button data-delete-url="{{ $item['delete_url'] }}" class="deleteBtn inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700">Hapus</button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="px-4 sm:px-6 py-8 text-center text-slate-500">{{ $emptyMessage }}</div>
                @endforelse
            </div>
        @else
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
        @endif

    <script>
        // Delete handler for AJAX
        document.querySelectorAll('.deleteBtn').forEach(btn => {
            btn.addEventListener('click', function(){
                const url = this.dataset.deleteUrl;
                if (!url) return;
                if (!confirm('Hapus rak ini? Tindakan tidak bisa dibatalkan.')) return;

                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || document.querySelector('input[name=_token]')?.value,
                        'Accept': 'application/json'
                    }
                }).then(r => r.json()).then(res => {
                    if (res.success) {
                        location.reload();
                    } else {
                        alert('Gagal menghapus');
                    }
                }).catch(()=> alert('Gagal menghapus'));
            });
        });
    </script>
    </main>

    <!-- Modal Tambah Item -->
    <div id="addModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
            <div class="bg-white rounded-xl p-6 w-full max-w-md">
                <h3 class="text-lg font-semibold mb-4">Tambah {{ Str::contains($title, 'Rak') ? 'Rak' : 'Item' }}</h3>
                <form id="addForm">
                    @csrf
                    <div class="mb-3">
                        <label class="block text-sm text-slate-600 mb-1">NIK</label>
                        <input name="nik" class="w-full border border-slate-200 rounded-xl px-3 py-2" />
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm text-slate-600 mb-1">Nama</label>
                        <input name="name" class="w-full border border-slate-200 rounded-xl px-3 py-2" required />
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" id="cancelAdd" class="px-4 py-2 rounded-xl border">Batal</button>
                        <button type="submit" class="px-4 py-2 rounded-xl bg-emerald-600 text-white">Simpan</button>
                    </div>
                </form>
            </div>
    </div>

    <script>
        // Simple client-side search
        (function(){
            const search = document.getElementById('listSearch');
            if (search) {
                search.addEventListener('input', function(){
                    const q = this.value.trim().toLowerCase();
                    document.querySelectorAll('section a, section div').forEach(el => {
                        const txt = (el.textContent||'').toLowerCase();
                        el.style.display = q === '' || txt.indexOf(q) !== -1 ? '' : 'none';
                    });
                });
            }

            // Modal handlers
            const addBtn = document.getElementById('addItemBtn');
            const modal = document.getElementById('addModal');
            const cancel = document.getElementById('cancelAdd');
            const form = document.getElementById('addForm');

            addBtn && addBtn.addEventListener('click', () => modal.classList.remove('hidden'));
            cancel && cancel.addEventListener('click', () => modal.classList.add('hidden'));

            form && form.addEventListener('submit', function(e){
                e.preventDefault();
                const data = Object.fromEntries(new FormData(this).entries());
                fetch('{{ url()->current() }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name=_token]')?.value || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
                        'Accept':'application/json'
                    },
                    body: JSON.stringify(data)
                }).then(async r => {
                    if (r.ok) {
                        // try parse json
                        try {
                            const json = await r.json();
                            if (json && json.success) return location.reload();
                            alert('Gagal menyimpan: ' + (json?.message || JSON.stringify(json)));
                        } catch (err) {
                            // not json
                            location.reload();
                        }
                    } else {
                        const text = await r.text();
                        let msg = text;
                        try { const j = JSON.parse(text); msg = j.message || JSON.stringify(j); } catch(e){}
                        alert('Gagal menyimpan: ' + msg);
                    }
                }).catch(err => {
                    console.error(err);
                    alert('Gagal menyimpan (network atau server error). Cek log server.');
                });
            });
        })();
    </script>
</body>
</html>