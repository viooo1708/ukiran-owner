@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="max-w-6xl mx-auto space-y-8 animate-fade-in pb-12">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 border-b border-[#e5ddd8]">
        <div class="flex items-center gap-3">
            <a href="{{ route('orders.index') }}" class="p-2 rounded-xl text-gray-400 hover:text-[#5d4037] hover:bg-[#5d4037]/5 transition-colors" title="Kembali">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-[#3e2723] tracking-tight">Detail Pesanan</h1>
                <p class="mt-1 text-sm text-gray-500">Informasi lengkap dan progres pengerjaan pesanan pelanggan.</p>
            </div>
        </div>

        <a href="{{ route('orders.edit', $order['id']) }}"
           class="inline-flex items-center justify-center rounded-xl bg-[#5d4037] hover:bg-[#3e2723] px-5 py-3 text-sm font-bold text-white shadow-sm transition-colors">
            <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
            </svg>
            Edit Pesanan
        </a>
    </div>

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3 items-start">

        {{-- Informasi Utama --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Detail Pesanan --}}
            <div class="rounded-2xl bg-white border border-[#eadfd8] shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-[#e5ddd8] bg-[#faf8f5]">
                    <h2 class="text-base font-bold text-[#3e2723]">Informasi Pesanan</h2>
                </div>

                <div class="p-6 divide-y divide-gray-100 text-sm">
                    <div class="flex justify-between items-center py-3.5 first:pt-0">
                        <span class="font-medium text-gray-500">Kode Pesanan</span>
                        <span class="font-mono font-bold text-[#5d4037] bg-[#efebe9] px-2.5 py-1 rounded-lg border border-[#d7ccc8] tracking-wider">
                            {{ $order['kode_pesanan'] ?? '-' }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center py-3.5">
                        <span class="font-medium text-gray-500">Tanggal Pesanan</span>
                        <span class="font-bold text-gray-800">
                            {{ $order['tanggal_pesanan'] ?? '-' }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center py-3.5">
                        <span class="font-medium text-gray-500">Status</span>
                        @php
                            $status = strtolower($order['status_pesanan'] ?? '');
                            $badgeStyle = match(true) {
                                str_contains($status, 'selesai') => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                str_contains($status, 'proses')  => 'bg-blue-50 text-blue-700 border-blue-200',
                                str_contains($status, 'batal')   => 'bg-rose-50 text-rose-700 border-rose-200',
                                default => 'bg-amber-50 text-amber-700 border-amber-200',
                            };
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $badgeStyle }}">
                            {{ ucfirst(str_replace('_', ' ', $order['status_pesanan'] ?? 'menunggu')) }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center py-3.5">
                        <span class="font-medium text-gray-500">Estimasi Biaya</span>
                        <span class="text-base font-extrabold text-emerald-700">
                            Rp {{ number_format($order['estimasi_biaya'] ?? 0, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center py-3.5 last:pb-0">
                        <span class="font-medium text-gray-500">Estimasi Waktu</span>
                        <span class="font-semibold text-gray-800">
                            {{ $order['estimasi_waktu'] ?? '-' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Produk --}}
<div class="rounded-2xl bg-white border border-[#eadfd8] shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-[#e5ddd8] bg-[#faf8f5]">
        <h2 class="text-base font-bold text-[#3e2723]">Detail Produk</h2>
    </div>

    <div class="p-6 grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="space-y-1">
            <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400">Nama Produk</p>
            <p class="text-sm font-bold text-[#3e2723]">
                {{ $order['product']['nama_product'] ?? ($order['nama_custom'] ?? '-') }}
            </p>
        </div>

        <div class="space-y-1">
            <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400">Jenis Ukiran</p>
            <p class="text-sm font-semibold text-gray-800">
                {{ $order['product']['jenis_ukiran'] ?? ($order['specification']['motif_ukiran'] ?? '-') }}
            </p>
        </div>

        <div class="space-y-1">
            <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400">Bahan Produk</p>
            <p class="text-sm font-semibold text-gray-800">
                {{ $order['product']['bahan'] ?? ($order['specification']['material'] ?? '-') }}
            </p>
        </div>
    </div>
</div>

            {{-- Spesifikasi --}}
            @if(isset($order['specification']))
            <div class="rounded-2xl bg-white border border-[#eadfd8] shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-[#e5ddd8] bg-[#faf8f5]">
                    <h2 class="text-base font-bold text-[#3e2723]">Spesifikasi Kustom</h2>
                </div>

                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="rounded-xl border border-[#eadfd8] bg-[#faf8f5] p-4 flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-500">Ukuran</span>
                        <span class="text-sm font-bold text-gray-800">{{ $order['specification']['ukuran'] ?? '-' }}</span>
                    </div>

                    <div class="rounded-xl border border-[#eadfd8] bg-[#faf8f5] p-4 flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-500">Material</span>
                        <span class="text-sm font-bold text-gray-800">{{ $order['specification']['material'] ?? '-' }}</span>
                    </div>

                    <div class="rounded-xl border border-[#eadfd8] bg-[#faf8f5] p-4 flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-500">Motif</span>
                        <span class="text-sm font-bold text-gray-800">{{ $order['specification']['motif'] ?? '-' }}</span>
                    </div>
                </div>
            </div>
            @endif

        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">

            {{-- Pelanggan --}}
            <div class="rounded-2xl bg-white border border-[#eadfd8] shadow-sm p-6">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="p-2.5 bg-[#efebe9] text-[#5d4037] rounded-xl border border-[#d7ccc8]">
                        <span class="material-symbols-outlined text-xl">person</span>
                    </div>
                    <h2 class="text-base font-bold text-[#3e2723]">Data Pelanggan</h2>
                </div>
                <div class="bg-[#faf8f5] rounded-xl p-4 border border-[#eadfd8]">
                    <p class="font-bold text-gray-900 text-sm">{{ $order['user']['nama'] ?? '-' }}</p>
                    <p class="mt-1 text-xs text-gray-500 font-medium">{{ $order['user']['email'] ?? '-' }}</p>
                </div>
            </div>

            {{-- Catatan --}}
            <div class="rounded-2xl bg-white border border-[#eadfd8] shadow-sm p-6">
                <h2 class="mb-3 text-base font-bold text-[#3e2723] flex items-center gap-2">
                    <span class="material-symbols-outlined text-amber-700 text-lg">description</span>
                    Catatan Produksi
                </h2>
                <div class="text-sm text-gray-600 bg-amber-50/50 border border-amber-200/60 p-4 rounded-xl italic">
                    "{{ $order['catatan'] ?? 'Belum ada catatan khusus untuk pesanan ini.' }}"
                </div>
            </div>

            {{-- Riwayat Status --}}
            @if(isset($order['status_history']) && count($order['status_history']) > 0)
            <div class="rounded-2xl bg-white border border-[#eadfd8] shadow-sm p-6">
                <h2 class="mb-5 text-base font-bold text-[#3e2723]">Riwayat Status</h2>

                <div class="relative pl-4 border-l-2 border-amber-900/10 space-y-6 ml-2">
                    @foreach($order['status_history'] as $history)
                        <div class="relative">
                            <span class="absolute -left-[21px] top-1 bg-[#5d4037] h-2.5 w-2.5 rounded-full ring-4 ring-white"></span>

                            <p class="text-sm font-bold text-[#3e2723] leading-none">
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
