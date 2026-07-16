@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="max-w-6xl mx-auto p-4 md:p-8 animate-fade-in">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8 pb-5 border-b border-gray-200">
        <div class="flex items-center gap-3">
            <a href="{{ route('orders.index') }}" class="p-2 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors" title="Kembali">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Detail Pesanan</h1>
                <p class="mt-1 text-sm text-gray-500">Informasi lengkap dan progres pesanan pelanggan.</p>
            </div>
        </div>

        <a href="{{ route('orders.edit', $order['id']) }}"
           class="inline-flex items-center justify-center rounded-xl bg-amber-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-amber-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-600 transition-all duration-200">
            <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
            </svg>
            Edit Pesanan
        </a>
    </div>

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

        {{-- Informasi Utama --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Detail Pesanan --}}
            <div class="rounded-2xl bg-white border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <h2 class="text-lg font-bold text-gray-800">Informasi Pesanan</h2>
                </div>

                <div class="p-6 divide-y divide-gray-100">
                    <div class="flex justify-between items-center py-3 first:pt-0">
                        <span class="text-sm font-medium text-gray-500">Kode Pesanan</span>
                        <span class="font-mono font-bold text-gray-900 bg-gray-100 px-2.5 py-1 rounded text-sm tracking-wider">
                            {{ $order['kode_pesanan'] ?? '-' }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center py-3">
                        <span class="text-sm font-medium text-gray-500">Tanggal Pesanan</span>
                        <span class="text-sm font-semibold text-gray-800">
                            {{ $order['tanggal_pesanan'] ?? '-' }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center py-3">
                        <span class="text-sm font-medium text-gray-500">Status</span>
                        @php $status = $order['status_pesanan'] ?? ''; @endphp

                        @if($status == 'menunggu_konfirmasi')
                            <span class="inline-flex items-center rounded-full bg-amber-50 px-3 py-1 text-xs font-bold text-amber-700 ring-1 ring-inset ring-amber-600/20">
                                Menunggu Konfirmasi
                            </span>
                        @elseif($status == 'diproses')
                            <span class="inline-flex items-center rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700 ring-1 ring-inset ring-blue-600/20">
                                Diproses
                            </span>
                        @elseif($status == 'selesai')
                            <span class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                Selesai
                            </span>
                        @elseif($status == 'dibatalkan')
                            <span class="inline-flex items-center rounded-full bg-rose-50 px-3 py-1 text-xs font-bold text-rose-700 ring-1 ring-inset ring-rose-600/10">
                                Dibatalkan
                            </span>
                        @else
                            <span class="inline-flex items-center rounded-full bg-gray-50 px-3 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
                                {{ ucfirst($status) }}
                            </span>
                        @endif
                    </div>

                    <div class="flex justify-between items-center py-3">
                        <span class="text-sm font-medium text-gray-500">Estimasi Biaya</span>
                        <span class="text-lg font-extrabold text-emerald-600">
                            Rp {{ number_format($order['estimasi_biaya'] ?? 0, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center py-3 last:pb-0">
                        <span class="text-sm font-medium text-gray-500">Estimasi Waktu</span>
                        <span class="text-sm font-semibold text-gray-800">
                            {{ $order['estimasi_waktu'] ?? '-' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Produk --}}
            <div class="rounded-2xl bg-white border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <h2 class="text-lg font-bold text-gray-800">Detail Produk</h2>
                </div>

                <div class="p-6 grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div class="space-y-1">
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Nama Produk</p>
                        <p class="text-base font-bold text-gray-900">{{ $order['product']['nama_product'] ?? '-' }}</p>
                    </div>

                    <div class="space-y-1">
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Jenis Ukiran</p>
                        <p class="text-base font-semibold text-gray-800">{{ $order['product']['jenis_ukiran'] ?? '-' }}</p>
                    </div>

                    <div class="space-y-1">
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Bahan Produk</p>
                        <p class="text-base font-semibold text-gray-800">{{ $order['product']['bahan'] ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Spesifikasi --}}
            @if(isset($order['specification']))
            <div class="rounded-2xl bg-white border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <h2 class="text-lg font-bold text-gray-800">Spesifikasi Kustom</h2>
                </div>

                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="rounded-xl border border-gray-100 bg-gray-50/50 p-4 flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-500">Ukuran</span>
                        <span class="text-sm font-bold text-gray-800">{{ $order['specification']['ukuran'] ?? '-' }}</span>
                    </div>

                    <div class="rounded-xl border border-gray-100 bg-gray-50/50 p-4 flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-500">Material</span>
                        <span class="text-sm font-bold text-gray-800">{{ $order['specification']['material'] ?? '-' }}</span>
                    </div>

                    <div class="rounded-xl border border-gray-100 bg-gray-50/50 p-4 flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-500">Motif</span>
                        <span class="text-sm font-bold text-gray-800">{{ $order['specification']['motif'] ?? '-' }}</span>
                    </div>

                    <div class="rounded-xl border border-gray-100 bg-gray-50/50 p-4 flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-500">Finishing</span>
                        <span class="text-sm font-bold text-gray-800">{{ $order['specification']['finishing'] ?? '-' }}</span>
                    </div>
                </div>
            </div>
            @endif

        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">

            {{-- Pelanggan --}}
            <div class="rounded-2xl bg-white border border-gray-200 shadow-sm p-6">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="p-2 bg-amber-50 text-amber-600 rounded-lg">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h2 class="text-lg font-bold text-gray-800">Data Pelanggan</h2>
                </div>
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                    <p class="font-bold text-gray-900 text-base">{{ $order['user']['nama'] ?? '-' }}</p>
                    <p class="mt-1 text-sm text-gray-500 font-medium">{{ $order['user']['email'] ?? '-' }}</p>
                </div>
            </div>

            {{-- Catatan --}}
            <div class="rounded-2xl bg-white border border-gray-200 shadow-sm p-6">
                <h2 class="mb-3 text-base font-bold text-gray-800 flex items-center gap-2">
                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Catatan Produksi
                </h2>
                <div class="text-sm text-gray-600 bg-amber-50/40 border border-amber-100/70 p-4 rounded-xl italic">
                    "{{ $order['catatan'] ?? 'Belum ada catatan khusus untuk pesanan ini.' }}"
                </div>
            </div>

            {{-- Riwayat Status --}}
            @if(isset($order['status_history']) && count($order['status_history']) > 0)
            <div class="rounded-2xl bg-white border border-gray-200 shadow-sm p-6">
                <h2 class="mb-5 text-base font-bold text-gray-800">Riwayat Status</h2>

                {{-- Mini Vertical Timeline --}}
                <div class="relative pl-4 border-l-2 border-gray-200 space-y-6 ml-2">
                    @foreach($order['status_history'] as $history)
                        <div class="relative">
                            {{-- Marker Dot --}}
                            <span class="absolute -left-[21px] top-1 bg-amber-500 h-2.5 w-2.5 rounded-full ring-4 ring-white"></span>

                            <p class="text-sm font-bold text-gray-800 leading-none">
                                {{ ucfirst(str_replace('_', ' ', $history['status'])) }}
                            </p>
                            @if(isset($history['keterangan']))
                                <p class="mt-1.5 text-xs text-gray-500 leading-relaxed">
                                    {{ $history['keterangan'] }}
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            @endif


        </div>

    </div>
</div>
@endsection
