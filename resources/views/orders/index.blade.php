@extends('layouts.app')

@section('title', 'Pesanan')

@section('content')

<div class="max-w-7xl mx-auto p-8">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Data Pesanan
            </h1>

            <p class="mt-2 text-gray-500">
                Kelola seluruh data pesanan pelanggan.
            </p>
        </div>

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

    <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow">

        {{-- Header Card --}}
        <div class="flex flex-col gap-4 border-b p-6 md:flex-row md:items-center md:justify-between">

            <div>
                <h2 class="text-xl font-bold text-gray-800">
                    Daftar Pesanan
                </h2>

                <p class="text-sm text-gray-500">
                    Total {{ is_array($orders) ? count($orders) : 0 }} Pesanan
                </p>
            </div>

            <div class="relative">

                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                    search
                </span>

                <input
                    type="text"
                    id="searchOrder"
                    placeholder="Cari pesanan..."
                    class="w-72 rounded-xl border border-gray-200 bg-gray-50 py-2 pl-10 pr-4 focus:border-amber-500 focus:ring-amber-500">

            </div>

        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">

            <table class="w-full" id="orderTable">

                <thead class="bg-gray-50">

                    <tr>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">
                            ID
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">
                            Pelanggan
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">
                            Produk
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">
                            Estimasi Biaya
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">
                            Status
                        </th>

                        <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($orders as $order)

                    <tr class="border-b hover:bg-gray-50">

                        <td class="px-6 py-5 font-semibold text-gray-700">
                            #{{ $order['id'] }}
                        </td>

                        <td class="px-6 py-5">

                            <div>

                                <p class="font-semibold text-gray-800">
                                    {{ $order['user']['nama'] ?? '-' }}
                                </p>

                                <p class="text-sm text-gray-500">
                                    {{ $order['user']['email'] ?? '' }}
                                </p>

                            </div>

                        </td>

                        <td class="px-6 py-5">

                            <p class="font-medium">
                                {{ $order['product']['nama_product'] ?? '-' }}
                            </p>

                        </td>

                        <td class="px-6 py-5">

                            <span class="rounded-full bg-green-100 px-4 py-2 font-semibold text-green-700">

                                Rp {{ number_format($order['estimasi_biaya'] ?? 0,0,',','.') }}

                            </span>

                        </td>

                        <td class="px-6 py-5">

                            @php

                                $status = strtolower($order['status_pesanan'] ?? '');

                            @endphp

                            @if($status == 'menunggu_konfirmasi')

                                <span class="rounded-full bg-yellow-100 px-3 py-1 text-sm font-semibold text-yellow-700">
                                    Menunggu
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
                                    {{ $order['status_pesanan'] }}
                                </span>

                            @endif

                        </td>

                        <td class="px-6 py-5">

                            <div class="flex justify-center gap-2">

                                <a
                                    href="{{ route('orders.show',$order['id']) }}"
                                    class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-100 text-amber-700 hover:bg-amber-200">

                                    <span class="material-symbols-outlined">
                                        visibility
                                    </span>

                                </a>

                                <a
                                    href="{{ route('orders.edit',$order['id']) }}"
                                    class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200">

                                    <span class="material-symbols-outlined">
                                        edit
                                    </span>

                                </a>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="6" class="py-10 text-center text-gray-500">

                            Belum ada pesanan.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

<script>

const search = document.getElementById('searchOrder');

if(search){

    search.addEventListener('keyup', function(){

        const value = this.value.toLowerCase();

        document.querySelectorAll('#orderTable tbody tr').forEach(row=>{

            row.style.display = row.innerText.toLowerCase().includes(value)
                ? ''
                : 'none';

        });

    });

}

</script>

@endsection
