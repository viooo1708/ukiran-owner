@extends('layouts.app')

@section('title','Detail Produk')

@section('content')

<div class="max-w-6xl mx-auto p-8">

    <div class="mb-8 flex items-center justify-between">

        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                Detail Produk
            </h1>

            <p class="text-gray-500 mt-2">
                Informasi lengkap mengenai produk ukiran.
            </p>

        </div>

        <a
            href="{{ route('products.index') }}"
            class="px-5 py-3 bg-gray-100 rounded-xl hover:bg-gray-200">

            Kembali

        </a>

    </div>

    <div class="bg-white rounded-2xl shadow-md overflow-hidden">

        <div class="grid grid-cols-1 lg:grid-cols-2">

            <div class="p-8">

                @if($product['gambar'])

                    <img
                        src="{{ $product['gambar'] }}"
                        class="w-full h-[500px] rounded-xl object-cover">

                @else

                    <div class="w-full h-[500px] rounded-xl bg-gray-100 flex items-center justify-center">

                        <span class="material-symbols-outlined text-8xl text-gray-400">

                            image

                        </span>

                    </div>

                @endif

            </div>

            <div class="p-8">

                <h2 class="text-3xl font-bold text-gray-800">

                    {{ $product['nama_product'] }}

                </h2>

                <div class="mt-6 space-y-5">

                    <div>

                        <p class="text-gray-500 text-sm">

                            Jenis Ukiran

                        </p>

                        <p class="font-semibold">

                            {{ $product['jenis_ukiran'] }}

                        </p>

                    </div>

                    <div>

                        <p class="text-gray-500 text-sm">

                            Bahan

                        </p>

                        <p class="font-semibold">

                            {{ $product['bahan'] }}

                        </p>

                    </div>

                    <div>

                        <p class="text-gray-500 text-sm">

                            Ukuran

                        </p>

                        <p>

                            {{ $product['ukuran'] }}

                        </p>

                    </div>

                    <div>

                        <p class="text-gray-500 text-sm">

                            Motif

                        </p>

                        <p>

                            {{ $product['motif'] }}

                        </p>

                    </div>

                    <div>

                        <p class="text-gray-500 text-sm">

                            Estimasi Harga

                        </p>

                        <p class="text-3xl font-bold text-green-600">

                            Rp {{ number_format($product['estimasi_harga'],0,',','.') }}

                        </p>

                    </div>

                    <div>

                        <p class="text-gray-500 text-sm">

                            Deskripsi

                        </p>

                        <p class="leading-7 text-gray-700">

                            {{ $product['deskripsi'] }}

                        </p>

                    </div>

                </div>

                <div class="mt-10 flex gap-3">

                    <a
                        href="{{ route('products.edit',$product['id']) }}"
                        class="px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700">

                        Edit Produk

                    </a>

                    <form
                        action="{{ route('products.destroy',$product['id']) }}"
                        method="POST">

                        @csrf
                        @method('DELETE')

                        <button
                            onclick="return confirm('Hapus produk ini?')"
                            class="px-6 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700">

                            Hapus

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
