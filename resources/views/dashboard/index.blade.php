@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 animate-fade-in">

    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#3e2723] tracking-tight">
                Ringkasan Operasional
            </h1>
            <p class="text-sm sm:text-base text-gray-500 mt-1">
                Selamat datang kembali,
                <span class="font-bold text-[#5d4037]">
                    {{ session('user.nama') ?? session('user.name', auth()->user()->nama ?? auth()->user()->name ?? 'Owner') }}
                </span>
            </p>
        </div>

        {{-- Date Badge --}}
        <div class="flex items-center gap-3 bg-white border border-[#eadfd8] px-4 py-2.5 rounded-xl shadow-sm self-start md:self-auto">
            <span class="material-symbols-outlined text-[#6d4c41]">calendar_today</span>
            <div>
                <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider leading-none">
                    Hari Ini
                </p>
                <p class="text-sm font-bold text-[#5d4037] leading-tight mt-0.5">
                    {{ now()->translatedFormat('d F Y') }}
                </p>
            </div>
        </div>
    </div>

    {{-- Cards Grid Statistik --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-5">
        @php
            $cards = [
                [
                    'title' => 'Total Pesanan',
                    'value' => number_format($ringkasan['total_pesanan'] ?? 0, 0, ',', '.'),
                    'icon'  => 'shopping_bag',
                    'bg'    => 'bg-amber-50 text-amber-800'
                ],
                [
                    'title' => 'Diproses',
                    'value' => number_format($ringkasan['total_diproses'] ?? 0, 0, ',', '.'),
                    'icon'  => 'precision_manufacturing',
                    'bg'    => 'bg-blue-50 text-blue-800'
                ],
                [
                    'title' => 'Selesai',
                    'value' => number_format($ringkasan['total_selesai'] ?? 0, 0, ',', '.'),
                    'icon'  => 'task_alt',
                    'bg'    => 'bg-emerald-50 text-emerald-800'
                ],
                [
                    'title' => 'Dibatalkan',
                    'value' => number_format($ringkasan['total_dibatalkan'] ?? 0, 0, ',', '.'),
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
                <h2 class="text-xl xl:text-2xl font-extrabold text-[#3e2723] tracking-tight truncate">
                    {{ $card['value'] }}
                </h2>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Main Dashboard Layout --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 items-start">

        {{-- Tabel 10 Pesanan Terbaru --}}
        <div class="xl:col-span-2 bg-white rounded-2xl border border-[#eadfd8] shadow-sm overflow-hidden">

            {{-- Header Table --}}
            <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100 bg-[#faf8f5]">
                <div>
                    <h3 class="font-bold text-lg text-[#3e2723]">
                        Pesanan Terbaru
                    </h3>
                    <p class="text-xs text-gray-400 mt-0.5">
                        Daftar 10 transaksi pesanan masuk terbaru
                    </p>
                </div>
                <a href="{{ route('orders.index') }}"
                   class="inline-flex items-center gap-1 text-xs font-bold text-[#6d4c41] hover:text-[#3e2723] transition-colors">
                    Lihat Semua
                    <span class="material-symbols-outlined text-sm">chevron_right</span>
                </a>
            </div>

            {{-- Table Body --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-[#faf7f4] text-gray-500 text-xs font-semibold uppercase tracking-wider border-b border-gray-100">
                            <th class="py-3.5 px-6">Kode Pesanan</th>
                            <th class="py-3.5 px-6">Pelanggan</th>
                            <th class="py-3.5 px-6">Produk</th>
                            <th class="py-3.5 px-6">Status</th>
                            <th class="py-3.5 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse(collect($orders)->take(10) as $order)
                        @php
                            $orderId = is_array($order) ? ($order['id'] ?? '') : ($order->id ?? '');
                            $kodePesanan = is_array($order)
                                ? ($order['kode_pesanan'] ?? '#' . $orderId)
                                : ($order->kode_pesanan ?? '#' . $orderId);

                            $userNama = is_array($order)
                                ? ($order['user']['nama'] ?? $order['user']['name'] ?? 'Pelanggan')
                                : ($order->user->nama ?? $order->user->name ?? 'Pelanggan');

                            $items = is_array($order) ? ($order['order_items'] ?? []) : ($order->orderItems ?? collect());
                            $totalItems = count($items);

                            if ($totalItems > 0) {
                                $firstItem = is_array($items) ? $items[0] : $items->first();
                                $firstProdName = is_array($firstItem)
                                    ? ($firstItem['product']['nama_product'] ?? $firstItem['nama_custom'] ?? 'Pesanan Kriya')
                                    : ($firstItem->product->nama_product ?? $firstItem->nama_custom ?? 'Pesanan Kriya');

                                $productNama = $firstProdName . ($totalItems > 1 ? ' (+' . ($totalItems - 1) . ' item)' : '');
                            } else {
                                $productNama = is_array($order)
                                    ? ($order['product']['nama_product'] ?? 'Pesanan Kriya')
                                    : ($order->product->nama_product ?? 'Pesanan Kriya');
                            }

                            $statusPesanan = is_array($order)
                                ? ($order['status_pesanan'] ?? 'menunggu_konfirmasi')
                                : ($order->status_pesanan ?? 'menunggu_konfirmasi');
                        @endphp
                        <tr class="hover:bg-[#faf7f4]/60 transition-colors">
                            <td class="py-4 px-6 font-bold text-[#5d4037]">
                                {{ $kodePesanan }}
                            </td>
                            <td class="py-4 px-6 font-medium text-gray-800">
                                {{ $userNama }}
                            </td>
                            <td class="py-4 px-6 text-gray-600">
                                {{ $productNama }}
                            </td>
                            <td class="py-4 px-6">
                                @php
                                    $status = strtolower($statusPesanan);
                                    $badgeStyle = match(true) {
                                        str_contains($status, 'selesai') => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        str_contains($status, 'proses')  => 'bg-blue-50 text-blue-700 border-blue-200',
                                        str_contains($status, 'batal')   => 'bg-rose-50 text-rose-700 border-rose-200',
                                        default => 'bg-amber-50 text-amber-700 border-amber-200',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $badgeStyle }}">
                                    {{ ucfirst(str_replace('_', ' ', $statusPesanan)) }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <a href="{{ route('orders.show', $orderId) }}"
                                   class="inline-flex items-center justify-center px-3.5 py-1.5 bg-[#5d4037] hover:bg-[#3e2723] text-white text-xs font-semibold rounded-lg shadow-sm transition-colors">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-16 text-center text-gray-400">
                                <span class="material-symbols-outlined text-4xl block mb-2 text-gray-300">inbox</span>
                                <p class="font-medium text-sm">Belum ada data pesanan terbaru.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Sidebar Kanan: Produksi & Aktivitas --}}
        <div class="space-y-6">

            {{-- Progress Produksi Card --}}
            <div class="bg-white rounded-2xl border border-[#eadfd8] p-6 shadow-sm">
                <h3 class="font-bold text-lg text-[#3e2723] mb-4">
                    Progress Profil Produksi
                </h3>

                <div class="space-y-4">
                    @forelse($progressProduksi ?? [] as $item)
                    <div>
                        <div class="flex justify-between text-xs font-medium text-gray-600 mb-1.5">
                            <span>Tahap {{ $item['name'] ?? 'Tahapan' }}</span>
                            <span class="font-bold text-[#5d4037]">{{ $item['value'] ?? 0 }}%</span>
                        </div>
                        <div class="w-full h-2.5 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-[#8d6e63] rounded-full transition-all duration-500"
                                 style="width: {{ $item['value'] ?? 0 }}%"></div>
                        </div>
                    </div>
                    @empty
                    <p class="text-xs text-gray-400 text-center py-4">Data progress belum tersedia.</p>
                    @endforelse
                </div>
            </div>

            {{-- Aktivitas Workshop Card --}}
            <div class="bg-white rounded-2xl border border-[#eadfd8] p-6 shadow-sm">
                <h3 class="font-bold text-lg text-[#3e2723] mb-5">
                    Aktivitas Workshop
                </h3>

                <div class="relative space-y-6 before:absolute before:inset-0 before:left-5 before:w-0.5 before:bg-gray-100">
                    @forelse($aktivitas ?? [] as $act)
                    @php
                        $actTitle = is_array($act) ? ($act['title'] ?? '') : ($act->title ?? '');
                        $actMsg = is_array($act) ? ($act['message'] ?? '') : ($act->message ?? '');
                        $actTime = is_array($act) ? ($act['created_at'] ?? null) : ($act->created_at ?? null);
                        $timeDiff = $actTime instanceof \Carbon\Carbon ? $actTime->diffForHumans() : ($actTime ? \Carbon\Carbon::parse($actTime)->diffForHumans() : '-');
                    @endphp
                    <div class="relative flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-[#efebe9] border border-white text-[#6d4c41] flex items-center justify-center shrink-0 z-10 shadow-sm">
                            <span class="material-symbols-outlined text-xl">
                                {{ str_contains(strtolower($actTitle), 'baru') ? 'shopping_bag' : 'history_toggle_off' }}
                            </span>
                        </div>
                        <div class="pt-0.5">
                            <p class="text-sm font-semibold text-gray-800">
                                {{ $actTitle }}
                            </p>
                            <p class="text-xs text-gray-500 mt-0.5">
                                {{ $actMsg }}
                            </p>
                            <span class="text-[10px] text-gray-400 mt-1 block">
                                {{ $timeDiff }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="relative flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-[#efebe9] border border-white text-[#6d4c41] flex items-center justify-center shrink-0 z-10 shadow-sm">
                            <span class="material-symbols-outlined text-xl">notifications_paused</span>
                        </div>
                        <div class="pt-0.5">
                            <p class="text-sm font-semibold text-gray-800">Belum ada aktivitas</p>
                            <p class="text-xs text-gray-400 mt-0.5">Aktivitas pesanan baru & update status akan muncul di sini.</p>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
