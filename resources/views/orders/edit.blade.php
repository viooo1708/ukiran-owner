@extends('layouts.app')

@section('title', 'Edit Pesanan')

@section('content')

<div class="max-w-5xl mx-auto p-8">

    {{-- Header --}}
    <div class="mb-8">

        <h1 class="text-3xl font-bold text-gray-800">
            Update Status Pesanan
        </h1>

        <p class="mt-2 text-gray-500">
            Kelola proses produksi pesanan pelanggan.
        </p>

    </div>


    {{-- Alert --}}
    @if(session('success'))
        <div class="mb-5 rounded-xl bg-green-100 px-5 py-4 text-green-700">
            {{ session('success') }}
        </div>
    @endif


    @if(session('error'))
        <div class="mb-5 rounded-xl bg-red-100 px-5 py-4 text-red-700">
            {{ session('error') }}
        </div>
    @endif



    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">


        {{-- Detail Pesanan --}}
        <div class="lg:col-span-2 rounded-2xl bg-white border border-gray-100 shadow p-6">


            <h2 class="text-xl font-bold text-gray-800 mb-5">
                Detail Pesanan
            </h2>


            <div class="space-y-5">


                <div class="flex justify-between border-b pb-3">

                    <span class="text-gray-500">
                        ID Pesanan
                    </span>

                    <span class="font-semibold">
                        #{{ $order['id'] }}
                    </span>

                </div>



                <div class="flex justify-between border-b pb-3">

                    <span class="text-gray-500">
                        Pelanggan
                    </span>

                    <span class="font-semibold">
                        {{ $order['user']['nama'] ?? '-' }}
                    </span>

                </div>



                <div class="flex justify-between border-b pb-3">

                    <span class="text-gray-500">
                        Email
                    </span>

                    <span>
                        {{ $order['user']['email'] ?? '-' }}
                    </span>

                </div>



                <div class="flex justify-between border-b pb-3">

                    <span class="text-gray-500">
                        Produk
                    </span>

                    <span class="font-semibold">
                        {{ $order['product']['nama_product'] ?? '-' }}
                    </span>

                </div>



                <div class="flex justify-between border-b pb-3">

                    <span class="text-gray-500">
                        Estimasi Biaya
                    </span>

                    <span class="font-semibold text-green-700">

                        Rp {{ number_format($order['estimasi_biaya'] ?? 0,0,',','.') }}

                    </span>

                </div>



                {{-- Spesifikasi --}}
                @if(isset($order['specification']))

                <div class="mt-5">

                    <h3 class="font-semibold text-gray-800 mb-3">
                        Spesifikasi Produk
                    </h3>


                    <div class="grid grid-cols-2 gap-4">


                        <div class="rounded-xl bg-gray-50 p-4">

                            <p class="text-sm text-gray-500">
                                Ukuran
                            </p>

                            <p class="font-semibold">
                                {{ $order['specification']['ukuran'] ?? '-' }}
                            </p>

                        </div>



                        <div class="rounded-xl bg-gray-50 p-4">

                            <p class="text-sm text-gray-500">
                                Material
                            </p>

                            <p class="font-semibold">
                                {{ $order['specification']['material'] ?? '-' }}
                            </p>

                        </div>



                        <div class="rounded-xl bg-gray-50 p-4">

                            <p class="text-sm text-gray-500">
                                Finishing
                            </p>

                            <p class="font-semibold">
                                {{ $order['specification']['finishing'] ?? '-' }}
                            </p>

                        </div>



                        <div class="rounded-xl bg-gray-50 p-4">

                            <p class="text-sm text-gray-500">
                                Catatan
                            </p>

                            <p class="font-semibold">
                                {{ $order['specification']['catatan'] ?? '-' }}
                            </p>

                        </div>


                    </div>

                </div>

                @endif


            </div>


        </div>




        {{-- Form Update --}}
<div class="rounded-2xl bg-white border border-gray-100 shadow p-6">

    <h2 class="text-xl font-bold text-gray-800 mb-5">
        Update Pesanan
    </h2>


    <form action="{{ route('orders.update',$order['id']) }}"
          method="POST">

        @csrf
        @method('PUT')


        {{-- Estimasi Biaya --}}
        <div class="mb-5">

            <label class="mb-2 block text-sm font-semibold text-gray-700">
                Estimasi Biaya
            </label>


            <div class="relative">

                <span class="absolute left-4 top-3 text-gray-500">
                    Rp
                </span>


                <input
                    type="number"
                    name="estimasi_biaya"
                    value="{{ old('estimasi_biaya',$order['estimasi_biaya'] ?? '') }}"
                    class="w-full rounded-xl border-gray-200 pl-12 focus:border-amber-500 focus:ring-amber-500"
                    placeholder="Masukkan estimasi biaya">


            </div>


        </div>



        {{-- Estimasi Waktu --}}
        <div class="mb-5">

            <label class="mb-2 block text-sm font-semibold text-gray-700">
                Estimasi Waktu Produksi
            </label>


            <input
                type="text"
                name="estimasi_waktu"
                value="{{ old('estimasi_waktu',$order['estimasi_waktu'] ?? '') }}"
                class="w-full rounded-xl border-gray-200 focus:border-amber-500 focus:ring-amber-500"
                placeholder="Contoh: 7-14 hari kerja">


        </div>




        {{-- Status Pesanan --}}
        <div class="mb-5">

            <label class="mb-2 block text-sm font-semibold text-gray-700">
                Status Pesanan
            </label>


            <select
                name="status_pesanan"
                class="w-full rounded-xl border-gray-200 focus:border-amber-500 focus:ring-amber-500">


                <option value="menunggu_konfirmasi"
                {{ ($order['status_pesanan'] ?? '') == 'menunggu_konfirmasi' ? 'selected':'' }}>

                    Menunggu Konfirmasi

                </option>


                <option value="diproses"
                {{ ($order['status_pesanan'] ?? '') == 'diproses' ? 'selected':'' }}>

                    Diproses

                </option>


                <option value="selesai"
                {{ ($order['status_pesanan'] ?? '') == 'selesai' ? 'selected':'' }}>

                    Selesai

                </option>


                <option value="dibatalkan"
                {{ ($order['status_pesanan'] ?? '') == 'dibatalkan' ? 'selected':'' }}>

                    Dibatalkan

                </option>


            </select>

        </div>




        {{-- Catatan Produksi --}}
        <div class="mb-5">

            <label class="mb-2 block text-sm font-semibold text-gray-700">
                Catatan Produksi
            </label>


            <textarea
                name="catatan"
                rows="5"
                class="w-full rounded-xl border-gray-200 focus:border-amber-500 focus:ring-amber-500"
                placeholder="Masukkan catatan produksi...">{{ old('catatan',$order['catatan'] ?? '') }}</textarea>


        </div>




        <button
            type="submit"
            class="w-full rounded-xl bg-amber-600 px-5 py-3 font-semibold text-white hover:bg-amber-700">

            Simpan Perubahan

        </button>



        <a
            href="{{ route('orders.index') }}"
            class="mt-3 block w-full rounded-xl bg-gray-100 px-5 py-3 text-center font-semibold text-gray-700 hover:bg-gray-200">

            Kembali

        </a>


    </form>

</div>

@endsection
