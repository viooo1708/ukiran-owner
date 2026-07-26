@extends('layouts.app')

@section('title', 'Edit Pesanan')

@section('content')
<div class="max-w-6xl mx-auto space-y-8 animate-fade-in pb-12">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-[#e5ddd8] pb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#3e2723] tracking-tight">
                Update Status Pesanan
            </h1>
            <p class="mt-1 text-sm text-gray-500">
                Kelola proses produksi dan perbarui detail estimasi biaya pesanan pelanggan.
            </p>
        </div>
        <a href="{{ route('orders.index') }}"
           class="inline-flex items-center gap-2 self-start sm:self-auto bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 px-4 py-2 rounded-xl text-sm font-medium transition-colors shadow-sm">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            Kembali ke Daftar
        </a>
    </div>

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3 items-start">

        {{-- Detail Pesanan Card --}}
        <div class="lg:col-span-2 rounded-2xl bg-white border border-[#eadfd8] shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-[#e5ddd8] bg-[#faf8f5]">
                <h2 class="text-base font-bold text-[#3e2723]">Detail Ringkasan Pesanan</h2>
            </div>

            <div class="p-6 divide-y divide-gray-100 text-sm">
                <div class="flex justify-between items-center py-3.5 first:pt-0">
                    <span class="font-medium text-gray-500">ID Pesanan</span>
                    <span class="font-mono font-bold text-[#5d4037] bg-[#efebe9] px-2.5 py-1 rounded-lg border border-[#d7ccc8]">
                        #{{ $order['id'] }}
                    </span>
                </div>

                <div class="flex justify-between items-center py-3.5">
                    <span class="font-medium text-gray-500">Pelanggan</span>
                    <span class="font-bold text-gray-800">{{ $order['user']['nama'] ?? '-' }}</span>
                </div>

                <div class="flex justify-between items-center py-3.5">
                    <span class="font-medium text-gray-500">Email</span>
                    <span class="text-gray-600">{{ $order['user']['email'] ?? '-' }}</span>
                </div>

                <div class="flex justify-between items-center py-3.5">
                    <span class="font-medium text-gray-500">Produk</span>
                    <span class="font-semibold text-[#5d4037]">{{ $order['product']['nama_product'] ?? '-' }}</span>
                </div>

                <div class="flex justify-between items-center py-3.5 last:pb-0">
                    <span class="font-medium text-gray-500">Estimasi Biaya Saat Ini</span>
                    <span class="font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-200">
                        Rp {{ number_format($order['estimasi_biaya'] ?? 0, 0, ',', '.') }}
                    </span>
                </div>

                {{-- Spesifikasi Tambahan --}}
                @if(isset($order['specification']))
                <div class="pt-6 mt-4 border-t border-gray-100">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-[#3e2723] mb-3.5 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-sm text-[#5d4037]">extension</span>
                        Spesifikasi Kustom Produk
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="rounded-xl border border-[#eadfd8] bg-[#faf8f5] p-3.5">
                            <p class="text-[11px] text-gray-400 font-bold uppercase tracking-wider">Ukuran</p>
                            <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ $order['specification']['ukuran'] ?? '-' }}</p>
                        </div>
                        <div class="rounded-xl border border-[#eadfd8] bg-[#faf8f5] p-3.5">
                            <p class="text-[11px] text-gray-400 font-bold uppercase tracking-wider">Material</p>
                            <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ $order['specification']['material'] ?? '-' }}</p>
                        </div>
                        <div class="rounded-xl border border-[#eadfd8] bg-[#faf8f5] p-3.5">
                            <p class="text-[11px] text-gray-400 font-bold uppercase tracking-wider">Finishing</p>
                            <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ $order['specification']['finishing'] ?? '-' }}</p>
                        </div>
                        <div class="rounded-xl border border-[#eadfd8] bg-[#faf8f5] p-3.5">
                            <p class="text-[11px] text-gray-400 font-bold uppercase tracking-wider">Catatan Klien</p>
                            <p class="text-sm font-semibold text-gray-800 mt-0.5 truncate" title="{{ $order['specification']['catatan'] ?? '-' }}">
                                {{ $order['specification']['catatan'] ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Form Update Side-Card --}}
        <div class="rounded-2xl bg-white border border-[#eadfd8] shadow-sm p-6">
            <h2 class="text-base font-bold text-[#3e2723] mb-5 pb-3 border-b border-[#e5ddd8]">
                Form Pembaruan Status
            </h2>

            <form action="{{ route('orders.update', $order['id']) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                {{-- Estimasi Biaya --}}
                <div>
                    <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-gray-600">
                        Estimasi Biaya (Rp)
                    </label>
                    <div class="relative rounded-xl shadow-sm">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <span class="text-xs font-bold text-gray-400">Rp</span>
                        </div>
                        <input
                            type="number"
                            name="estimasi_biaya"
                            value="{{ old('estimasi_biaya', $order['estimasi_biaya'] ?? '') }}"
                            class="w-full rounded-xl border border-gray-200 pl-11 pr-4 py-2.5 text-sm focus:border-[#5d4037] focus:ring-2 focus:ring-[#5d4037]/10 focus:outline-none transition-all font-semibold text-gray-800"
                            placeholder="Nominal biaya">
                    </div>
                </div>

                {{-- Estimasi Waktu --}}
                <div>
                    <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-gray-600">
                        Estimasi Waktu Produksi
                    </label>
                    <input
                        type="text"
                        name="estimasi_waktu"
                        value="{{ old('estimasi_waktu', $order['estimasi_waktu'] ?? '') }}"
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-[#5d4037] focus:ring-2 focus:ring-[#5d4037]/10 focus:outline-none transition-all"
                        placeholder="Contoh: 7-14 hari kerja">
                </div>

                {{-- Status Pesanan --}}
                <div>
                    <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-gray-600">
                        Status Pesanan
                    </label>
                    <select
                        id="status_pesanan"
                        name="status_pesanan"
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-[#5d4037] focus:ring-2 focus:ring-[#5d4037]/10 focus:outline-none transition-all bg-white font-medium text-gray-800">
                        <option value="menunggu_konfirmasi" {{ old('status_pesanan', $order['status_pesanan'] ?? '') == 'menunggu_konfirmasi' ? 'selected' : '' }}>
                            Menunggu Konfirmasi
                        </option>
                        <option value="diproses" {{ old('status_pesanan', $order['status_pesanan'] ?? '') == 'diproses' ? 'selected' : '' }}>
                            Diproses
                        </option>
                        <option value="selesai" {{ old('status_pesanan', $order['status_pesanan'] ?? '') == 'selesai' ? 'selected' : '' }}>
                            Selesai
                        </option>
                        <option value="dibatalkan" {{ old('status_pesanan', $order['status_pesanan'] ?? '') == 'dibatalkan' ? 'selected' : '' }}>
                            Dibatalkan
                        </option>
                    </select>
                </div>

                {{-- Tahap Produksi --}}
                <div>
                    <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-gray-600 flex justify-between items-center">
                        <span>Tahap Produksi saat Ini</span>
                        <span id="tahap_warning" class="text-[11px] font-normal text-rose-500 hidden">*Pilih Status 'Diproses' dahulu</span>
                    </label>
                    <select
                        id="tahap_produksi"
                        name="tahap_produksi"
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-[#5d4037] focus:ring-2 focus:ring-[#5d4037]/10 focus:outline-none transition-all bg-white font-medium text-gray-800 disabled:bg-gray-100 disabled:text-gray-400 disabled:cursor-not-allowed">

                        @php
                            $activeTahap = old('tahap_produksi', $order['latest_status']['status'] ?? $order['tahap_produksi'] ?? 'persiapan');
                        @endphp

                        <option value="persiapan" {{ $activeTahap == 'persiapan' ? 'selected' : '' }}>
                            📦 Persiapan
                        </option>
                        <option value="pengukiran" {{ $activeTahap == 'pengukiran' ? 'selected' : '' }}>
                            🔨 Pengukiran
                        </option>
                        <option value="finishing" {{ $activeTahap == 'finishing' ? 'selected' : '' }}>
                            ✨ Finishing
                        </option>
                        <option value="selesai" {{ $activeTahap == 'selesai' ? 'selected' : '' }}>
                            ✅ Selesai
                        </option>
                    </select>
                </div>

                {{-- Catatan Produksi --}}
                <div>
                    <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-gray-600">
                        Catatan Internal Produksi
                    </label>
                    <textarea
                        name="catatan"
                        rows="3"
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-[#5d4037] focus:ring-2 focus:ring-[#5d4037]/10 focus:outline-none transition-all placeholder:text-gray-400"
                        placeholder="Tambahkan catatan progres detail pengerjaan ukiran/produk di sini...">{{ old('catatan', $order['catatan'] ?? '') }}</textarea>
                </div>

                {{-- Submit Actions --}}
                <div class="pt-3">
                    <button
                        type="submit"
                        class="w-full inline-flex justify-center items-center rounded-xl bg-[#5d4037] hover:bg-[#3e2723] px-4 py-3 text-sm font-bold text-white shadow-sm transition-colors">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

{{-- JavaScript Interaktif untuk Mengunci Tahap Produksi --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    const statusPesanan = document.getElementById("status_pesanan");
    const tahapProduksi = document.getElementById("tahap_produksi");
    const tahapWarning = document.getElementById("tahap_warning");
    const form = statusPesanan.closest('form');

    function handleStatusChange() {
        if (statusPesanan.value !== "diproses") {
            tahapProduksi.disabled = true;
            tahapWarning.classList.remove("hidden");
        } else {
            tahapProduksi.disabled = false;
            tahapWarning.classList.add("hidden");
        }

        if (statusPesanan.value === "selesai") {
            tahapProduksi.value = "selesai";
        }
    }

    handleStatusChange();
    statusPesanan.addEventListener("change", handleStatusChange);

    form.addEventListener("submit", function () {
        tahapProduksi.disabled = false;
    });
});
</script>
@endsection
