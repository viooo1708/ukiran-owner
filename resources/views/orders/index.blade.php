@extends('layouts.app')

@section('title', 'Pesanan')

@section('content')
<div class="max-w-7xl mx-auto p-4 md:p-8 animate-fade-in">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-black text-gray-900 tracking-tight">Data Pesanan</h1>
            <p class="mt-1 text-sm text-gray-500">Kelola dan pantau seluruh data pesanan pelanggan Anda.</p>
        </div>
    </div>

    {{-- Card Main Container --}}
    <div class="overflow-hidden rounded-2xl border border-gray-200/80 bg-white shadow-sm ring-1 ring-black/5">

        {{-- Header Card --}}
        <div class="flex flex-col gap-4 border-b border-gray-100 p-6 sm:flex-row sm:items-center sm:justify-between bg-gray-50/40">
            <div>
                <h2 class="text-lg font-bold text-gray-900">Daftar Pesanan</h2>
                <p class="text-xs font-semibold text-gray-500 mt-0.5">
                    Total <span class="text-amber-600 font-bold bg-amber-50 px-2 py-0.5 rounded-md ring-1 ring-amber-600/10">{{ is_array($orders) ? count($orders) : 0 }}</span> Pesanan
                </p>
            </div>

            <div class="relative w-full sm:w-80">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input
                    type="text"
                    id="searchOrder"
                    placeholder="Cari nama, produk, atau kode..."
                    class="w-full rounded-xl border border-gray-200 bg-white py-2.5 pl-10 pr-4 text-xs font-medium text-gray-900 placeholder-gray-400 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/10 focus:outline-none shadow-sm transition-all">
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left" id="orderTable">
                <thead class="bg-gray-50/70 border-b border-gray-200/60">
                    <tr>
                        <th class="px-6 py-3.5 text-xs font-bold uppercase tracking-wider text-gray-500">ID</th>
                        <th class="px-6 py-3.5 text-xs font-bold uppercase tracking-wider text-gray-500">Pelanggan</th>
                        <th class="px-6 py-3.5 text-xs font-bold uppercase tracking-wider text-gray-500">Produk</th>
                        <th class="px-6 py-3.5 text-xs font-bold uppercase tracking-wider text-gray-500">Estimasi Biaya</th>
                        <th class="px-6 py-3.5 text-xs font-bold uppercase tracking-wider text-gray-500">Tahap Produksi</th>
                        <th class="px-6 py-3.5 text-xs font-bold uppercase tracking-wider text-gray-500">Status Transaksi</th>
                        <th class="px-6 py-3.5 text-center text-xs font-bold uppercase tracking-wider text-gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 font-mono text-xs font-bold text-gray-600">
                            #{{ $order['id'] }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="max-w-xs truncate">
                                <p class="font-bold text-sm text-gray-900">{{ $order['user']['nama'] ?? '-' }}</p>
                                <p class="text-xs text-gray-400 font-medium mt-0.5">{{ $order['user']['email'] ?? '' }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-semibold text-gray-800">
                                {{ $order['product']['nama_product'] ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-lg bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-700 ring-1 ring-inset ring-emerald-600/10">
                                Rp {{ number_format($order['estimasi_biaya'] ?? 0, 0, ',', '.') }}
                            </span>
                        </td>

                        <td class="px-6 py-4">
                            @php
                                $statusPesanan = strtolower($order['status_pesanan'] ?? '');
                                $currentTahap = strtolower($order['latest_status']['status'] ?? 'persiapan');
                            @endphp

                            {{-- Menunggu Konfirmasi --}}
                            @if($statusPesanan == 'menunggu_konfirmasi')

                                <span class="inline-flex items-center rounded-md bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600">
                                    ⏳ Belum Diproses
                                </span>

                            {{-- Dibatalkan --}}
                            @elseif($statusPesanan == 'dibatalkan')

                                <span class="inline-flex items-center rounded-md bg-red-100 px-2.5 py-1 text-xs font-semibold text-red-700">
                                    ❌ Dibatalkan
                                </span>

                            {{-- Pesanan Selesai --}}
                            @elseif($statusPesanan == 'selesai')

                                <span class="inline-flex items-center rounded-md bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                    ✅ Selesai
                                </span>

                            {{-- Sedang Diproses --}}
                            @elseif($statusPesanan == 'diproses')

                                @if($currentTahap == 'persiapan')
                                    <span class="inline-flex items-center rounded-md bg-gray-50 px-2.5 py-1 text-xs font-bold text-gray-700">
                                        📦 Persiapan
                                    </span>

                                @elseif($currentTahap == 'pengukiran')
                                    <span class="inline-flex items-center rounded-md bg-amber-50 px-2.5 py-1 text-xs font-bold text-amber-700">
                                        🔨 Pengukiran
                                    </span>

                                @elseif($currentTahap == 'finishing')
                                    <span class="inline-flex items-center rounded-md bg-purple-50 px-2.5 py-1 text-xs font-bold text-purple-700">
                                        ✨ Finishing
                                    </span>

                                @elseif($currentTahap == 'selesai')
                                    <span class="inline-flex items-center rounded-md bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-700">
                                        ✅ Selesai
                                    </span>

                                @else
                                    <span class="inline-flex items-center rounded-md bg-gray-50 px-2.5 py-1 text-xs font-semibold text-gray-600">
                                        📦 Persiapan
                                    </span>
                                @endif

                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @php $status = strtolower($order['status_pesanan'] ?? ''); @endphp

                            @if($status == 'menunggu_konfirmasi')
                                <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-1 text-xs font-bold text-amber-700 ring-1 ring-inset ring-amber-600/20">
                                    Menunggu
                                </span>
                            @elseif($status == 'diproses')
                                <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-1 text-xs font-bold text-blue-700 ring-1 ring-inset ring-blue-600/20">
                                    Diproses
                                </span>
                            @elseif($status == 'selesai')
                                <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                    Selesai
                                </span>
                            @elseif($status == 'dibatalkan')
                                <span class="inline-flex items-center rounded-full bg-rose-50 px-2.5 py-1 text-xs font-bold text-rose-700 ring-1 ring-inset ring-rose-600/10">
                                    Dibatalkan
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-gray-50 px-2.5 py-1 text-xs font-semibold text-gray-600 ring-1 ring-inset ring-gray-500/10">
                                    {{ $order['status_pesanan'] }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center items-center gap-2">
                                <a href="{{ route('orders.show', $order['id']) }}"
                                   class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200/40 transition-colors shadow-sm"
                                   title="Lihat Detail">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>

                                <a href="{{ route('orders.edit', $order['id']) }}"
                                   class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 border border-blue-200/40 transition-colors shadow-sm"
                                   title="Edit Pesanan">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr id="emptyRow">
                        <td colspan="7" class="py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="h-10 w-10 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m16.5 0a2.25 2.25 0 00-2.25-2.25H6.75A2.25 2.25 0 004.5 7.5m16.5 0V4.5a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25V7.5m10.5-6v2.25m-3-2.25v2.25m-3-2.25v2.25" />
                                </svg>
                                <span class="text-sm font-semibold text-gray-400">Belum ada data pesanan yang tersedia.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const search = document.getElementById('searchOrder');
    if (search) {
        search.addEventListener('input', function () {
            const value = this.value.toLowerCase().trim();
            const rows = document.querySelectorAll('#orderTable tbody tr:not(#emptyRow)');
            let hasVisibleRow = false;

            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                if (text.includes(value)) {
                    row.style.display = '';
                    hasVisibleRow = true;
                } else {
                    row.style.display = 'none';
                }
            });

            const emptyRow = document.getElementById('emptyRow');
            if (emptyRow) {
                if (!hasVisibleRow && value !== '') {
                    emptyRow.style.display = '';
                    emptyRow.querySelector('span').innerText = 'Tidak ada pesanan yang cocok dengan pencarian Anda.';
                } else if (value === '' && rows.length === 0) {
                    emptyRow.style.display = '';
                    emptyRow.querySelector('span').innerText = 'Belum ada data pesanan yang tersedia.';
                } else {
                    emptyRow.style.display = 'none';
                }
            }
        });
    }
});
</script>

<script type="module">
    // Pastikan ID user atau channel yang digunakan sesuai
    window.Echo.channel('orders')
        .listen('OrderCreated', (e) => {
            console.log('Pesanan baru terdeteksi:', e.order);

            // Opsi 1: Reload halaman secara halus agar tabel terisi ulang dari server
            // Ini paling aman agar data tabel sinkron dengan database
            window.location.reload();

            // Opsi 2 (Opsional): Jika ingin update tanpa reload, Anda perlu
            // membuat fungsi AJAX untuk menambah baris ke tbody secara manual.
        });
</script>
@endsection
