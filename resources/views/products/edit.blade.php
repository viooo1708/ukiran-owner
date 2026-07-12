@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')

<div class="max-w-5xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">

        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                Edit Produk
            </h1>

            <p class="text-gray-500 mt-2">
                Perbarui informasi produk ukiran.
            </p>

        </div>

        <a href="{{ route('products.index') }}"
            class="inline-flex items-center gap-2 rounded-xl border border-gray-300 bg-white px-5 py-3 hover:bg-gray-50">

            <span class="material-symbols-outlined">
                arrow_back
            </span>

            Kembali

        </a>

    </div>

    <form
        action="{{ route('products.update', $product['id']) }}"
        method="POST"
        enctype="multipart/form-data"
        class="bg-white rounded-2xl shadow border border-gray-200 overflow-hidden">

        @csrf
        @method('PUT')

        <div class="p-8">

            <div class="grid md:grid-cols-2 gap-6">

                {{-- Nama Produk --}}
                <div>

                    <label class="block mb-2 font-medium text-gray-700">
                        Nama Produk
                    </label>

                    <input
                        type="text"
                        name="nama_product"
                        value="{{ old('nama_product',$product['nama_product']) }}"
                        class="w-full rounded-xl border-gray-300 focus:ring-amber-500"
                        required>

                </div>

                {{-- Jenis Ukiran --}}
                <div>

                    <label class="block mb-2 font-medium text-gray-700">
                        Jenis Ukiran
                    </label>

                    <input
                        type="text"
                        name="jenis_ukiran"
                        value="{{ old('jenis_ukiran',$product['jenis_ukiran']) }}"
                        class="w-full rounded-xl border-gray-300 focus:ring-amber-500">

                </div>

                {{-- Ukuran --}}
                <div>

                    <label class="block mb-2 font-medium text-gray-700">
                        Ukuran
                    </label>

                    <input
                        type="text"
                        name="ukuran"
                        value="{{ old('ukuran',$product['ukuran']) }}"
                        class="w-full rounded-xl border-gray-300 focus:ring-amber-500">

                </div>

                {{-- Bahan --}}
                <div>

                    <label class="block mb-2 font-medium text-gray-700">
                        Bahan
                    </label>

                    <input
                        type="text"
                        name="bahan"
                        value="{{ old('bahan',$product['bahan']) }}"
                        class="w-full rounded-xl border-gray-300 focus:ring-amber-500">

                </div>

                {{-- Motif --}}
                <div>

                    <label class="block mb-2 font-medium text-gray-700">
                        Motif
                    </label>

                    <input
                        type="text"
                        name="motif"
                        value="{{ old('motif',$product['motif']) }}"
                        class="w-full rounded-xl border-gray-300 focus:ring-amber-500">

                </div>

                {{-- Harga --}}
                <div>

                    <label class="block mb-2 font-medium text-gray-700">
                        Estimasi Harga
                    </label>

                    <input
                        type="number"
                        name="estimasi_harga"
                        value="{{ old('estimasi_harga',$product['estimasi_harga']) }}"
                        class="w-full rounded-xl border-gray-300 focus:ring-amber-500">

                </div>

            </div>

            {{-- Deskripsi --}}
            <div class="mt-6">

                <label class="block mb-2 font-medium text-gray-700">
                    Deskripsi
                </label>

                <textarea
                    name="deskripsi"
                    rows="5"
                    class="w-full rounded-xl border-gray-300 focus:ring-amber-500">{{ old('deskripsi',$product['deskripsi']) }}</textarea>

            </div>

            {{-- Preview Gambar --}}
            <div class="mt-8">

                <label class="block mb-3 font-medium text-gray-700">
                    Gambar Saat Ini
                </label>

                @if(!empty($product['gambar']))

                    <img
                        id="previewImage"
                        src="{{ $product['gambar'] }}"
                        class="w-64 rounded-xl border shadow">

                @else

                    <img
                        id="previewImage"
                        src="https://placehold.co/600x400?text=No+Image"
                        class="w-64 rounded-xl border shadow">

                @endif

            </div>

            {{-- Upload --}}
            <div class="mt-6">

                <label class="block mb-2 font-medium text-gray-700">
                    Ganti Gambar
                </label>

                <input
                    type="file"
                    name="gambar"
                    id="gambar"
                    accept="image/*"
                    class="block w-full rounded-xl border-gray-300">

            </div>

        </div>

        {{-- Footer --}}
        <div class="flex justify-end gap-3 bg-gray-50 px-8 py-5 border-t">

            <a
                href="{{ route('products.index') }}"
                class="px-6 py-3 rounded-xl border border-gray-300 hover:bg-gray-100">

                Batal

            </a>

            <button
                type="submit"
                class="px-6 py-3 rounded-xl bg-amber-700 text-white hover:bg-amber-800">

                Simpan Perubahan

            </button>

        </div>

    </form>

</div>

<script>

document.getElementById('gambar').addEventListener('change', function(e){

    const file = e.target.files[0];

    if(file){

        document.getElementById('previewImage').src =
            URL.createObjectURL(file);

    }

});

</script>

@endsection
