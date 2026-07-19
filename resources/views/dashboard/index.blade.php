@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-[1600px] mx-auto space-y-8 animate-fade-in">

    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#3e2723] tracking-tight">
                Ringkasan Operasional
            </h1>
            <p class="text-sm sm:text-base text-gray-500 mt-1">
                Selamat datang kembali,
                <span class="font-bold text-[#5d4037]">
                    {{ session('user.nama') ?? session('user.name', 'Owner') }}
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

    {{-- Main Dashboard Layout --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 items-start">

        {{-- Tabel Pesanan Terbaru --}}
        <div class="xl:col-span-2 bg-white rounded-2xl border border-[#eadfd8] shadow-sm overflow-hidden">

            {{-- Header Table --}}
            <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100 bg-white">
                <div>
                    <h3 class="font-bold text-lg text-[#3e2723]">
                        Pesanan Terbaru
                    </h3>
                    <p class="text-xs text-gray-400 mt-0.5">
                        Daftar pesanan transaksi masuk terbaru
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
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#faf7f4] text-gray-500 text-xs font-semibold uppercase tracking-wider border-b border-gray-100">
                            <th class="py-3.5 px-6">ID</th>
                            <th class="py-3.5 px-6">Pelanggan</th>
                            <th class="py-3.5 px-6">Produk</th>
                            <th class="py-3.5 px-6">Status</th>
                            <th class="py-3.5 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($orders as $order)
                        <tr class="hover:bg-[#faf7f4]/60 transition-colors">
                            <td class="py-4 px-6 font-bold text-[#5d4037]">
                                #{{ $order['id'] }}
                            </td>
                            <td class="py-4 px-6 font-medium text-gray-800">
                                {{ $order['user']['nama'] ?? '-' }}
                            </td>
                            <td class="py-4 px-6 text-gray-600">
                                {{ $order['product']['nama_product'] ?? '-' }}
                            </td>
                            <td class="py-4 px-6">
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
                                    {{ ucfirst(str_replace('_', ' ', $order['status_pesanan'])) }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <a href="{{ route('orders.show', $order['id']) }}"
                                   class="inline-flex items-center justify-center px-3.5 py-1.5 bg-[#5d4037] hover:bg-[#3e2723] text-white text-xs font-semibold rounded-lg shadow-sm transition-colors">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-gray-400">
                                <span class="material-symbols-outlined text-4xl block mb-2 text-gray-300">inbox</span>
                                Belum ada data pesanan terbaru.
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
                    @foreach($progressProduksi as $item)
                    <div>
                        <div class="flex justify-between text-xs font-medium text-gray-600 mb-1.5">
                            <span>{{ $item['name'] }}</span>
                            <span class="font-bold text-[#5d4037]">{{ $item['value'] }}%</span>
                        </div>
                        <div class="w-full h-2.5 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-[#8d6e63] rounded-full transition-all duration-500"
                                style="width: {{ $item['value'] }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Aktivitas Workshop Card --}}
            <div class="bg-white rounded-2xl border border-[#eadfd8] p-6 shadow-sm">
                <h3 class="font-bold text-lg text-[#3e2723] mb-5">
                    Aktivitas Workshop
                </h3>

                <div class="relative space-y-6 before:absolute before:inset-0 before:left-5 before:w-0.5 before:bg-gray-100">

                    {{-- Activity Item 1 --}}
                    <div class="relative flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-[#efebe9] border border-white text-[#6d4c41] flex items-center justify-center shrink-0 z-10 shadow-sm">
                            <span class="material-symbols-outlined text-xl">carpenter</span>
                        </div>
                        <div class="pt-0.5">
                            <p class="text-sm font-semibold text-gray-800">
                                Pesanan baru masuk
                            </p>
                            <p class="text-xs text-gray-400 mt-0.5">
                                Menunggu konfirmasi owner
                            </p>
                        </div>
                    </div>

                    {{-- Activity Item 2 --}}
                    <div class="relative flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-[#efebe9] border border-white text-[#6d4c41] flex items-center justify-center shrink-0 z-10 shadow-sm">
                            <span class="material-symbols-outlined text-xl">inventory_2</span>
                        </div>
                        <div class="pt-0.5">
                            <p class="text-sm font-semibold text-gray-800">
                                Bahan baku tersedia
                            </p>
                            <p class="text-xs text-gray-400 mt-0.5">
                                Stok kayu Jati terpantau aman
                            </p>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>
</div>
@endsection

@push('scripts')
<script type="module">
    // Mendengarkan event dari Reverb
    window.Echo.channel('orders')
        .listen('OrderCreated', (e) => {
            console.log('Pesanan baru terdeteksi:', e.order);

            // Memberikan sedikit feedback visual sebelum refresh
            alert('Ada pesanan baru! Halaman akan diperbarui.');

            // Reload halaman untuk memicu Controller melakukan perhitungan ulang
            // agar data statistik dan progress bar tetap akurat
            window.location.reload();
        });
</script>
@endpush
