@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')

<div class="max-w-6xl mx-auto p-8">


    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">

        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                Detail Pesanan
            </h1>

            <p class="mt-2 text-gray-500">
                Informasi lengkap pesanan pelanggan.
            </p>

        </div>


        <a href="{{ route('orders.edit',$order['id']) }}"
           class="mt-4 md:mt-0 rounded-xl bg-amber-600 px-5 py-3 font-semibold text-white hover:bg-amber-700">

            Edit Pesanan

        </a>

    </div>



    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">


        {{-- Informasi Utama --}}
        <div class="lg:col-span-2 space-y-6">


            {{-- Detail Pesanan --}}
            <div class="rounded-2xl bg-white border border-gray-100 shadow p-6">


                <h2 class="mb-5 text-xl font-bold text-gray-800">
                    Informasi Pesanan
                </h2>



                <div class="space-y-4">


                    <div class="flex justify-between border-b pb-3">

                        <span class="text-gray-500">
                            Kode Pesanan
                        </span>

                        <span class="font-semibold">
                            {{ $order['kode_pesanan'] ?? '-' }}
                        </span>

                    </div>



                    <div class="flex justify-between border-b pb-3">

                        <span class="text-gray-500">
                            Tanggal Pesanan
                        </span>

                        <span>
                            {{ $order['tanggal_pesanan'] ?? '-' }}
                        </span>

                    </div>



                    <div class="flex justify-between border-b pb-3">

                        <span class="text-gray-500">
                            Status
                        </span>


                        @php
                            $status = $order['status_pesanan'] ?? '';
                        @endphp


                        @if($status == 'menunggu_konfirmasi')

                            <span class="rounded-full bg-yellow-100 px-3 py-1 text-sm font-semibold text-yellow-700">
                                Menunggu Konfirmasi
                            </span>


                        @elseif($status == 'diproses')

                            <span class="rounded-full bg-blue-100 px-3 py-1 text-sm font-semibold text-blue-700">
                                Diproses
                            </span>


                        @elseif($status == 'selesai')

                            <span class="rounded-full bg-green-100 px-3 py-1 text-sm font-semibold text-green-700">
                                Selesai
                            </span>


                        @elseif($status == 'dibatalkan')

                            <span class="rounded-full bg-red-100 px-3 py-1 text-sm font-semibold text-red-700">
                                Dibatalkan
                            </span>


                        @else

                            <span class="rounded-full bg-gray-100 px-3 py-1 text-sm">
                                {{ $status }}
                            </span>

                        @endif


                    </div>



                    <div class="flex justify-between border-b pb-3">

                        <span class="text-gray-500">
                            Estimasi Biaya
                        </span>

                        <span class="font-bold text-green-700">

                            Rp {{ number_format($order['estimasi_biaya'] ?? 0,0,',','.') }}

                        </span>

                    </div>



                    <div class="flex justify-between">

                        <span class="text-gray-500">
                            Estimasi Waktu
                        </span>

                        <span class="font-semibold">
                            {{ $order['estimasi_waktu'] ?? '-' }}
                        </span>

                    </div>


                </div>


            </div>





            {{-- Produk --}}
            <div class="rounded-2xl bg-white border border-gray-100 shadow p-6">


                <h2 class="mb-5 text-xl font-bold text-gray-800">
                    Produk
                </h2>



                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">


                    <div>

                        <p class="text-sm text-gray-500">
                            Nama Produk
                        </p>

                        <p class="font-semibold">
                            {{ $order['product']['nama_product'] ?? '-' }}
                        </p>

                    </div>



                    <div>

                        <p class="text-sm text-gray-500">
                            Jenis Ukiran
                        </p>

                        <p class="font-semibold">
                            {{ $order['product']['jenis_ukiran'] ?? '-' }}
                        </p>

                    </div>



                    <div>

                        <p class="text-sm text-gray-500">
                            Bahan Produk
                        </p>

                        <p class="font-semibold">
                            {{ $order['product']['bahan'] ?? '-' }}
                        </p>

                    </div>


                </div>


            </div>





            {{-- Spesifikasi --}}
            @if(isset($order['specification']))

            <div class="rounded-2xl bg-white border border-gray-100 shadow p-6">


                <h2 class="mb-5 text-xl font-bold text-gray-800">
                    Spesifikasi Pesanan
                </h2>



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
                            Motif
                        </p>

                        <p class="font-semibold">
                            {{ $order['specification']['motif'] ?? '-' }}
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


                </div>


            </div>

            @endif



        </div>





        {{-- Sidebar --}}
        <div class="space-y-6">



            {{-- Pelanggan --}}
            <div class="rounded-2xl bg-white border border-gray-100 shadow p-6">


                <h2 class="mb-5 text-xl font-bold text-gray-800">
                    Data Pelanggan
                </h2>


                <p class="font-semibold">
                    {{ $order['user']['nama'] ?? '-' }}
                </p>


                <p class="mt-1 text-sm text-gray-500">
                    {{ $order['user']['email'] ?? '-' }}
                </p>


            </div>





            {{-- Catatan --}}
            <div class="rounded-2xl bg-white border border-gray-100 shadow p-6">


                <h2 class="mb-3 text-xl font-bold text-gray-800">
                    Catatan Produksi
                </h2>


                <p class="text-gray-600">

                    {{ $order['catatan'] ?? 'Belum ada catatan.' }}

                </p>


            </div>




            {{-- Riwayat Status --}}
            @if(isset($order['status_history']))

            <div class="rounded-2xl bg-white border border-gray-100 shadow p-6">


                <h2 class="mb-4 text-xl font-bold text-gray-800">
                    Riwayat Status
                </h2>


                <div class="space-y-4">


                @foreach($order['status_history'] as $history)

                    <div class="border-l-4 border-amber-500 pl-4">

                        <p class="font-semibold">
                            {{ ucfirst($history['status']) }}
                        </p>

                        <p class="text-sm text-gray-500">
                            {{ $history['keterangan'] ?? '-' }}
                        </p>

                    </div>

                @endforeach


                </div>


            </div>

            @endif



        </div>


    </div>


</div>

@endsection
