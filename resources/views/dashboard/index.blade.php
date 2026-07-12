@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<div class="max-w-7xl mx-auto p-8">
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">
            Ringkasan Operasional
        </h1>
        <p class="text-gray-500 mt-2">
            Selamat datang kembali,
            <strong>{{ session('user.nama') ?? session('user.name') }}</strong>
        </p>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-6">

        {{-- Total Pesanan --}}
        <div class="bg-white rounded-2xl border shadow-sm p-6 transition duration-300 hover:-translate-y-1 hover:shadow-lg">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500">
                        Total Pesanan
                    </p>
                    <h2 class="text-4xl font-bold mt-3 text-amber-800">
                        {{ $ringkasan['total_pesanan'] ?? 0 }}
                    </h2>
                </div>
                <div class="w-14 h-14 rounded-xl bg-amber-100 flex items-center justify-center">
                    <span class="material-symbols-outlined text-amber-700">
                        shopping_cart
                    </span>
                </div>
            </div>
        </div>

        {{-- Diproses --}}
        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <div class="flex justify-between">
                <div>
                    <p class="text-gray-500">
                        Diproses
                    </p>
                    <h2 class="text-4xl font-bold mt-3 text-blue-600">
                        {{ $ringkasan['total_diproses'] ?? 0 }}
                    </h2>
                </div>
                <div class="w-14 h-14 rounded-xl bg-blue-100 flex items-center justify-center">
                    <span class="material-symbols-outlined text-blue-700">
                        precision_manufacturing
                    </span>
                </div>
            </div>
        </div>

        {{-- Selesai --}}
        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <div class="flex justify-between">
                <div>
                    <p class="text-gray-500">
                        Selesai
                    </p>
                    <h2 class="text-4xl font-bold mt-3 text-green-600">
                        {{ $ringkasan['total_selesai'] ?? 0 }}
                    </h2>
                </div>
                <div class="w-14 h-14 rounded-xl bg-green-100 flex items-center justify-center">
                    <span class="material-symbols-outlined text-green-700">
                        task_alt
                    </span>
                </div>
            </div>
        </div>

        {{-- Dibatalkan --}}
        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <div class="flex justify-between">
                <div>
                    <p class="text-gray-500">
                        Dibatalkan
                    </p>
                    <h2 class="text-4xl font-bold mt-3 text-red-600">
                        {{ $ringkasan['total_dibatalkan'] ?? 0 }}
                    </h2>
                </div>
                <div class="w-14 h-14 rounded-xl bg-red-100 flex items-center justify-center">
                    <span class="material-symbols-outlined text-red-700">
                        cancel
                    </span>
                </div>
            </div>
        </div>

        {{-- Pendapatan --}}
        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <div class="flex justify-between">
                <div>
                    <p class="text-gray-500">
                        Estimasi Pendapatan
                    </p>
                    <h2 class="text-2xl font-bold mt-3 text-emerald-700">
                        Rp {{ number_format($ringkasan['total_pendapatan_estimasi'] ?? 0,0,',','.') }}
                    </h2>
                </div>
                <div class="w-14 h-14 rounded-xl bg-emerald-100 flex items-center justify-center">
                    <span class="material-symbols-outlined text-emerald-700">
                        payments
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Layout bawah --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mt-8">
        {{-- Tabel Pesanan --}}
        <div class="xl:col-span-2 bg-white rounded-2xl border shadow-sm overflow-hidden">
            <div class="flex justify-between items-center p-6 border-b">
                <h3 class="text-xl font-bold">
                    Pesanan Terbaru
                </h3>
                <a href="{{ route('orders.index') }}"
                   class="text-amber-700 font-semibold hover:text-amber-900 transition">
                    Lihat Semua →
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 text-gray-700">
                        <tr>
                            <th class="p-4 text-left font-semibold">ID</th>
                            <th class="p-4 text-left font-semibold">Pelanggan</th>
                            <th class="p-4 text-left font-semibold">Produk</th>
                            <th class="p-4 text-left font-semibold">Status</th>
                            <th class="p-4 text-right font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($orders as $order)
                        <tr class="border-t hover:bg-gray-50 transition-colors">
                            <td class="p-4">
                                #{{ $order['id'] }}
                            </td>
                            <td class="p-4">
                                {{ $order['user']['nama'] ?? '-' }}
                            </td>
                            <td class="p-4">
                                {{ $order['product']['nama_product'] ?? '-' }}
                            </td>
                            <td class="p-4">
                                @php
                                    $status = strtolower($order['status_pesanan']);
                                    $badge = match($status){
                                        'selesai' => 'bg-green-100 text-green-700',
                                        'diproses' => 'bg-blue-100 text-blue-700',
                                        'dibatalkan' => 'bg-red-100 text-red-700',
                                        default => 'bg-yellow-100 text-yellow-700',
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-full text-sm {{ $badge }}">
                                    {{ ucfirst(str_replace('_',' ',$status)) }}
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                <a
                                    href="{{ route('orders.show',$order['id']) }}"
                                    class="inline-flex items-center px-4 py-2 rounded-lg bg-amber-700 text-white hover:bg-amber-800 transition">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-10 text-gray-500">
                                Belum ada pesanan.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Widget Sebelah Kanan --}}
        <div class="space-y-6">

            {{-- Status Produksi --}}
            <div class="bg-white rounded-2xl border shadow-sm p-6">
                <h3 class="text-xl font-bold mb-6">
                    Status Produksi
                </h3>
                <div class="space-y-5">
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span>Pahatan</span>
                            <span>75%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-amber-700 h-2 rounded-full w-3/4"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span>Finishing</span>
                            <span>90%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full w-[90%]"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span>Perakitan</span>
                            <span>40%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full w-[40%]"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Informasi Workshop --}}
            <div class="bg-white rounded-2xl border shadow-sm p-6">
                <h3 class="text-xl font-bold mb-4">
                    Aktivitas Workshop
                </h3>
                <div class="space-y-4">
                    <div class="flex gap-3">
                        <div class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center">
                            <span class="material-symbols-outlined">
                                carpenter
                            </span>
                        </div>
                        <div>
                            <p class="font-semibold">
                                Pesanan baru masuk
                            </p>
                            <p class="text-gray-500 text-sm">
                                Menunggu konfirmasi Owner.
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                            <span class="material-symbols-outlined">
                                inventory
                            </span>
                        </div>
                        <div>
                            <p class="font-semibold">
                                Kayu Jati tersedia
                            </p>
                            <p class="text-gray-500 text-sm">
                                Persediaan gudang masih aman.
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                            <span class="material-symbols-outlined">
                                local_shipping
                            </span>
                        </div>
                        <div>
                            <p class="font-semibold">
                                Pengiriman hari ini
                            </p>
                            <p class="text-gray-500 text-sm">
                                3 pesanan siap dikirim.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Banner --}}
            <div class="bg-gradient-to-br from-amber-700 to-amber-900 rounded-2xl p-6 text-white shadow">
                <h3 class="text-xl font-bold">
                    Restock Bahan Baku
                </h3>
                <p class="mt-3 text-amber-100">
                    Kayu Mahoni, Jati, dan Sonokeling telah tersedia di gudang.
                </p>
                <a href="{{ route('products.index') }}"
                   class="inline-block mt-5 px-5 py-3 rounded-xl bg-white text-amber-800 font-semibold">
                    Lihat Produk
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
