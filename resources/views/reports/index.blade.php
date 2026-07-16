@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
<div class="max-w-[1600px] mx-auto space-y-8 animate-fade-in">

    {{-- Header --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#3e2723] tracking-tight">
                Laporan Eksekutif
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Ringkasan komprehensif data pemesanan, status pengerjaan, dan estimasi arus pendapatan.
            </p>
        </div>

        <form action="{{ route('reports.index') }}" method="GET" class="flex flex-wrap items-center gap-3 bg-white p-3 rounded-xl border border-[#eadfd8] shadow-sm w-full lg:w-auto">
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <input
                    type="date"
                    name="tanggal_mulai"
                    value="{{ $tanggal_mulai ?? request('tanggal_mulai') }}"
                    class="w-full sm:w-auto rounded-lg border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#5d4037]/20 focus:border-[#5d4037]"
                >
                <span class="text-gray-400 text-xs font-bold uppercase">s/d</span>
                <input
                    type="date"
                    name="tanggal_selesai"
                    value="{{ $tanggal_selesai ?? request('tanggal_selesai') }}"
                    class="w-full sm:w-auto rounded-lg border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#5d4037]/20 focus:border-[#5d4037]"
                >
            </div>

            <button type="submit" class="w-full sm:w-auto bg-[#5d4037] hover:bg-[#3e2723] text-white px-5 py-2 rounded-lg text-sm font-medium flex items-center justify-center gap-2 transition-colors">
                <span class="material-symbols-outlined text-sm">filter_alt</span>
                Filter Data
            </button>
        </form>
    </div>

    {{-- Cards Grid Statistik (Diselaraskan dengan Dashboard) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-5">
        @php
            $cards = [
                [
                    'title' => 'Total Pesanan',
                    'value' => $ringkasan['total_pesanan'] ?? 0,
                    'icon'  => 'shopping_bag',
                    'bg'    => 'bg-amber-50 text-amber-800'
                ],
                [
                    'title' => 'Diproses',
                    'value' => $ringkasan['total_diproses'] ?? 0,
                    'icon'  => 'precision_manufacturing',
                    'bg'    => 'bg-blue-50 text-blue-800'
                ],
                [
                    'title' => 'Selesai',
                    'value' => $ringkasan['total_selesai'] ?? 0,
                    'icon'  => 'task_alt',
                    'bg'    => 'bg-emerald-50 text-emerald-800'
                ],
                [
                    'title' => 'Dibatalkan',
                    'value' => $ringkasan['total_dibatalkan'] ?? 0,
                    'icon'  => 'cancel',
                    'bg'    => 'bg-rose-50 text-rose-800'
                ],
                [
                    'title' => 'Estimasi Pendapatan',
                    'value' => 'Rp ' . number_format($ringkasan['total_pendapatan_estimasi'] ?? 0, 0, ',', '.'),
                    'icon'  => 'payments',
                    'bg'    => 'bg-[#efebe9] text-[#5d4037]'
                ]
            ];
        @endphp

        @foreach($cards as $card)
        <div class="bg-white border border-[#eadfd8] rounded-2xl p-5 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex flex-col justify-between">
            <div class="flex items-start justify-between gap-3">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    {{ $card['title'] }}
                </p>
                <div class="w-10 h-10 rounded-xl {{ $card['bg'] }} flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-xl">
                        {{ $card['icon'] }}
                    </span>
                </div>
            </div>
            <div class="mt-4">
                <h2 class="text-2xl xl:text-3xl font-extrabold text-[#3e2723] tracking-tight truncate">
                    {{ $card['value'] }}
                </h2>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Main Table Area --}}
    <div class="bg-white rounded-2xl border border-[#eadfd8] shadow-sm overflow-hidden">

        <div class="p-6 border-b border-[#e5ddd8] bg-[#faf8f5]">
            <h2 class="text-lg font-bold text-[#3e2723]">
                Detail Log Pemesanan
            </h2>
            <p class="text-xs text-gray-400 mt-0.5">
                Menampilkan data pesanan masuk berdasarkan rentang waktu filter aktif.
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-[#faf7f4] text-gray-500 text-xs font-semibold uppercase tracking-wider border-b border-gray-100">
                        <th class="py-4 px-6 w-16 text-center">ID</th>
                        <th class="py-4 px-6 w-36">Tanggal Masuk</th>
                        <th class="py-4 px-6">Nama Pelanggan</th>
                        <th class="py-4 px-6">Produk / Karya Ukir</th>
                        <th class="py-4 px-6 text-center w-36">Status</th>
                        <th class="py-4 px-6 text-right w-44">Estimasi Biaya</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse($orders as $order)
                        <tr class="hover:bg-[#faf7f4]/60 transition-colors duration-150">
                            <td class="py-4 px-6 text-center font-bold text-[#5d4037]">
                                #{{ $order['id'] }}
                            </td>

                            <td class="py-4 px-6 font-medium text-gray-600">
                                {{ isset($order['created_at']) ? \Carbon\Carbon::parse($order['created_at'])->format('d M Y') : '-' }}
                            </td>

                            <td class="py-4 px-6 font-medium text-gray-800">
                                {{ $order['user']['nama'] ?? '-' }}
                            </td>

                            <td class="py-4 px-6 text-gray-600">
                                {{ $order['product']['nama_product'] ?? '-' }}
                            </td>

                            <td class="py-4 px-6 text-center">
                                @php
                                    $status = strtolower($order['status_pesanan'] ?? '');
                                    $badgeStyle = match(true) {
                                        str_contains($status, 'selesai') => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        str_contains($status, 'proses')  => 'bg-blue-50 text-blue-700 border-blue-200',
                                        str_contains($status, 'batal')   => 'bg-rose-50 text-rose-700 border-rose-200',
                                        default => 'bg-amber-50 text-amber-700 border-amber-200',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $badgeStyle }}">
                                    {{ ucfirst(str_replace('_', ' ', $order['status_pesanan'] ?? 'menunggu')) }}
                                </span>
                            </td>

                            <td class="py-4 px-6 text-right font-bold text-[#5d4037]">
                                Rp {{ number_format($order['estimasi_biaya'] ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-20 text-gray-400">
                                <span class="material-symbols-outlined text-4xl block mb-2 text-gray-300">inbox</span>
                                <p class="font-medium text-sm">Tidak ada rekaman transaksi ditemukan</p>
                                <p class="text-xs text-gray-400 mt-1">Coba sesuaikan kembali filter tanggal pengerjaan di atas.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
