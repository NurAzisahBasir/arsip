<!-- Form Global Search Bar Responsif -->
<form id="globalSearchForm" onsubmit="return false;" class="bg-white p-2 rounded-2xl shadow-sm border border-slate-200 flex flex-col sm:flex-row items-center gap-2 mb-3">
    <div class="flex items-center w-full pl-2 sm:pl-4">
        <i class="fa-solid fa-magnifying-glass text-blue-600 text-base sm:text-lg mr-2"></i>
        <input 
            type="text" 
            id="globalSearchInput"
            placeholder="Cari Kecamatan, Kelurahan, NIK, No. KK, atau Nama..." 
            class="w-full py-2.5 sm:py-3 px-1 text-slate-700 placeholder-slate-400 focus:outline-none text-sm sm:text-base"
            autocomplete="off"
        >
        <!-- Tombol Clear/Reset Input (Opsional) -->
        <button type="button" id="clearSearchBtn" class="hidden text-slate-400 hover:text-slate-600 px-2 text-sm">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <button 
        type="submit" 
        id="searchSubmitBtn"
        class="w-full sm:w-auto bg-blue-800 hover:bg-blue-900 text-white font-semibold px-6 sm:px-8 py-2.5 sm:py-3 rounded-xl transition duration-200 text-sm sm:text-base whitespace-nowrap cursor-pointer"
    >
        Cari
    </button>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('globalSearchInput');
    const searchForm = document.getElementById('globalSearchForm');
    const clearBtn = document.getElementById('clearSearchBtn');

    // 1. Fungsi Utama Pencarian/Filter
    function executeSearch() {
        const query = searchInput.value.trim().toLowerCase();
        
        // Ganti '.data-row' dengan selector baris tabel atau kartu data Anda
        const rows = document.querySelectorAll('.data-row'); 
        let foundCount = 0;

        rows.forEach(row => {
            const textContent = row.textContent.toLowerCase();
            if (textContent.includes(query)) {
                row.classList.remove('hidden'); // Tampilkan jika cocok
                foundCount++;
            } else {
                row.classList.add('hidden'); // Sembunyikan jika tidak cocok
            }
        });

        // Toggle tombol 'Clear' (X)
        if (query.length > 0) {
            clearBtn.classList.remove('hidden');
        } else {
            clearBtn.classList.add('hidden');
        }

        // Tampilkan pesan "Data tidak ditemukan" jika perlu
        const noDataMessage = document.getElementById('noDataMessage');
        if (noDataMessage) {
            if (foundCount === 0 && query !== '') {
                noDataMessage.classList.remove('hidden');
            } else {
                noDataMessage.classList.add('hidden');
            }
        }
    }

    // 2. Event Listener ketika mengetik (Live Filter / Real-time)
    searchInput.addEventListener('input', executeSearch);

    // 3. Event Listener ketika Form di-submit (Klik tombol Cari / Tekan Enter)
    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        executeSearch();
    });

    // 4. Reset Pencarian
    clearBtn.addEventListener('click', function() {
        searchInput.value = '';
        executeSearch();
        searchInput.focus();
    });
});
</script>