@extends('layouts.app')

@section('title', 'Laporan Eksekutif')

@section('content')

{{-- CSS KHUSUS UNTUK MODE CETAK (PRINT) --}}
<style>
    @media print {
        header, nav, footer, aside, .no-print {
            display: none !important;
        }

        body, main, div {
            background-color: white !important;
            color: black !important;
        }

        .shadow-sm, .shadow-md, .rounded-xl, .rounded-2xl, .rounded-full {
            box-shadow: none !important;
            border-radius: 0 !important;
        }

        .print-grid {
            display: flex !important;
            flex-wrap: wrap !important;
            gap: 10px !important;
            border: none !important;
            padding: 0 !important;
            margin-bottom: 20px !important;
        }
        .print-card {
            border: 1px solid black !important;
            padding: 10px !important;
            width: 30% !important;
            text-align: center !important;
        }
        .print-card-icon {
            display: none !important;
        }

        table {
            width: 100% !important;
            border-collapse: collapse !important;
            margin-top: 20px !important;
        }
        th, td {
            border: 1px solid black !important;
            padding: 8px !important;
            color: black !important;
            font-size: 12pt !important;
        }
        th {
            background-color: #f0f0f0 !important;
            -webkit-print-color-adjust: exact;
        }

        .print-only {
            display: block !important;
        }

        .print-badge {
            border: none !important;
            background: none !important;
            font-weight: bold !important;
            padding: 0 !important;
        }

        @page {
            size: A4 portrait;
            margin: 1.5cm;
        }
    }
</style>

