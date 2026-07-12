@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')

<div class="max-w-5xl mx-auto p-8">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">

        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                Tambah Produk
            </h1>

            <p class="text-gray-500 mt-2">
                Tambahkan produk ukiran baru ke dalam katalog.
            </p>

        </div>

        <a href="{{ route('products.index') }}"
            class="inline-flex items-center gap-2 px-5 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition">

            <span class="material-symbols-outlined">
                arrow_back
            </span>

            Kembali

        </a>

    </div>

    {{-- Error Validation --}}
    @if ($errors->any())

        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-5">

            <div class="flex items-center gap-2 mb-3">

                <span class="material-symbols-outlined text-red-600">
                    error
                </span>

                <h3 class="font-semibold text-red-700">
                    Terjadi kesalahan
                </h3>

            </div>

            <ul class="list-disc list-inside text-red-600 space-y-1">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <form
        action="{{ route('products.store') }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf

        <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">

            <div class="p-8">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Nama Produk --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Produk
                        </label>

                        <input
                            type="text"
                            name="nama_product"
                            value="{{ old('nama_product') }}"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                            placeholder="Masukkan nama produk">

                    </div>

                    {{-- Jenis Ukiran --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Jenis Ukiran
                        </label>

                        <input
                            type="text"
                            name="jenis_ukiran"
                            value="{{ old('jenis_ukiran') }}"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                            placeholder="Contoh: Ukiran Jepara">

                    </div>

                    {{-- Ukuran --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Ukuran
                        </label>

                        <input
                            type="text"
                            name="ukuran"
                            value="{{ old('ukuran') }}"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                            placeholder="Contoh: 120 x 80 cm">

                    </div>

                    {{-- Bahan --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Bahan
                        </label>

                        <input
                            type="text"
                            name="bahan"
                            value="{{ old('bahan') }}"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                            placeholder="Contoh: Kayu Jati">

                    </div>

                    {{-- Motif --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Motif
                        </label>

                        <input
                            type="text"
                            name="motif"
                            value="{{ old('motif') }}"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                            placeholder="Masukkan motif ukiran">

                    </div>

                    {{-- Harga --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Estimasi Harga (Rp)
                        </label>

                        <input
                            type="number"
                            name="estimasi_harga"
                            value="{{ old('estimasi_harga') }}"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                            placeholder="5000000">

                    </div>

                </div>

                {{-- Deskripsi --}}
                <div class="mt-6">

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Deskripsi Produk
                    </label>

                    <textarea
                        name="deskripsi"
                        rows="5"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                        placeholder="Masukkan deskripsi produk">{{ old('deskripsi') }}</textarea>

                </div>

                {{-- Upload Gambar --}}
                <div class="mt-6">

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Gambar Produk
                    </label>

                    <input
                        type="file"
                        name="gambar"
                        accept="image/*"
                        class="w-full rounded-xl border border-gray-300 bg-gray-50 file:bg-amber-700 file:text-white file:border-0 file:px-4 file:py-2 file:mr-4 file:rounded-lg hover:file:bg-amber-800">

                    <p class="text-sm text-gray-500 mt-2">
                        Format: JPG, JPEG, atau PNG.
                    </p>

                </div>

            </div>

            {{-- Footer --}}
            <div class="bg-gray-50 border-t px-8 py-5 flex justify-end gap-3">

                <a
                    href="{{ route('products.index') }}"
                    class="px-5 py-3 rounded-xl bg-gray-200 text-gray-700 hover:bg-gray-300 transition">

                    Batal

                </a>

                <button
                    type="submit"
                    class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-amber-700 text-white hover:bg-amber-800 transition">

                    <span class="material-symbols-outlined">
                        save
                    </span>

                    Simpan Produk

                </button>

            </div>

        </div>

    </form>

</div>

@endsection
