@extends('layouts.app')
@section('title', 'Produk')
@section('content')

<div class="max-w-[1600px] mx-auto space-y-8">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-[#3e2723] tracking-tight">
                Katalog Produk
            </h1>
            <p class="text-sm text-gray-500 mt-1.5">
                Kelola portofolio dan produk seni ukiran kelas premium yang tersedia untuk pelanggan.
            </p>
        </div>

        <a href="{{ route('products.create') }}"
            class="flex items-center gap-2 bg-[#5d4037] hover:bg-[#3e2723] text-white px-5 py-3 rounded-xl font-medium shadow-sm transition-all duration-200 shrink-0">
            <span class="material-symbols-outlined text-xl">add</span>
            Tambah Produk
        </a>
    </div>

    {{-- Alert Notifications --}}
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-xl flex items-center gap-3 shadow-sm animate-fade-in">
            <span class="material-symbols-outlined text-emerald-600">check_circle</span>
            <p class="text-sm font-medium">{{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 px-5 py-4 rounded-xl flex items-center gap-3 shadow-sm">
            <span class="material-symbols-outlined text-red-600">error</span>
            <p class="text-sm font-medium">{{ session('error') }}</p>
        </div>
    @endif

    {{-- Main Container Card --}}
    <div class="bg-white rounded-2xl border border-[#eadfd8] shadow-sm overflow-hidden">

        {{-- Filter & Search Toolbar --}}
        <div class="p-6 border-b border-[#e5ddd8] flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-[#faf8f5]">
            <div>
                <h2 class="text-lg font-bold text-[#3e2723]">
                    Daftar Produk
                </h2>
                <p class="text-xs text-gray-400 mt-0.5 font-medium uppercase tracking-wider">
                    Total: <span class="text-[#5d4037] font-bold">{{ count($products) }}</span> Koleksi Terdaftar
                </p>
            </div>

            <div class="relative w-full md:w-80">
                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 flex items-center">
                    <span class="material-symbols-outlined text-xl">search</span>
                </span>
                <input
                    type="text"
                    id="searchProduct"
                    placeholder="Cari nama, jenis, atau bahan..."
                    class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-gray-200 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-[#5d4037]/20 focus:border-[#5d4037] shadow-inner transition-all">
            </div>
        </div>

        {{-- Table Area --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="productTable">
                <thead>
                    <tr class="bg-[#faf8f5]/50 border-b border-[#e5ddd8] text-gray-500 font-semibold text-xs tracking-wider uppercase">
                        <th class="py-4 px-6 w-32">Visual</th>
                        <th class="py-4 px-6">Identitas Produk</th>
                        <th class="py-4 px-6">Klasifikasi Seni</th>
                        <th class="py-4 px-6">Material Utama</th>
                        <th class="py-4 px-6">Estimasi Harga Base</th>
                        <th class="py-4 px-6 text-center w-28">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($products as $product)
                    <tr class="product-row hover:bg-[#fbfbf9]/70 transition-colors duration-150 cursor-pointer"
                        data-nama="{{ $product['nama_product'] }}"
                        data-jenis="{{ $product['jenis_ukiran'] }}"
                        data-ukuran="{{ $product['ukuran'] ?? 'Custom Order' }}"
                        data-bahan="{{ $product['bahan'] }}"
                        data-motif="{{ $product['motif'] ?? 'Klasik Tradisional' }}"
                        data-harga="Rp {{ number_format($product['estimasi_harga'],0,',','.') }}"
                        data-deskripsi="{{ $product['deskripsi'] ?? 'Tidak ada deskripsi produk.' }}"
                        data-gambar="{{ $product['gambar'] }}">

                        {{-- Image Column --}}
                        <td class="py-4 px-6">
                            @if(!empty($product['gambar']))
                                <div class="w-20 h-20 rounded-xl overflow-hidden shadow-sm border border-[#eadfd8] group bg-gray-50">
                                    <img src="{{ $product['gambar'] }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                </div>
                            @else
                                <div class="w-20 h-20 rounded-xl bg-gray-50 border border-dashed border-gray-200 flex flex-col items-center justify-center gap-1">
                                    <span class="material-symbols-outlined text-gray-300 text-2xl">image</span>
                                    <span class="text-[10px] text-gray-400 font-medium">No Image</span>
                                </div>
                            @endif
                        </td>

                        {{-- Name & Desc Column --}}
                        <td class="py-4 px-6">
                            <h3 class="font-bold text-[#3e2723] text-base hover:text-[#5d4037] transition-colors">
                                {{ $product['nama_product'] }}
                            </h3>
                            <p class="text-xs text-gray-400 mt-1 max-w-xs truncate">
                                {{ $product['deskripsi'] ?? 'Tanpa deskripsi tertulis.' }}
                            </p>
                        </td>

                        {{-- Type Tag Column --}}
                        <td class="py-4 px-6">
                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-800 ring-1 ring-amber-600/10">
                                {{ $product['jenis_ukiran'] ?? '-' }}
                            </span>
                        </td>

                        {{-- Material Column --}}
                        <td class="py-4 px-6 font-medium text-gray-600">
                            {{ $product['bahan'] ?? '-' }}
                        </td>

                        {{-- Pricing Column --}}
                        <td class="py-4 px-6 font-bold text-[#5d4037]">
                            Rp {{ number_format($product['estimasi_harga'],0,',','.') }}
                        </td>

                        {{-- Actions Group Column --}}
                        <td class="py-4 px-6 text-center">
                            <div class="flex justify-center gap-1.5">
                                {{-- Edit --}}
                                <a onclick="event.stopPropagation();"
                                   href="{{ route('products.edit',$product['id']) }}"
                                   class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-50 border border-gray-200 text-gray-500 hover:text-[#5d4037] hover:border-[#5d4037]/30 hover:bg-[#faf7f4] transition-all"
                                   title="Ubah Data">
                                    <span class="material-symbols-outlined text-lg">edit</span>
                                </a>

                                {{-- Delete --}}
                                <form onclick="event.stopPropagation();"
                                      action="{{ route('products.destroy',$product['id']) }}"
                                      method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini permanent?')"
                                            class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-50 border border-gray-200 text-gray-400 hover:text-red-600 hover:border-red-200 hover:bg-red-50 transition-all"
                                            title="Hapus Koleksi">
                                        <span class="material-symbols-outlined text-lg">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-20 text-gray-400">
                            <span class="material-symbols-outlined text-5xl block mb-3 text-gray-300">layers_clear</span>
                            <p class="font-medium text-sm">Belum ada karya ukiran yang didaftarkan</p>
                            <p class="text-xs text-gray-400 mt-1">Silakan tambahkan produk baru melalui tombol di atas.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modernized Modal Detail Produk --}}
<div id="productModal" class="fixed inset-0 bg-[#3e2723]/40 backdrop-blur-sm hidden items-center justify-center z-50 p-4 transition-all duration-300">
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-4xl overflow-hidden grid md:grid-cols-12 max-h-[90vh] md:max-h-none my-auto">

        {{-- Close Button --}}
        <button id="closeModal" class="absolute right-4 top-4 w-9 h-9 rounded-xl bg-white/80 backdrop-blur border border-gray-200 shadow-sm hover:bg-red-50 hover:text-red-600 flex items-center justify-center z-10 transition-colors">
            <span class="material-symbols-outlined text-xl">close</span>
        </button>

        {{-- Left: Media Canvas Container --}}
        <div class="md:col-span-5 bg-gray-50 border-b md:border-b-0 md:border-r border-[#eadfd8] flex items-center justify-center min-h-[300px] md:min-h-[500px]">
            <img id="modalImage" src="" class="w-full h-full object-cover">
        </div>

        {{-- Right: Technical Product Matrix Specs --}}
        <div class="md:col-span-7 p-6 md:p-8 flex flex-col justify-between overflow-y-auto max-h-[50vh] md:max-h-[500px]">
            <div class="space-y-6">
                <div>
                    <span id="modalJenis" class="inline-flex px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-800 ring-1 ring-amber-600/10 uppercase tracking-wider"></span>
                    <h2 id="modalNama" class="text-2xl font-bold text-[#3e2723] tracking-tight mt-2.5"></h2>
                </div>

                <div class="grid grid-cols-2 gap-x-6 gap-y-4 bg-[#faf8f5] p-4 rounded-xl border border-[#eadfd8]">
                    <div>
                        <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Ukuran Dimensi</p>
                        <p id="modalUkuran" class="font-bold text-gray-700 text-sm mt-0.5"></p>
                    </div>
                    <div>
                        <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Jenis Kayu / Material</p>
                        <p id="modalBahan" class="font-bold text-gray-700 text-sm mt-0.5"></p>
                    </div>
                    <div class="col-span-2 border-t border-gray-200/60 pt-3">
                        <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Pola Ornamen / Motif</p>
                        <p id="modalMotif" class="font-bold text-gray-700 text-sm mt-0.5"></p>
                    </div>
                </div>

                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-1.5">Deskripsi Karya</h4>
                    <p id="modalDeskripsi" class="text-gray-600 text-sm leading-relaxed text-justify bg-gray-50/50 p-3 rounded-lg border border-gray-100"></p>
                </div>
            </div>

            <div class="mt-8 pt-4 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Nilai Estimasi (Base Price)</p>
                    <p id="modalHarga" class="text-2xl font-black text-[#5d4037] tracking-tight mt-0.5"></p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Enhanced JavaScript Logic Control --}}
<script>
// Search Engine Table Filter
document.getElementById('searchProduct').addEventListener('keyup', function() {
    let value = this.value.toLowerCase();
    document.querySelectorAll('#productTable tbody tr.product-row').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
    });
});

// Modal Controller Setup
const modal = document.getElementById('productModal');

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
    });
});

// Fast Action Dismiss Popups
const closeModalFunc = () => {
    modal.classList.remove('flex');
    modal.classList.add('hidden');
};

document.getElementById('closeModal').addEventListener('click', closeModalFunc);
modal.addEventListener('click', (e) => { if (e.target === modal) closeModalFunc(); });
</script>
@endsection