<div class="max-w-7xl mx-auto space-y-6 animate-fade-in pb-12 print:space-y-0 print:pb-0">

    {{-- ========================================== --}}
    {{-- BAGIAN 1: KOP SURAT (DATA ASLI TOKO) --}}
    {{-- ========================================== --}}
    <div class="hidden print-only text-center mb-6 border-b-2 border-black pb-4">
        <h1 class="text-2xl font-bold uppercase tracking-wider">Adi Ukiran</h1>
        <p class="text-sm">Alamat: Lubuk Ipuh No.5</p>
        <p class="text-sm">Telp/WA: +62 895-1464-0926</p>

        <h2 class="text-xl font-bold uppercase mt-6 underline decoration-2">Laporan Transaksi Pesanan</h2>
        @if(request('tanggal_mulai') && request('tanggal_selesai'))
            <p class="text-sm mt-1">
                Periode: {{ \Carbon\Carbon::parse(request('tanggal_mulai'))->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse(request('tanggal_selesai'))->translatedFormat('d F Y') }}
            </p>
        @else
            <p class="text-sm mt-1">Periode: Keseluruhan Data</p>
        @endif
    </div>
    {{-- ========================================== --}}


    {{-- Header & Tombol Cetak (SEMBUNYI SAAT CETAK) --}}
    <div class="no-print flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-[#3e2723] tracking-tight">
                    Laporan Eksekutif
                </h1>
                <span class="bg-[#efebe9] text-[#5d4037] text-xs font-semibold px-2.5 py-0.5 rounded-full border border-[#d7ccc8]">
                    Official Report
                </span>
            </div>
            <p class="text-sm text-gray-500 mt-1">
                Ringkasan komprehensif data pemesanan, status pengerjaan, dan estimasi arus pendapatan.
            </p>
        </div>

        <div class="flex items-center gap-2 self-start lg:self-auto">
            <button onclick="window.print()" class="bg-[#5d4037] hover:bg-[#3e2723] text-white px-5 py-2.5 rounded-xl text-sm font-medium flex items-center gap-2 shadow-sm transition-colors">
                <span class="material-symbols-outlined text-sm">print</span>
                Cetak Dokumen
            </button>
        </div>
    </div>

    {{-- Filter Section (SEMBUNYI SAAT CETAK) --}}
    <div class="no-print bg-white p-4 rounded-2xl border border-[#eadfd8] shadow-sm">
        <form action="{{ route('reports.index') }}" method="GET" class="flex flex-col lg:flex-row items-center justify-between gap-4">
            <div class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto">
                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <div class="relative w-full sm:w-auto">
                        <span class="text-xs text-gray-400 block mb-1 font-medium">Dari Tanggal</span>
                        <input
                            type="date"
                            name="tanggal_mulai"
                            value="{{ $tanggal_mulai ?? request('tanggal_mulai') }}"
                            class="w-full sm:w-auto rounded-xl border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#5d4037]/20 focus:border-[#5d4037]"
                        >
                    </div>
                    <span class="text-gray-400 text-xs font-bold uppercase self-end pb-2.5">s/d</span>
                    <div class="relative w-full sm:w-auto">
                        <span class="text-xs text-gray-400 block mb-1 font-medium">Sampai Tanggal</span>
                        <input
                            type="date"
                            name="tanggal_selesai"
                            value="{{ $tanggal_selesai ?? request('tanggal_selesai') }}"
                            class="w-full sm:w-auto rounded-xl border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#5d4037]/20 focus:border-[#5d4037]"
                        >
                    </div>
                </div>

                <div class="flex items-center gap-2 w-full sm:w-auto self-end">
                    <button type="submit" class="w-full sm:w-auto bg-gray-800 hover:bg-gray-900 text-white px-5 py-2.5 rounded-xl text-sm font-medium flex items-center justify-center gap-2 transition-colors shadow-sm">
                        <span class="material-symbols-outlined text-sm">filter_alt</span>
                        Terapkan Filter
                    </button>
                    @if(request('tanggal_mulai') || request('tanggal_selesai'))
                        <a href="{{ route('reports.index') }}" class="text-xs text-rose-600 hover:underline font-medium px-2 py-1">
                            Reset Filter
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    {{-- Cards Grid Statistik --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-5 print-grid">
        @php
            $cards = [
                ['title' => 'Total Pesanan', 'value' => $ringkasan['total_pesanan'] ?? 0, 'icon' => 'shopping_bag', 'bg' => 'bg-amber-50 text-amber-800'],
                ['title' => 'Diproses', 'value' => $ringkasan['total_diproses'] ?? 0, 'icon' => 'precision_manufacturing', 'bg' => 'bg-blue-50 text-blue-800'],
                ['title' => 'Selesai', 'value' => $ringkasan['total_selesai'] ?? 0, 'icon' => 'task_alt', 'bg' => 'bg-emerald-50 text-emerald-800'],
                ['title' => 'Dibatalkan', 'value' => $ringkasan['total_dibatalkan'] ?? 0, 'icon' => 'cancel', 'bg' => 'bg-rose-50 text-rose-800'],
                ['title' => 'Estimasi Pendapatan', 'value' => 'Rp ' . number_format($ringkasan['total_pendapatan_estimasi'] ?? 0, 0, ',', '.'), 'icon' => 'payments', 'bg' => 'bg-[#efebe9] text-[#5d4037]']
            ];
        @endphp

        @foreach($cards as $card)
        <div class="bg-white border border-[#eadfd8] rounded-2xl p-5 shadow-sm print-card">
            <div class="flex items-start justify-between gap-3 print:justify-center">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider print:text-black">
                    {{ $card['title'] }}
                </p>
                <div class="w-10 h-10 rounded-xl {{ $card['bg'] }} flex items-center justify-center shrink-0 print-card-icon">
                    <span class="material-symbols-outlined text-xl">{{ $card['icon'] }}</span>
                </div>
            </div>
            <div class="mt-4 print:mt-1">
                <h2 class="text-xl xl:text-2xl font-extrabold text-[#3e2723] tracking-tight truncate print:text-base print:font-bold">
                    {{ $card['value'] }}
                </h2>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Main Table Area --}}
    <div class="bg-white rounded-2xl border border-[#eadfd8] shadow-sm overflow-hidden print:border-none print:shadow-none">
        <div class="p-6 border-b border-[#e5ddd8] bg-[#faf8f5] flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 no-print">
            <div>
                <h2 class="text-lg font-bold text-[#3e2723]">Detail Log Pemesanan</h2>
            </div>
            <div class="text-xs font-semibold text-gray-500">
                Total Baris: <span class="text-[#3e2723]">{{ (is_object($orders) && method_exists($orders, 'total')) ? $orders->total() : count($orders) }}</span> data
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-[#faf7f4] text-gray-500 text-xs font-semibold uppercase tracking-wider border-b border-gray-100 print:bg-gray-100 print:text-black print:border-black print:border-2">
                        <th class="py-4 px-6 w-16 text-center print:border print:border-black">ID</th>
                        <th class="py-4 px-6 w-36 print:border print:border-black">Tanggal</th>
                        <th class="py-4 px-6 print:border print:border-black">Pelanggan</th>
                        <th class="py-4 px-6 print:border print:border-black">Karya Ukir</th>
                        <th class="py-4 px-6 text-center w-36 print:border print:border-black">Status</th>
                        <th class="py-4 px-6 text-right w-44 print:border print:border-black">Estimasi Biaya</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 print:divide-black">
                    @forelse($orders as $order)
                        <tr class="hover:bg-[#faf7f4]/60 print:hover:bg-transparent">
                            <td class="py-4 px-6 text-center font-bold text-[#5d4037] print:text-black">
                                #{{ $order['id'] }}
                            </td>
                            <td class="py-4 px-6 font-medium text-gray-600 print:text-black">
                                {{ isset($order['created_at']) ? \Carbon\Carbon::parse($order['created_at'])->format('d M Y') : '-' }}
                            </td>
                            <td class="py-4 px-6 font-medium text-gray-800 print:text-black">
                                {{ $order['user']['nama'] ?? '-' }}
                            </td>
                            <td class="py-4 px-6 text-gray-600 print:text-black">
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
                                <span class="print-badge inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $badgeStyle }}">
                                    {{ ucfirst(str_replace('_', ' ', $order['status_pesanan'] ?? 'menunggu')) }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right font-bold text-[#5d4037] print:text-black">
                                Rp {{ number_format($order['estimasi_biaya'] ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-20 text-gray-400 print:text-black print:py-8">
                                <span class="material-symbols-outlined text-4xl block mb-2 text-gray-300 no-print">inbox</span>
                                <p class="font-medium text-sm">Tidak ada rekaman transaksi ditemukan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination (SEMBUNYI SAAT CETAK) --}}
        @if (is_object($orders) && method_exists($orders, 'hasPages') && $orders->hasPages())
            <div class="no-print p-4 border-t border-gray-100 bg-white">
                {{ $orders->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

    {{-- ========================================== --}}
    {{-- BAGIAN 2: TANDA TANGAN (DATA ASLI PEMILIK) --}}
    {{-- ========================================== --}}
    <div class="hidden print-only mt-12 w-full">
        <div class="flex justify-end pr-8">
            <div class="text-center">
                {{-- Format Tanggal Otomatis Mengambil Hari Ini Saat Dokumen Dicetak --}}
                <p class="text-sm">
                    Padang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                </p>
                <p class="text-sm font-semibold mt-1 mb-20">Pemilik Toko</p>

                <p class="text-sm font-bold underline">
                    Adriansyah
                </p>
            </div>
        </div>
    </div>
    {{-- ========================================== --}}

</div>
@endsection
