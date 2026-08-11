@extends('layouts.app')

@section('title', 'Laporan Eksekutif')

@section('content')

{{-- CSS KHUSUS UNTUK MODE CETAK (PRINT) --}}
<style>
    @media print {
        header, nav, footer, aside, .no-print { display: none !important; }
        body, main, div { background-color: white !important; color: black !important; }
        .shadow-sm, .shadow-md, .rounded-xl, .rounded-2xl, .rounded-full { box-shadow: none !important; border-radius: 0 !important; }

        /* Mengatur 5 kartu statistik agar sejajar sempurna dalam 1 baris mendatar */
        .print-grid {
            display: table !important;
            width: 100% !important;
            table-layout: fixed !important;
            border-collapse: separate !important;
            border-spacing: 6px !important;
            margin-bottom: 15px !important;
        }
        .print-card {
            display: table-cell !important;
            border: 1px solid #000 !important;
            padding: 8px 4px !important;
            width: 20% !important;
            text-align: center !important;
            background: #fff !important;
            vertical-align: middle !important;
        }
        .print-card-icon { display: none !important; }

        /* Gaya Tabel Formal Monokrom */
        table { width: 100% !important; border-collapse: collapse !important; margin-top: 15px !important; }
        th, td { border: 1px solid #000 !important; padding: 6px 8px !important; color: black !important; font-size: 9.5pt !important; }
        th { background-color: #e5e7eb !important; -webkit-print-color-adjust: exact; text-transform: uppercase; font-weight: bold; }

        /* Format Status Formal Tanpa Warna-warni */
        .print-badge {
            border: none !important;
            background: none !important;
            font-weight: normal !important;
            padding: 0 !important;
            color: black !important;
        }

        .print-only { display: block !important; }
        @page { size: A4 landscape; margin: 1cm; }
    }
</style>

<div class="max-w-7xl mx-auto space-y-8 animate-fade-in pb-12 print:space-y-0 print:pb-0">

    {{-- KOP SURAT PRINT (Format Dokumen Resmi) --}}
    <div class="hidden print-only text-center mb-4 border-b-2 border-black pb-3">
        <h1 class="text-2xl font-bold uppercase tracking-wider">Adi Ukiran</h1>
        <p class="text-xs">Alamat: Lubuk Ipuh No.5 | Telp/WA: +62 895-1464-0926</p>
        <h2 class="text-lg font-bold uppercase mt-4 underline decoration-1">Laporan Transaksi Pesanan</h2>

        {{-- Informasi Filter Aktif saat Cetak --}}
        <div class="text-xs mt-2 space-y-0.5 text-black">
            <p><strong>Periode:</strong>
                @if(request('tanggal_mulai') && request('tanggal_selesai'))
                    {{ \Carbon\Carbon::parse(request('tanggal_mulai'))->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse(request('tanggal_selesai'))->translatedFormat('d F Y') }}
                @else
                    Keseluruhan Data
                @endif
            </p>
            @if(request('status'))
                <p><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', request('status'))) }}</p>
            @endif
            @if(request('pelanggan'))
                <p><strong>Pencarian Pelanggan:</strong> "{{ request('pelanggan') }}"</p>
            @endif
        </div>
    </div>

    {{-- Header Section --}}
    <div class="no-print flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#3e2723] tracking-tight">Laporan Eksekutif</h1>
            <p class="text-sm text-gray-500 mt-1">Ringkasan komprehensif data pemesanan, status pengerjaan, dan estimasi arus pendapatan.</p>
        </div>
        <button onclick="window.print()" class="bg-[#5d4037] hover:bg-[#3e2723] text-white px-5 py-2.5 rounded-xl text-sm font-semibold flex items-center gap-2 shadow-sm transition-all duration-200 self-start lg:self-auto">
            <span class="material-symbols-outlined text-sm">print</span>
            Cetak Dokumen
        </button>
    </div>

    {{-- Filter Section --}}
    <div class="no-print bg-white p-6 rounded-2xl border border-[#eadfd8] shadow-sm">
        <form action="{{ route('reports.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach(['tanggal_mulai' => 'Dari Tanggal', 'tanggal_selesai' => 'Sampai Tanggal'] as $name => $label)
                <div>
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-1.5">{{ $label }}</span>
                    <input type="date" name="{{ $name }}" value="{{ request($name) }}" class="w-full rounded-xl border border-gray-200 px-3.5 py-2.5 text-xs font-semibold text-gray-700 focus:border-[#5d4037] focus:ring-2 focus:ring-[#5d4037]/10 focus:outline-none transition-all">
                </div>
                @endforeach

                <div>
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-1.5">Status Pesanan</span>
                    <select name="status" class="w-full rounded-xl border border-gray-200 px-3 py-2.5 text-xs font-semibold text-gray-700 focus:border-[#5d4037] focus:ring-2 focus:ring-[#5d4037]/10 focus:outline-none transition-all bg-white">
                        <option value="">Semua Status</option>
                        @foreach(['menunggu_konfirmasi', 'diproses', 'selesai', 'dibatalkan'] as $s)
                            <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $s)) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-1.5">Kriya Ukir / Produk</span>
                    <select name="product_id" class="w-full rounded-xl border border-gray-200 px-3 py-2.5 text-xs font-semibold text-gray-700 focus:border-[#5d4037] focus:ring-2 focus:ring-[#5d4037]/10 focus:outline-none transition-all bg-white">
                        <option value="">Semua Karya Ukir</option>
                        @foreach($productsList ?? [] as $prod)
                            @php $prodId = $prod->id ?? $prod['id']; @endphp
                            <option value="{{ $prodId }}" {{ request('product_id') == $prodId ? 'selected' : '' }}>{{ $prod->nama_product ?? $prod['nama_product'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-4 border-t border-gray-100">
                <input type="text" name="pelanggan" value="{{ request('pelanggan') }}" placeholder="Cari nama pelanggan..." class="w-full sm:w-72 rounded-xl border border-gray-200 px-4 py-2.5 text-xs font-semibold text-gray-900 focus:border-[#5d4037] focus:ring-2 focus:ring-[#5d4037]/10 focus:outline-none transition-all">
                <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                    <button type="submit" class="bg-[#3e2723] hover:bg-black text-white px-5 py-2.5 rounded-xl text-xs font-bold flex items-center justify-center gap-2 transition-all shadow-sm">
                        <span class="material-symbols-outlined text-sm">filter_alt</span>
                        Terapkan Filter
                    </button>
                    @if(request()->hasAny(['tanggal_mulai', 'tanggal_selesai', 'status', 'product_id', 'pelanggan']))
                        <a href="{{ route('reports.index') }}" class="text-xs text-rose-600 font-bold px-3 py-2 hover:bg-rose-50 rounded-lg">Reset</a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    {{-- Cards Statistik --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5 print-grid">
        @php
            $cards = [
                ['title' => 'Total Pesanan', 'value' => $ringkasan['total_pesanan'] ?? 0, 'icon' => 'shopping_bag', 'bg' => 'bg-amber-50 text-amber-800'],
                ['title' => 'Diproses', 'value' => $ringkasan['total_diproses'] ?? 0, 'icon' => 'precision_manufacturing', 'bg' => 'bg-blue-50 text-blue-800'],
                ['title' => 'Selesai', 'value' => $ringkasan['total_selesai'] ?? 0, 'icon' => 'task_alt', 'bg' => 'bg-emerald-50 text-emerald-800'],
                ['title' => 'Dibatalkan', 'value' => $ringkasan['total_dibatalkan'] ?? 0, 'icon' => 'cancel', 'bg' => 'bg-rose-50 text-rose-800'],
                ['title' => 'Pendapatan', 'value' => 'Rp ' . number_format($ringkasan['total_pendapatan_estimasi'] ?? 0, 0, ',', '.'), 'icon' => 'payments', 'bg' => 'bg-[#efebe9] text-[#5d4037]']
            ];
        @endphp
        @foreach($cards as $card)
        <div class="bg-white border border-[#eadfd8] rounded-2xl p-5 shadow-sm print-card">
            <div class="flex items-start justify-between gap-3">
                <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">{{ $card['title'] }}</p>
                <div class="w-9 h-9 rounded-xl {{ $card['bg'] }} flex items-center justify-center shrink-0 print-card-icon">
                    <span class="material-symbols-outlined text-lg">{{ $card['icon'] }}</span>
                </div>
            </div>
            <h2 class="text-xl font-extrabold text-[#3e2723] mt-3 truncate">{{ $card['value'] }}</h2>
        </div>
        @endforeach
    </div>

    {{-- Main Table --}}
    <div class="bg-white rounded-2xl border border-[#eadfd8] shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100 bg-[#faf8f5] flex justify-between items-center no-print">
            <h3 class="font-bold text-lg text-[#3e2723]">Detail Log Pemesanan</h3>
            <span class="text-xs font-bold text-gray-400">Total: {{ method_exists($orders, 'total') ? $orders->total() : count($orders) }} data</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="bg-[#faf7f4] text-gray-500 text-[11px] font-bold uppercase tracking-wider border-b border-gray-100">
                        <th class="py-3.5 px-6">Tanggal</th>
                        <th class="py-3.5 px-6">Pelanggan</th>
                        <th class="py-3.5 px-6">Karya Ukir</th>
                        <th class="py-3.5 px-6 text-center">Status</th>
                        <th class="py-3.5 px-6 text-right">Estimasi Biaya</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($orders as $order)
                        <tr class="hover:bg-[#faf7f4]/60 transition-colors">
                            <td class="py-4 px-6 text-xs font-bold text-gray-600">{{ \Carbon\Carbon::parse($order->created_at ?? $order['created_at'])->format('d M Y') }}</td>
                            <td class="py-4 px-6 text-xs font-bold text-gray-800">{{ $order->user->nama ?? ($order['user']['nama'] ?? '-') }}</td>
                            <td class="py-4 px-6 text-xs font-medium text-gray-700">{{ $order->product->nama_product ?? ($order['product']['nama_product'] ?? 'Pesanan Custom') }}</td>
                            <td class="py-4 px-6 text-center">
                                @php
                                    $stat = strtolower($order->status_pesanan ?? $order['status_pesanan']);
                                    $style = match(true) {
                                        str_contains($stat, 'selesai') => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        str_contains($stat, 'proses')  => 'bg-blue-50 text-blue-700 border-blue-200',
                                        str_contains($stat, 'batal')   => 'bg-rose-50 text-rose-700 border-rose-200',
                                        default => 'bg-amber-50 text-amber-700 border-amber-200',
                                    };
                                @endphp
                                {{-- Ditambahkan class print-badge agar saat dicetak berubah menjadi teks hitam formal --}}
                                <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold border print-badge {{ $style }}">
                                    {{ ucfirst(str_replace('_', ' ', $stat)) }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right text-xs font-bold text-[#5d4037]">Rp {{ number_format($order->estimasi_biaya ?? $order['estimasi_biaya'], 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-16 text-gray-400 font-medium text-sm">Tidak ada transaksi ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Container --}}
        @if (method_exists($orders, 'hasPages') && $orders->hasPages())
        <div class="no-print p-4 border-t border-gray-100 bg-[#faf8f5] flex items-center justify-center gap-1">
            @if ($orders->onFirstPage())
                <span class="px-3 py-1.5 rounded-lg border border-gray-200 bg-gray-100 text-gray-300 text-xs font-bold cursor-not-allowed">&laquo; Prev</span>
            @else
                <a href="{{ $orders->previousPageUrl() }}" class="px-3 py-1.5 rounded-lg border border-gray-200 bg-white text-gray-700 text-xs font-bold hover:bg-[#5d4037] hover:text-white transition-colors">&laquo; Prev</a>
            @endif

            @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                <a href="{{ $url }}" class="px-3 py-1.5 rounded-lg border {{ ($orders->currentPage() == $page) ? 'bg-[#5d4037] text-white border-[#5d4037]' : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-100' }} text-xs font-bold transition-colors">
                    {{ $page }}
                </a>
            @endforeach

            @if ($orders->hasMorePages())
                <a href="{{ $orders->nextPageUrl() }}" class="px-3 py-1.5 rounded-lg border border-gray-200 bg-white text-gray-700 text-xs font-bold hover:bg-[#5d4037] hover:text-white transition-colors">Next &raquo;</a>
            @else
                <span class="px-3 py-1.5 rounded-lg border border-gray-200 bg-gray-100 text-gray-300 text-xs font-bold cursor-not-allowed">Next &raquo;</span>
            @endif
        </div>
        @endif
    </div>

    {{-- Signature Print (Tanda Tangan Formal) --}}
    <div class="hidden print-only mt-8 w-full">
        <div class="flex justify-end pr-4">
            <div class="text-center">
                <p class="text-xs">Padang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                <p class="text-xs font-semibold mt-1 mb-16">Pemilik Toko</p>
                <p class="text-xs font-bold underline">Adriansyah</p>
            </div>
        </div>
    </div>
</div>
@endsection
