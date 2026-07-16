@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<div class="max-w-5xl mx-auto animate-fade-in">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-[#3e2723] tracking-tight">
                Tambah Produk
            </h1>
            <p class="text-gray-500 text-sm mt-1.5">
                Tambahkan produk ukiran baru ke dalam katalog galeri Anda.
            </p>
        </div>
    </div>

    {{-- Error Validation Alert --}}
    @if ($errors->any())
        <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-5 shadow-sm">
            <div class="flex items-center gap-2 mb-3">
                <span class="material-symbols-outlined text-red-600">error</span>
                <h3 class="font-semibold text-red-800 text-sm md:text-base">
                    Terjadi kesalahan input data:
                </h3>
            </div>
            <ul class="list-disc list-inside text-sm text-red-700 space-y-1 ml-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Container --}}
    <form
        action="{{ route('products.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="bg-white rounded-2xl shadow-sm border border-[#eadfd8] overflow-hidden">

        @csrf

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
                        value="{{ old('nama_product') }}"
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#5d4037]/20 focus:border-[#5d4037] transition-all"
                        placeholder="Masukkan nama produk seni"
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
                        value="{{ old('jenis_ukiran') }}"
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#5d4037]/20 focus:border-[#5d4037] transition-all"
                        placeholder="Contoh: Relief Jepara, Ukir Kerawang">
                </div>

                {{-- Ukuran --}}
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Ukuran / Dimensi
                    </label>
                    <input
                        type="text"
                        name="ukuran"
                        value="{{ old('ukuran') }}"
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
                        value="{{ old('bahan') }}"
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
                        value="{{ old('motif') }}"
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#5d4037]/20 focus:border-[#5d4037] transition-all"
                        placeholder="Contoh: Motif Lung-lungan, Majapahit">
                </div>

                {{-- Harga --}}
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Estimasi Harga Base (Rp)
                    </label>
                    <input
                        type="number"
                        name="estimasi_harga"
                        value="{{ old('estimasi_harga') }}"
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#5d4037]/20 focus:border-[#5d4037] transition-all"
                        placeholder="Contoh: 5000000">
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
                    class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#5d4037]/20 focus:border-[#5d4037] transition-all leading-relaxed"
                    placeholder="Ceritakan detail filosofi, kerumitan, atau estimasi pengerjaan mahakarya ini..."></textarea>
            </div>

            {{-- Media Grid Upload & Live Preview --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-4 border-t border-gray-100">
                {{-- Preview Container --}}
                <div>
                    <label class="block mb-3 text-sm font-semibold text-gray-700">
                        Pratinjau Gambar
                    </label>
                    <div class="w-full aspect-[4/3] rounded-2xl border border-[#eadfd8] bg-[#faf8f5] overflow-hidden shadow-inner flex items-center justify-center p-2">
                        <img
                            id="previewImage"
                            src="https://placehold.co/600x400?text=Pilih+Gambar"
                            class="w-full h-full object-cover rounded-xl"
                            alt="Pratinjau Karya">
                    </div>
                </div>

                {{-- Upload Input --}}
                <div class="md:col-span-2 flex flex-col justify-end">
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Unggah Gambar Eksklusif
                    </label>
                    <p class="text-xs text-gray-400 mb-3">
                        Gunakan file gambar berkualitas tinggi (.png, .jpg, .jpeg) untuk menjaga estetika visual galeri digital.
                    </p>
                    <input
                        type="file"
                        name="gambar"
                        id="gambar"
                        accept="image/*"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-[#efebe9] file:text-[#5d4037] hover:file:bg-[#e0d7d3] file:cursor-pointer cursor-pointer border border-gray-200 rounded-xl p-1.5 focus:outline-none"
                        required>
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
                class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-[#5d4037] hover:bg-[#3e2723] text-white text-sm font-medium shadow-sm transition-colors">
                <span class="material-symbols-outlined text-lg">save</span>
                Simpan Produk
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
