@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="max-w-5xl mx-auto animate-fade-in">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-[#3e2723] tracking-tight">
                Edit Produk
            </h1>
            <p class="text-gray-500 text-sm mt-1.5">
                Perbarui informasi spesifikasi dan detail produk seni ukiran.
            </p>
        </div>
    </div>

    {{-- Form Container --}}
    <form
        action="{{ route('products.update', $product['id']) }}"
        method="POST"
        enctype="multipart/form-data"
        class="bg-white rounded-2xl shadow-sm border border-[#eadfd8] overflow-hidden">

        @csrf
        @method('PUT')

        <div class="p-6 md:p-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Nama Produk --}}
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Nama Produk <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="nama_product"
                        value="{{ old('nama_product', $product['nama_product']) }}"
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#5d4037]/20 focus:border-[#5d4037] transition-all"
                        required>
                </div>

                {{-- Jenis Ukiran --}}
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Jenis Ukiran
                    </label>
                    <input
                        type="text"
                        name="jenis_ukiran"
                        value="{{ old('jenis_ukiran', $product['jenis_ukiran']) }}"
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#5d4037]/20 focus:border-[#5d4037] transition-all">
                </div>

                {{-- Ukuran --}}
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Ukuran / Dimensi
                    </label>
                    <input
                        type="text"
                        name="ukuran"
                        value="{{ old('ukuran', $product['ukuran']) }}"
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#5d4037]/20 focus:border-[#5d4037] transition-all"
                        placeholder="Contoh: 120cm x 80cm">
                </div>

                {{-- Bahan --}}
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Bahan / Material Utama
                    </label>
                    <input
                        type="text"
                        name="bahan"
                        value="{{ old('bahan', $product['bahan']) }}"
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#5d4037]/20 focus:border-[#5d4037] transition-all"
                        placeholder="Contoh: Kayu Jati Perhutani Grade A">
                </div>

                {{-- Motif --}}
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Pola Ornamen / Motif
                    </label>
                    <input
                        type="text"
                        name="motif"
                        value="{{ old('motif', $product['motif']) }}"
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#5d4037]/20 focus:border-[#5d4037] transition-all">
                </div>

                {{-- Harga --}}
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Estimasi Harga Base (Rp)
                    </label>
                    <input
                        type="number"
                        name="estimasi_harga"
                        value="{{ old('estimasi_harga', $product['estimasi_harga']) }}"
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#5d4037]/20 focus:border-[#5d4037] transition-all">
                </div>

            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Deskripsi Karya / Narasi Seni
                </label>
                <textarea
                    name="deskripsi"
                    rows="5"
                    class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#5d4037]/20 focus:border-[#5d4037] transition-all leading-relaxed">{{ old('deskripsi', $product['deskripsi']) }}</textarea>
            </div>

            {{-- Media Grid Preview & Upload --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-4 border-t border-gray-100">
                {{-- Preview Gambar --}}
                <div>
                    <label class="block mb-3 text-sm font-semibold text-gray-700">
                        Gambar Saat Ini
                    </label>
                    <div class="w-full aspect-[4/3] rounded-2xl border border-[#eadfd8] bg-[#faf8f5] overflow-hidden shadow-inner flex items-center justify-center p-2">
                        @if(!empty($product['gambar']))
                            <img
                                id="previewImage"
                                src="{{ $product['gambar'] }}"
                                class="w-full h-full object-cover rounded-xl"
                                alt="Pratinjau Karya">
                        @else
                            <img
                                id="previewImage"
                                src="https://placehold.co/600x400?text=No+Image"
                                class="w-full h-full object-cover rounded-xl"
                                alt="Belum Ada Gambar">
                        @endif
                    </div>
                </div>

                {{-- Upload Area --}}
                <div class="md:col-span-2 flex flex-col justify-end">
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Ganti Gambar Eksklusif
                    </label>
                    <p class="text-xs text-gray-400 mb-3">
                        Gunakan file gambar berkualitas tinggi (.png, .jpg, .jpeg) untuk menjaga estetika visual galeri.
                    </p>
                    <input
                        type="file"
                        name="gambar"
                        id="gambar"
                        accept="image/*"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-[#efebe9] file:text-[#5d4037] hover:file:bg-[#e0d7d3] file:cursor-pointer cursor-pointer border border-gray-200 rounded-xl p-1.5 focus:outline-none">
                </div>
            </div>

        </div>

        {{-- Form Actions Footer --}}
        <div class="flex justify-end gap-3 bg-[#faf8f5] px-6 md:px-8 py-5 border-t border-[#eadfd8]">
            <a
                href="{{ route('products.index') }}"
                class="px-6 py-2.5 rounded-xl border border-gray-300 bg-white text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors">
                Batal
            </a>

            <button
                type="submit"
                class="px-6 py-2.5 rounded-xl bg-[#5d4037] hover:bg-[#3e2723] text-white text-sm font-medium shadow-sm transition-colors">
                Simpan Perubahan
            </button>
        </div>

    </form>
</div>

<script>
// Live Image Preview Controller
document.getElementById('gambar').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        document.getElementById('previewImage').src = URL.createObjectURL(file);
    }
});
</script>
@endsection
