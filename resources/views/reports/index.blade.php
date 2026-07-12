@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
<div class="space-y-8">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-[#5d4037]">
                Laporan
            </h1>
            <p class="text-gray-500 mt-1">
                Ringkasan data pemesanan dan pendapatan.
            </p>
        </div>

        <form action="{{ route('reports.index') }}" method="GET" class="flex gap-3 mt-4 md:mt-0">

            <input
                type="date"
                name="tanggal_mulai"
                value="{{ request('tanggal_mulai') }}"
                class="rounded-lg border border-gray-300 px-4 py-2 focus:ring-[#8d6e63] focus:border-[#8d6e63]"
            >

            <input
                type="date"
                name="tanggal_selesai"
                value="{{ request('tanggal_selesai') }}"
                class="rounded-lg border border-gray-300 px-4 py-2 focus:ring-[#8d6e63] focus:border-[#8d6e63]"
            >

            <button
                class="bg-[#6d4c41] hover:bg-[#5d4037] text-white px-5 rounded-lg">
                Filter
            </button>

        </form>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-6">

        <div class="bg-white rounded-xl shadow p-6 border-l-4 border-[#6d4c41]">
            <p class="text-gray-500 text-sm">
                Total Pesanan
            </p>

            <h2 class="text-3xl font-bold text-[#5d4037] mt-2">
                {{ $summary['total_pesanan'] ?? 0 }}
            </h2>
        </div>

        <div class="bg-white rounded-xl shadow p-6 border-l-4 border-green-600">
            <p class="text-gray-500 text-sm">
                Pesanan Selesai
            </p>

            <h2 class="text-3xl font-bold text-green-600 mt-2">
                {{ $summary['total_selesai'] ?? 0 }}
            </h2>
        </div>

        <div class="bg-white rounded-xl shadow p-6 border-l-4 border-yellow-500">
            <p class="text-gray-500 text-sm">
                Sedang Diproses
            </p>

            <h2 class="text-3xl font-bold text-yellow-500 mt-2">
                {{ $summary['total_diproses'] ?? 0 }}
            </h2>
        </div>

        <div class="bg-white rounded-xl shadow p-6 border-l-4 border-red-500">
            <p class="text-gray-500 text-sm">
                Dibatalkan
            </p>

            <h2 class="text-3xl font-bold text-red-500 mt-2">
                {{ $summary['total_dibatalkan'] ?? 0 }}
            </h2>
        </div>

        <div class="bg-white rounded-xl shadow p-6 border-l-4 border-blue-600">
            <p class="text-gray-500 text-sm">
                Estimasi Pendapatan
            </p>

            <h2 class="text-2xl font-bold text-blue-600 mt-2">
                Rp {{ number_format($summary['total_pendapatan_estimasi'] ?? 0,0,',','.') }}
            </h2>
        </div>

    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <div class="px-6 py-4 border-b">
            <h2 class="text-lg font-semibold text-[#5d4037]">
                Data Laporan
            </h2>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-[#efebe9] text-[#5d4037]">

                <tr>

                    <th class="px-6 py-4 text-left">No</th>
                    <th class="px-6 py-4 text-left">Tanggal</th>
                    <th class="px-6 py-4 text-left">Pelanggan</th>
                    <th class="px-6 py-4 text-left">Produk</th>
                    <th class="px-6 py-4 text-left">Status</th>
                    <th class="px-6 py-4 text-right">Estimasi Biaya</th>

                </tr>

                </thead>

                <tbody>

                @forelse($orders as $order)

                    <tr class="border-b hover:bg-gray-50">

                        <td class="px-6 py-4">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-6 py-4">
                            {{ \Carbon\Carbon::parse($order['created_at'])->format('d M Y') }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $order['user']['nama'] ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $order['product']['nama_product'] ?? '-' }}
                        </td>

                        <td class="px-6 py-4">

                            @php
                                $status = $order['status_pesanan'];
                            @endphp

                            @if($status=='selesai')

                                <span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-700">
                                    Selesai
                                </span>

                            @elseif($status=='diproses')

                                <span class="px-3 py-1 rounded-full text-xs bg-yellow-100 text-yellow-700">
                                    Diproses
                                </span>

                            @elseif($status=='dibatalkan')

                                <span class="px-3 py-1 rounded-full text-xs bg-red-100 text-red-700">
                                    Dibatalkan
                                </span>

                            @else

                                <span class="px-3 py-1 rounded-full text-xs bg-blue-100 text-blue-700">
                                    Menunggu
                                </span>

                            @endif

                        </td>

                        <td class="px-6 py-4 text-right font-semibold">

                            Rp {{ number_format($order['estimasi_biaya'],0,',','.') }}

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6" class="text-center py-12 text-gray-500">

                            Belum ada data laporan.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>
@endsection
