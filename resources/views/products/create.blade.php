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

    {{-- Session Error Alert (dari gagal koneksi/API) --}}
@if (session('error'))
    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-5 shadow-sm">
        <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-red-600">error</span>
            <p class="font-semibold text-red-800 text-sm md:text-base">
                {{ session('error') }}
            </p>
        </div>
    </div>
@endif

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
                    <div class="flex gap-2">
                        <select
                            name="jenis_ukiran"
                            id="select_jenis_ukiran"
                            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#5d4037]/20 focus:border-[#5d4037] transition-all">
                            <option value="">-- Pilih Jenis Ukiran --</option>
                            @foreach($jenis_ukiranOptions as $opt)
                                <option value="{{ $opt['value'] }}" @selected(old('jenis_ukiran') == $opt['value'])>
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
                                <option value="{{ $opt['value'] }}" @selected(old('ukuran') == $opt['value'])>
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
                                <option value="{{ $opt['value'] }}" @selected(old('bahan') == $opt['value'])>
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
                                <option value="{{ $opt['value'] }}" @selected(old('motif') == $opt['value'])>
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
                    placeholder="Ceritakan detail filosofi, kerumitan, atau estimasi pengerjaan mahakarya ini...">{{ old('deskripsi') }}</textarea>
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
            <a href="{{ route('products.index') }}"
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

// Tambah opsi dropdown baru — VERSI DEBUG
document.querySelectorAll('.btn-add-attr').forEach(btn => {
    btn.addEventListener('click', function () {
        const type = this.dataset.type;
        const targetSelect = document.getElementById(this.dataset.target);
        const label = type.replace('_', ' ');

        const value = prompt(`Masukkan ${label} baru:`);
        if (!value || value.trim() === '') return;

        console.log('Mengirim ke:', '{{ route("products.attributes.store") }}');
        console.log('Payload:', { type: type, value: value.trim() });

        fetch('{{ route("products.attributes.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ type: type, value: value.trim() }),
        })
        .then(async res => {
            const text = await res.text();
            console.log('=== HASIL RESPONSE ===');
            console.log('Status:', res.status, res.statusText);
            console.log('Body mentah:', text);
            console.log('======================');

            let json;
            try {
                json = JSON.parse(text);
            } catch (e) {
                alert('Server tidak balas JSON (status ' + res.status + '). Buka Console (F12) untuk lihat detail.');
                return;
            }

            if (json.errors) {
                alert(Object.values(json.errors).flat().join('\n'));
                return;
            }

            if (!json.data) {
                alert('Response tidak ada field "data". Pesan: ' + (json.message || 'tidak diketahui'));
                console.log('Full JSON:', json);
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
        .catch(err => {
            console.error('Fetch gagal total:', err);
            alert('Tidak bisa menghubungi server sama sekali. Cek Console (F12).');
        });
    });
});
</script>
@endsection
