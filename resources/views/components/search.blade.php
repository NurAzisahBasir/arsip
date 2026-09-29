<form id="globalSearchForm" method="GET" action="{{ route('archives.search') }}" class="bg-white p-2 rounded-2xl shadow-sm border border-slate-200 flex flex-col sm:flex-row items-center gap-2 mb-3" role="search">
    <div class="flex items-center w-full pl-2 sm:pl-4">
        <i class="fa-solid fa-magnifying-glass text-blue-600 text-base sm:text-lg mr-2"></i>
        <input 
            type="text" 
            id="globalSearchInput"
            name="q"
            value="{{ request('q') }}"
            placeholder="Cari Kecamatan, Kelurahan, kode boks, arsip..." 
            aria-label="Cari data arsip"
            class="w-full py-2.5 sm:py-3 px-1 text-slate-700 placeholder-slate-400 focus:outline-none text-sm sm:text-base"
            autocomplete="off"
        >
        <button type="button" id="clearSearchBtn" aria-label="Hapus pencarian" class="hidden text-slate-400 hover:text-slate-600 px-2 text-sm">
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

    if (!searchInput || !searchForm || !clearBtn) return;

    function updateClearButton() {
        clearBtn.classList.toggle('hidden', searchInput.value.length === 0);
    }

    searchInput.addEventListener('input', updateClearButton);
    clearBtn.addEventListener('click', function() {
        searchInput.value = '';
        updateClearButton();
        searchInput.focus();
    });

    updateClearButton();
});
</script>