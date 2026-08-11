@extends('layouts.app')
@section('title', 'Produk')
@section('content')

<div class="max-w-7xl mx-auto space-y-8 animate-fade-in text-gray-800 pb-12">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#3e2723] tracking-tight">
                Katalog Produk
            </h1>
            <p class="text-sm sm:text-base text-gray-500 mt-1">
                Kelola portofolio dan produk seni ukiran kelas premium yang tersedia untuk pelanggan.
            </p>
        </div>

        {{-- Date Badge (Opsional, disamakan dengan Dashboard agar konsisten) --}}
        <div class="flex items-center gap-3 bg-white border border-[#eadfd8] px-4 py-2.5 rounded-xl shadow-sm self-start md:self-auto">
            <span class="material-symbols-outlined text-[#6d4c41]">calendar_today</span>
            <div>
                <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider leading-none">
                    Hari Ini
                </p>
                <p class="text-sm font-bold text-[#5d4037] leading-tight mt-0.5">
                    {{ now()->translatedFormat('d F Y') }}
                </p>
            </div>
        </div>
    </div>

    {{-- Main Container Card --}}
    <div class="bg-white rounded-2xl border border-[#eadfd8] shadow-sm overflow-hidden">

        {{-- Filter & Search Toolbar --}}
        <div class="p-6 flex flex-col gap-6 bg-[#faf8f5] border-b border-gray-100">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h3 class="font-bold text-lg text-[#3e2723]">
                        Daftar Produk
                    </h3>
                    <p class="text-xs text-gray-400 mt-0.5">
                        Total: <span class="text-[#5d4037] font-bold bg-[#efebe9] px-2.5 py-0.5 rounded-full border border-[#d7ccc8]" id="totalCount">{{ count($products) }}</span> Koleksi Terdaftar
                    </p>
                </div>

                {{-- Search & Minimalist Add Button Group --}}
                <div class="flex items-center gap-2.5 w-full md:w-auto">
                    <div class="relative w-full md:w-80">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 flex items-center pointer-events-none">
                            <span class="material-symbols-outlined text-sm">search</span>
                        </span>
                        <input
                            type="text"
                            id="searchProduct"
                            placeholder="Cari nama, jenis, atau bahan..."
                            class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 bg-white text-xs font-semibold text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#5d4037]/10 focus:border-[#5d4037] shadow-sm transition-all placeholder:text-gray-400">
                    </div>

                    {{-- Tombol Tambah Produk Minimalis (Icon Button) --}}
                    <a href="{{ route('products.create') }}"
                        class="flex items-center justify-center w-10 h-10 shrink-0 bg-[#5d4037] hover:bg-[#3e2723] text-white rounded-xl shadow-sm transition-all duration-200"
                        title="Tambah Produk Baru">
                        <span class="material-symbols-outlined text-xl">add</span>
                    </a>
                </div>
            </div>

            {{-- Filter Dropdowns --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:flex lg:flex-wrap items-end gap-3 pt-4 border-t border-gray-200/60">
                <div class="flex flex-col gap-1.5 lg:w-44">
                    <label class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Jenis Ukiran</label>
                    <select id="filterJenis" class="filter-select w-full rounded-xl border border-gray-200 bg-white px-3 py-2 text-xs font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#5d4037]/10 focus:border-[#5d4037] transition-all cursor-pointer">
                        <option value="">Semua Jenis</option>
                        @foreach($jenis_ukiranOptions as $opt)
                            <option value="{{ $opt['value'] }}">{{ $opt['value'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-1.5 lg:w-44">
                    <label class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Bahan Utama</label>
                    <select id="filterBahan" class="filter-select w-full rounded-xl border border-gray-200 bg-white px-3 py-2 text-xs font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#5d4037]/10 focus:border-[#5d4037] transition-all cursor-pointer">
                        <option value="">Semua Bahan</option>
                        @foreach($bahanOptions as $opt)
                            <option value="{{ $opt['value'] }}">{{ $opt['value'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-1.5 lg:w-44">
                    <label class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Motif Ornamen</label>
                    <select id="filterMotif" class="filter-select w-full rounded-xl border border-gray-200 bg-white px-3 py-2 text-xs font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#5d4037]/10 focus:border-[#5d4037] transition-all cursor-pointer">
                        <option value="">Semua Motif</option>
                        @foreach($motifOptions as $opt)
                            <option value="{{ $opt['value'] }}">{{ $opt['value'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-1.5 lg:w-44">
                    <label class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Dimensi / Ukuran</label>
                    <select id="filterUkuran" class="filter-select w-full rounded-xl border border-gray-200 bg-white px-3 py-2 text-xs font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#5d4037]/10 focus:border-[#5d4037] transition-all cursor-pointer">
                        <option value="">Semua Ukuran</option>
                        @foreach($ukuranOptions as $opt)
                            <option value="{{ $opt['value'] }}">{{ $opt['value'] }}</option>
                        @endforeach
                    </select>
                </div>

                <button id="resetFilter" type="button"
                    class="lg:mb-0.5 inline-flex items-center justify-center gap-1 text-xs font-bold text-gray-500 hover:text-rose-600 border border-gray-200 hover:border-rose-200 hover:bg-rose-50 px-3.5 py-2 rounded-xl transition-all h-[34px]">
                    <span class="material-symbols-outlined text-sm">close</span>
                    Reset
                </button>
            </div>
        </div>

        {{-- Table Area --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm" id="productTable">
                <thead>
                    <tr class="bg-[#faf7f4] text-gray-500 text-xs font-semibold uppercase tracking-wider border-b border-gray-100">
                        <th class="py-4 px-6 w-24 text-center">Visual</th>
                        <th class="py-4 px-6">Identitas Produk</th>
                        <th class="py-4 px-6 w-40">Jenis Ukiran</th>
                        <th class="py-4 px-6 w-40">Material Utama</th>
                        <th class="py-4 px-6 w-44">Estimasi Harga Base</th>
                        <th class="py-4 px-6 text-center w-28">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $product)
                    <tr class="product-row hover:bg-[#faf7f4]/60 transition-colors duration-150 cursor-pointer group"
                        data-nama="{{ $product['nama_product'] }}"
                        data-jenis="{{ $product['jenis_ukiran'] ?? 'Tidak Spesifik' }}"
                        data-ukuran="{{ $product['ukuran'] ?? 'Custom Order' }}"
                        data-bahan="{{ $product['bahan'] ?? 'Tidak Spesifik' }}"
                        data-motif="{{ $product['motif'] ?? 'Klasik Tradisional' }}"
                        data-harga="Rp {{ number_format($product['estimasi_harga'], 0, ',', '.') }}"
                        data-deskripsi="{{ $product['deskripsi'] ?? 'Tidak ada deskripsi produk.' }}"
                        data-gambar="{{ $product['gambar'] }}">

                        {{-- Image Column --}}
                        <td class="py-4 px-6">
                            <div class="w-12 h-12 mx-auto rounded-xl overflow-hidden shadow-sm border border-gray-200 bg-gray-50 flex items-center justify-center relative">
                                @if(!empty($product['gambar']))
                                    <img src="{{ $product['gambar'] }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300" alt="{{ $product['nama_product'] }}">
                                @else
                                    <div class="flex flex-col items-center justify-center gap-0.5 text-gray-300">
                                        <span class="material-symbols-outlined text-xl">image</span>
                                        <span class="text-[9px] font-bold uppercase tracking-wider">Empty</span>
                                    </div>
                                @endif
                            </div>
                        </td>

                        {{-- Name & Desc Column --}}
                        <td class="py-4 px-6">
                            <h3 class="font-bold text-[#3e2723] text-sm group-hover:text-[#5d4037] transition-colors line-clamp-1">
                                {{ $product['nama_product'] }}
                            </h3>
                            <p class="text-xs text-gray-400 mt-0.5 max-w-xs md:max-w-md line-clamp-1 leading-relaxed">
                                {{ $product['deskripsi'] ?? 'Tanpa deskripsi tertulis.' }}
                            </p>
                        </td>

                        {{-- Type Tag Column --}}
                        <td class="py-4 px-6">
                            <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold bg-amber-50 text-amber-800 border border-amber-200/40">
                                {{ $product['jenis_ukiran'] ?? '-' }}
                            </span>
                        </td>

                        {{-- Material Column --}}
                        <td class="py-4 px-6 font-medium text-gray-600 text-xs">
                            {{ $product['bahan'] ?? '-' }}
                        </td>

                        {{-- Pricing Column --}}
                        <td class="py-4 px-6 font-bold text-emerald-700 text-xs">
                            <span class="inline-flex items-center rounded-lg bg-emerald-50 px-2.5 py-1 border border-emerald-200">
                                Rp {{ number_format($product['estimasi_harga'], 0, ',', '.') }}
                            </span>
                        </td>

                        {{-- Actions Group Column --}}
                        <td class="py-4 px-6 text-center">
                            <div class="flex justify-center items-center gap-1.5">
                                {{-- Edit --}}
                                <a onclick="event.stopPropagation();"
                                   href="{{ route('products.edit', $product['id']) }}"
                                   class="inline-flex items-center justify-center px-3 py-1.5 bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 text-xs font-semibold rounded-lg shadow-sm transition-colors"
                                   title="Ubah Data">
                                    Edit
                                </a>

                                {{-- Delete --}}
                                <form onclick="event.stopPropagation();"
                                      action="{{ route('products.destroy', $product['id']) }}"
                                      method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini permanen?')"
                                            class="inline-flex items-center justify-center px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 text-xs font-semibold rounded-lg shadow-sm transition-colors"
                                            title="Hapus Koleksi">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-20 text-gray-400">
                            <span class="material-symbols-outlined text-4xl block mb-2 text-gray-300">layers_clear</span>
                            <p class="font-bold text-gray-700 text-sm">Belum ada karya ukiran yang didaftarkan</p>
                            <p class="text-xs text-gray-400 mt-1">Silakan tambahkan produk mahakarya baru Anda melalui tombol tambah produk.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Empty state khusus untuk hasil filter/search kosong --}}
            <div id="noResultRow" class="hidden text-center py-20 text-gray-400">
                <span class="material-symbols-outlined text-4xl block mb-2 text-gray-300">search_off</span>
                <p class="font-bold text-gray-700 text-sm">Tidak ada produk yang cocok</p>
                <p class="text-xs text-gray-400 mt-1">Coba sesuaikan kembali kata kunci pencarian atau kombinasi filter Anda.</p>
            </div>
        </div>

        {{-- Pagination Container --}}
        <div id="paginationContainer" class="flex flex-col sm:flex-row items-center justify-between px-6 py-4 border-t border-gray-100 bg-[#faf8f5] text-xs">
            <span id="paginationInfo" class="text-gray-500 mb-3 sm:mb-0 font-medium">Menampilkan 0 dari 0 data</span>
            <div id="paginationButtons" class="flex items-center gap-1.5">
                {{-- Tombol halaman akan di-generate otomatis via JS --}}
            </div>
        </div>

    </div>
</div>

{{-- Modernized Modal Detail Produk --}}
<div id="productModal" class="fixed inset-0 bg-[#3e2723]/40 backdrop-blur-sm hidden items-center justify-center z-[100] p-4 opacity-0 transition-all duration-300">
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-4xl overflow-hidden grid md:grid-cols-12 max-h-[90vh] md:max-h-none my-auto transform scale-95 transition-all duration-300" id="modalContent">

        {{-- Close Button --}}
        <button id="closeModal" class="absolute right-4 top-4 w-9 h-9 rounded-xl bg-white/90 backdrop-blur border border-gray-200 shadow-sm hover:bg-rose-50 hover:text-rose-600 flex items-center justify-center z-10 transition-colors">
            <span class="material-symbols-outlined text-xl">close</span>
        </button>

        {{-- Left Side: Foto / Media Canvas Container --}}
        <div class="md:col-span-5 bg-[#faf8f5] border-b md:border-b-0 md:border-r border-gray-100 flex items-center justify-center min-h-[240px] md:min-h-[480px] p-6 relative">
            <img id="modalImage" src="" class="max-w-full max-h-[220px] md:max-h-[400px] w-auto h-auto object-contain rounded-xl shadow-sm bg-white border border-gray-200/60" alt="Foto Produk">
        </div>

        {{-- Right Side: Specifications Matrix --}}
        <div class="md:col-span-7 p-6 md:p-8 flex flex-col justify-between overflow-y-auto max-h-[55vh] md:max-h-[480px]">
            <div class="space-y-5">
                <div>
                    <span class="text-[10px] uppercase font-bold tracking-widest text-amber-700 block mb-1">Spesifikasi Karya</span>
                    <h2 id="modalNama" class="text-xl sm:text-2xl font-black text-[#3e2723] tracking-tight leading-snug"></h2>
                </div>

                <div class="grid grid-cols-2 gap-x-4 gap-y-3 bg-[#faf8f5] p-4 rounded-xl border border-[#eadfd8]">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Jenis Ukiran</p>
                        <p id="modalJenis" class="font-bold text-gray-800 text-xs mt-0.5"></p>
                    </div>

                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Ukuran / Dimensi</p>
                        <p id="modalUkuran" class="font-bold text-gray-800 text-xs mt-0.5"></p>
                    </div>

                    <div class="col-span-2 border-t border-gray-200/60 pt-2.5">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Bahan / Material Utama</p>
                        <p id="modalBahan" class="font-medium text-gray-700 text-xs mt-0.5"></p>
                    </div>

                    <div class="col-span-2 border-t border-gray-200/60 pt-2.5">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Pola Ornamen / Motif</p>
                        <p id="modalMotif" class="font-medium text-gray-700 text-xs mt-0.5"></p>
                    </div>
                </div>

                <div>
                    <h4 class="text-[10px] font-bold uppercase tracking-wider text-gray-400 mb-1">Deskripsi Produk</h4>
                    <p id="modalDeskripsi" class="text-gray-600 text-xs leading-relaxed bg-gray-50 p-3.5 rounded-xl border border-gray-200/60 whitespace-pre-line max-h-28 overflow-y-auto"></p>
                </div>
            </div>

            <div class="mt-5 pt-3 border-t border-gray-100 flex justify-between items-end">
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Estimasi Harga Base</p>
                    <p id="modalHarga" class="text-2xl font-black text-emerald-700 tracking-tight mt-0.5"></p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript Engine --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput  = document.getElementById('searchProduct');
    const filterJenis  = document.getElementById('filterJenis');
    const filterBahan  = document.getElementById('filterBahan');
    const filterMotif  = document.getElementById('filterMotif');
    const filterUkuran = document.getElementById('filterUkuran');
    const resetBtn     = document.getElementById('resetFilter');
    const totalCount   = document.getElementById('totalCount');
    const noResultRow  = document.getElementById('noResultRow');

    const paginationInfo    = document.getElementById('paginationInfo');
    const paginationButtons = document.getElementById('paginationButtons');

    const rowsNodeList = document.querySelectorAll('#productTable tbody tr.product-row');
    const rows = Array.from(rowsNodeList);

    let currentPage = 1;
    const rowsPerPage = 10;

    function applyFilters() {
        const search = searchInput.value.toLowerCase();
        const jenis  = filterJenis.value;
        const bahan  = filterBahan.value;
        const motif  = filterMotif.value;
        const ukuran = filterUkuran.value;

        const filteredRows = rows.filter(row => {
            const matchSearch = !search || row.innerText.toLowerCase().includes(search);
            const matchJenis  = !jenis  || row.dataset.jenis  === jenis;
            const matchBahan  = !bahan  || row.dataset.bahan  === bahan;
            const matchMotif  = !motif  || row.dataset.motif  === motif;
            const matchUkuran = !ukuran || row.dataset.ukuran === ukuran;

            return matchSearch && matchJenis && matchBahan && matchMotif && matchUkuran;
        });

        const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
        if (currentPage > totalPages && totalPages > 0) {
            currentPage = totalPages;
        } else if (currentPage < 1) {
            currentPage = 1;
        }

        rows.forEach(row => row.style.display = 'none');

        const startIndex = (currentPage - 1) * rowsPerPage;
        const endIndex = startIndex + rowsPerPage;
        const visibleRows = filteredRows.slice(startIndex, endIndex);

        visibleRows.forEach(row => row.style.display = '');

        totalCount.textContent = filteredRows.length;
        noResultRow.classList.toggle('hidden', filteredRows.length !== 0 || rows.length === 0);

        if (filteredRows.length > 0) {
            paginationInfo.innerText = `Menampilkan ${startIndex + 1} - ${Math.min(endIndex, filteredRows.length)} dari ${filteredRows.length} data`;
        } else {
            paginationInfo.innerText = `Menampilkan 0 dari 0 data`;
        }

        renderPaginationButtons(totalPages);
    }

    function renderPaginationButtons(totalPages) {
        paginationButtons.innerHTML = '';

        if (totalPages <= 1) return;

        const prevButton = document.createElement('button');
        prevButton.innerHTML = '&laquo; Prev';
        prevButton.className = `px-3 py-1.5 rounded-lg border font-bold transition-colors ${currentPage === 1 ? 'bg-gray-100 text-gray-300 border-gray-200 cursor-not-allowed' : 'bg-white text-gray-700 border-gray-200 hover:bg-[#5d4037] hover:text-white hover:border-[#5d4037]'}`;
        prevButton.disabled = currentPage === 1;
        prevButton.addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                applyFilters();
            }
        });
        paginationButtons.appendChild(prevButton);

        for (let i = 1; i <= totalPages; i++) {
            const pageButton = document.createElement('button');
            pageButton.innerText = i;
            pageButton.className = `px-3 py-1.5 rounded-lg border font-bold transition-colors ${currentPage === i ? 'bg-[#5d4037] text-white border-[#5d4037]' : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-100'}`;
            pageButton.addEventListener('click', () => {
                currentPage = i;
                applyFilters();
            });
            paginationButtons.appendChild(pageButton);
        }

        const nextButton = document.createElement('button');
        nextButton.innerHTML = 'Next &raquo;';
        nextButton.className = `px-3 py-1.5 rounded-lg border font-bold transition-colors ${currentPage === totalPages ? 'bg-gray-100 text-gray-300 border-gray-200 cursor-not-allowed' : 'bg-white text-gray-700 border-gray-200 hover:bg-[#5d4037] hover:text-white hover:border-[#5d4037]'}`;
        nextButton.disabled = currentPage === totalPages;
        nextButton.addEventListener('click', () => {
            if (currentPage < totalPages) {
                currentPage++;
                applyFilters();
            }
        });
        paginationButtons.appendChild(nextButton);
    }

    searchInput.addEventListener('keyup', () => {
        currentPage = 1;
        applyFilters();
    });

    [filterJenis, filterBahan, filterMotif, filterUkuran].forEach(el => {
        el.addEventListener('change', () => {
            currentPage = 1;
            applyFilters();
        });
    });

    resetBtn.addEventListener('click', function () {
        searchInput.value = '';
        filterJenis.value = '';
        filterBahan.value = '';
        filterMotif.value = '';
        filterUkuran.value = '';
        currentPage = 1;
        applyFilters();
    });

    const modal = document.getElementById('productModal');
    const modalContent = document.getElementById('modalContent');

    document.querySelectorAll('.product-row').forEach(row => {
        row.addEventListener('click', function() {
            document.getElementById('modalNama').textContent = this.dataset.nama;
            document.getElementById('modalJenis').textContent = this.dataset.jenis;
            document.getElementById('modalUkuran').textContent = this.dataset.ukuran;
            document.getElementById('modalBahan').textContent = this.dataset.bahan;
            document.getElementById('modalMotif').textContent = this.dataset.motif;
            document.getElementById('modalHarga').textContent = this.dataset.harga;
            document.getElementById('modalDeskripsi').textContent = this.dataset.deskripsi;

            let gambar = this.dataset.gambar;
            document.getElementById('modalImage').src = gambar && gambar.trim() !== '' ? gambar : 'https://placehold.co/600x800?text=No+Image';

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalContent.classList.remove('scale-95');
            }, 10);
        });
    });

    const closeModalFunc = () => {
        modal.classList.add('opacity-0');
        modalContent.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }, 300);
    };

    document.getElementById('closeModal').addEventListener('click', closeModalFunc);
    modal.addEventListener('click', (e) => { if (e.target === modal) closeModalFunc(); });

    applyFilters();
});
</script>
@endsection
