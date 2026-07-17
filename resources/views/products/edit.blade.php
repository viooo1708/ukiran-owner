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
                    <div class="flex gap-2">
                        <select
                            name="jenis_ukiran"
                            id="select_jenis_ukiran"
                            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#5d4037]/20 focus:border-[#5d4037] transition-all">
                            <option value="">-- Pilih Jenis Ukiran --</option>
                            @foreach($jenis_ukiranOptions as $opt)
                                <option value="{{ $opt['value'] }}" @selected(old('jenis_ukiran', $product['jenis_ukiran']) == $opt['value'])>
                                    {{ $opt['value'] }}
                                </option>
                            @endforeach
                        </select>
                        <button
                            type="button"
                            class="btn-add-attr shrink-0 px-3 rounded-xl border border-dashed border-gray-300 text-gray-500 hover:border-[#5d4037] hover:text-[#5d4037] text-sm transition-colors"
                            data-type="jenis_ukiran"
                            data-target="select_jenis_ukiran"
                            title="Tambah Jenis Ukiran Baru">
                            + Baru
                        </button>
                    </div>
                </div>

                {{-- Ukuran --}}
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Ukuran / Dimensi
                    </label>
                    <div class="flex gap-2">
                        <select
                            name="ukuran"
                            id="select_ukuran"
                            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#5d4037]/20 focus:border-[#5d4037] transition-all">
                            <option value="">-- Pilih Ukuran --</option>
                            @foreach($ukuranOptions as $opt)
                                <option value="{{ $opt['value'] }}" @selected(old('ukuran', $product['ukuran']) == $opt['value'])>
                                    {{ $opt['value'] }}
                                </option>
                            @endforeach
                        </select>
                        <button
                            type="button"
                            class="btn-add-attr shrink-0 px-3 rounded-xl border border-dashed border-gray-300 text-gray-500 hover:border-[#5d4037] hover:text-[#5d4037] text-sm transition-colors"
                            data-type="ukuran"
                            data-target="select_ukuran"
                            title="Tambah Ukuran Baru">
                            + Baru
                        </button>
                    </div>
                </div>

                {{-- Bahan --}}
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Bahan / Material Utama
                    </label>
                    <div class="flex gap-2">
                        <select
                            name="bahan"
                            id="select_bahan"
                            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#5d4037]/20 focus:border-[#5d4037] transition-all">
                            <option value="">-- Pilih Bahan --</option>
                            @foreach($bahanOptions as $opt)
                                <option value="{{ $opt['value'] }}" @selected(old('bahan', $product['bahan']) == $opt['value'])>
                                    {{ $opt['value'] }}
                                </option>
                            @endforeach
                        </select>
                        <button
                            type="button"
                            class="btn-add-attr shrink-0 px-3 rounded-xl border border-dashed border-gray-300 text-gray-500 hover:border-[#5d4037] hover:text-[#5d4037] text-sm transition-colors"
                            data-type="bahan"
                            data-target="select_bahan"
                            title="Tambah Bahan Baru">
                            + Baru
                        </button>
                    </div>
                </div>

                {{-- Motif --}}
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Pola Ornamen / Motif
                    </label>
                    <div class="flex gap-2">
                        <select
                            name="motif"
                            id="select_motif"
                            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#5d4037]/20 focus:border-[#5d4037] transition-all">
                            <option value="">-- Pilih Motif --</option>
                            @foreach($motifOptions as $opt)
                                <option value="{{ $opt['value'] }}" @selected(old('motif', $product['motif']) == $opt['value'])>
                                    {{ $opt['value'] }}
                                </option>
                            @endforeach
                        </select>
                        <button
                            type="button"
                            class="btn-add-attr shrink-0 px-3 rounded-xl border border-dashed border-gray-300 text-gray-500 hover:border-[#5d4037] hover:text-[#5d4037] text-sm transition-colors"
                            data-type="motif"
                            data-target="select_motif"
                            title="Tambah Motif Baru">
                            + Baru
                        </button>
                    </div>
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

// Tambah opsi dropdown baru (motif, jenis_ukiran, bahan, ukuran)
document.querySelectorAll('.btn-add-attr').forEach(btn => {
    btn.addEventListener('click', function () {
        const type = this.dataset.type;
        const targetSelect = document.getElementById(this.dataset.target);
        const label = type.replace('_', ' ');

        const value = prompt(`Masukkan ${label} baru:`);
        if (!value || value.trim() === '') return;

        fetch('{{ route("products.attributes.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ type: type, value: value.trim() }),
        })
        .then(res => res.json())
        .then(json => {
            if (json.errors) {
                alert(Object.values(json.errors).flat().join('\n'));
                return;
            }
            const newValue = json.data.value;

            const exists = [...targetSelect.options].some(o => o.value === newValue);
            if (!exists) {
                const opt = document.createElement('option');
                opt.value = newValue;
                opt.textContent = newValue;
                targetSelect.appendChild(opt);
            }
            targetSelect.value = newValue;
        })
        .catch(() => alert('Gagal menambahkan opsi baru. Coba lagi.'));
    });
});
</script>
@endsection
