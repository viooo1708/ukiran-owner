@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')

<div class="max-w-[1600px] mx-auto space-y-8">

    {{-- Top Action Bar / Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                <a href="{{ route('products.index') }}" class="hover:text-[#5d4037] transition-colors">Katalog</a>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <span class="text-[#5d4037]">Detail Artefak</span>
            </div>
            <h1 class="text-3xl font-bold text-[#3e2723] tracking-tight mt-1">
                Detail Karya Seni
            </h1>
        </div>
    </div>

    {{-- Main Presentation Block --}}
    <div class="bg-white rounded-2xl border border-[#eadfd8] shadow-sm overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-12">

            {{-- Left: Immersive Visual Showcase --}}
            <div class="lg:col-span-5 bg-[#faf8f5] border-b lg:border-b-0 lg:border-r border-[#e5ddd8] p-6 flex items-center justify-center">
                @if($product['gambar'])
                    <div class="w-full h-[600px] rounded-xl overflow-hidden shadow-md border border-[#eadfd8] bg-white">
                        <img src="{{ $product['gambar'] }}" class="w-full h-full object-cover">
                    </div>
                @else
                    <div class="w-full h-[600px] rounded-xl bg-white border border-dashed border-gray-200 flex flex-col items-center justify-center gap-2 text-gray-400">
                        <span class="material-symbols-outlined text-7xl text-gray-300">image</span>
                        <p class="text-xs font-medium">Foto produk belum tersedia</p>
                    </div>
                @endif
            </div>

            {{-- Right: Technical Spec Blueprint & Metadata --}}
            <div class="lg:col-span-7 p-8 md:p-10 flex flex-col justify-between space-y-6">

                <div class="space-y-6">
                    {{-- Title Area --}}
                    <div>
                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-800 ring-1 ring-amber-600/10 uppercase tracking-wider">
                            {{ $product['jenis_ukiran'] ?? 'Kategori Umum' }}
                        </span>
                        <h2 class="text-3xl font-black text-[#3e2723] tracking-tight mt-3">
                            {{ $product['nama_product'] }}
                        </h2>
                    </div>

                    <hr class="border-gray-100">

                    {{-- Attribute Grid Specs --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 bg-[#faf8f5] p-5 rounded-xl border border-[#eadfd8]">
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-gray-400 mt-0.5">square_foot</span>
                            <div>
                                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Dimensi Fisik</p>
                                <p class="font-semibold text-gray-700 text-sm mt-0.5">{{ $product['ukuran'] ?? 'Custom Ukuran' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-gray-400 mt-0.5">forest</span>
                            <div>
                                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Material Dasar</p>
                                <p class="font-semibold text-gray-700 text-sm mt-0.5">{{ $product['bahan'] ?? 'Kayu Pilihan' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 sm:col-span-2 border-t border-gray-200/60 pt-4">
                            <span class="material-symbols-outlined text-gray-400 mt-0.5">texture</span>
                            <div>
                                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Pola Ornamen / Motif</p>
                                <p class="font-semibold text-gray-700 text-sm mt-0.5">{{ $product['motif'] ?? 'Klasik Tradisional' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Description Area --}}
                    <div class="space-y-2">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-sm">description</span>
                            Narasi Deskripsi Karya
                        </h4>
                        <p class="text-gray-600 text-sm leading-relaxed text-justify bg-gray-50/40 p-4 rounded-xl border border-gray-100">
                            {{ $product['deskripsi'] ?? 'Tidak ada catatan deskripsi tambahan untuk produk seni ini.' }}
                        </p>
                    </div>

                    {{-- Valuation Pricing Block --}}
                    <div class="pt-2">
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Nilai Taksiran (Base Price)</p>
                        <p class="text-3xl font-black text-[#5d4037] tracking-tight">
                            Rp {{ number_format($product['estimasi_harga'], 0, ',', '.') }}
                        </p>
                    </div>

                    {{-- ================= COMANCHE: RIWAYAT STATUS TIMELINE ================= --}}
                    <div class="pt-4 border-t border-gray-100 space-y-3">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-sm">history</span>
                            Riwayat Status & Validasi
                        </h4>

                        <div class="bg-gray-50/60 rounded-xl p-4 border border-gray-100 space-y-4">
                            {{-- Step 1 --}}
                            <div class="flex gap-3 relative pb-2">
                                <div class="absolute left-2 top-5 bottom-0 w-0.5 bg-emerald-200"></div>
                                <div class="w-4 h-4 rounded-full bg-emerald-500 ring-4 ring-emerald-100 shrink-0 mt-1 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[10px] text-white font-bold">check</span>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-700">Masuk Inventaris & Lolos QC</p>
                                    <p class="text-[11px] text-gray-400 mt-0.5">Oleh Editor Logistik • Terverifikasi</p>
                                </div>
                            </div>

                            {{-- Step 2 (Current Active Status) --}}
                            <div class="flex gap-3">
                                <div class="w-4 h-4 rounded-full bg-[#5d4037] ring-4 ring-[#5d4037]/20 shrink-0 mt-1 flex items-center justify-center animate-pulse">
                                    <div class="w-1.5 h-1.5 rounded-full bg-white"></div>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-[#3e2723]">Tersedia di Galeri Utama (Ready Stock)</p>
                                    <p class="text-[11px] text-gray-400 mt-0.5">Status Saat Ini • Siap Dipasarkan / Dilelang</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- ==================================================================== --}}

                </div>

                {{-- Action Footer --}}
                <div class="pt-4 flex flex-col space-y-3">
                    {{-- Tombol Kembali - Tepat di bawah Riwayat Status --}}
                    <a href="{{ route('products.index') }}"
                        class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 bg-white hover:bg-gray-50 border border-gray-200 text-gray-600 font-semibold text-sm rounded-xl shadow-sm transition-all">
                        <span class="material-symbols-outlined text-lg">arrow_back</span>
                        Kembali ke Katalog Utama
                    </a>

                    {{-- Tombol Manajemen Data Alternatif (Edit/Delete) --}}
                    <div class="grid grid-cols-2 gap-3 pt-2">
                        <a href="{{ route('products.edit', $product['id']) }}"
                            class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gray-100 hover:bg-[#5d4037] text-gray-700 hover:text-white rounded-xl font-medium text-xs transition-all duration-200">
                            <span class="material-symbols-outlined text-base">edit</span>
                            Ubah Data
                        </a>

                        <form action="{{ route('products.destroy', $product['id']) }}" method="POST" class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')"
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl font-medium text-xs transition-all duration-200">
                                <span class="material-symbols-outlined text-base">delete</span>
                                Hapus Karya
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
