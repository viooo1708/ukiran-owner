@extends('layouts.app')

@section('title', 'Edit Pesanan')

@section('content')
<div class="max-w-5xl mx-auto p-4 md:p-8 animate-fade-in">

    {{-- Header --}}
    <div class="mb-8 pb-4 border-b border-gray-200">
        <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">
            Update Status Pesanan
        </h1>
        <p class="mt-1 text-sm text-gray-500">
            Kelola proses produksi dan perbarui detail pesanan pelanggan.
        </p>
    </div>

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3 items-start">

        {{-- Detail Pesanan Card --}}
        <div class="lg:col-span-2 rounded-2xl bg-white border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <h2 class="text-lg font-bold text-gray-800">Detail Ringkasan Pesanan</h2>
            </div>

            <div class="p-6 divide-y divide-gray-100">
                <div class="flex justify-between items-center py-3 first:pt-0">
                    <span class="text-sm font-medium text-gray-500">ID Pesanan</span>
                    <span class="font-mono font-bold text-sm text-gray-900 bg-gray-100 px-2.5 py-1 rounded tracking-wide">
                        #{{ $order['id'] }}
                    </span>
                </div>

                <div class="flex justify-between items-center py-3">
                    <span class="text-sm font-medium text-gray-500">Pelanggan</span>
                    <span class="text-sm font-semibold text-gray-800">{{ $order['user']['nama'] ?? '-' }}</span>
                </div>

                <div class="flex justify-between items-center py-3">
                    <span class="text-sm font-medium text-gray-500">Email</span>
                    <span class="text-sm text-gray-600">{{ $order['user']['email'] ?? '-' }}</span>
                </div>

                <div class="flex justify-between items-center py-3">
                    <span class="text-sm font-medium text-gray-500">Produk</span>
                    <span class="text-sm font-semibold text-amber-700">{{ $order['product']['nama_product'] ?? '-' }}</span>
                </div>

                <div class="flex justify-between items-center py-3 last:pb-0">
                    <span class="text-sm font-medium text-gray-500">Estimasi Biaya Saat Ini</span>
                    <span class="text-sm font-bold text-emerald-600">
                        Rp {{ number_format($order['estimasi_biaya'] ?? 0, 0, ',', '.') }}
                    </span>
                </div>

                {{-- Spesifikasi Tambahan --}}
                @if(isset($order['specification']))
                <div class="pt-6 mt-4 border-t border-gray-200">
                    <h3 class="text-sm font-bold text-gray-800 mb-3 flex items-center gap-1.5">
                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.907c.961 0 1.36 1.252.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.772-.559-.373-1.81.588-1.81h4.906a1 1 0 00.95-.69l1.519-4.674z" />
                        </svg>
                        Spesifikasi Kustom Produk
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="rounded-xl border border-gray-100 bg-gray-50/60 p-3">
                            <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Ukuran</p>
                            <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ $order['specification']['ukuran'] ?? '-' }}</p>
                        </div>
                        <div class="rounded-xl border border-gray-100 bg-gray-50/60 p-3">
                            <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Material</p>
                            <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ $order['specification']['material'] ?? '-' }}</p>
                        </div>
                        <div class="rounded-xl border border-gray-100 bg-gray-50/60 p-3">
                            <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Finishing</p>
                            <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ $order['specification']['finishing'] ?? '-' }}</p>
                        </div>
                        <div class="rounded-xl border border-gray-100 bg-gray-50/60 p-3">
                            <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Catatan Klien</p>
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
        <div class="rounded-2xl bg-white border border-gray-200 shadow-sm p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-5 pb-3 border-b border-gray-100">
                Form Pembaruan
            </h2>

            <form action="{{ route('orders.update', $order['id']) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                {{-- Estimasi Biaya --}}
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-700">
                        Estimasi Biaya
                    </label>
                    <div class="relative rounded-xl shadow-sm">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <span class="text-sm font-bold text-gray-400">Rp</span>
                        </div>
                        <input
                            type="number"
                            name="estimasi_biaya"
                            value="{{ old('estimasi_biaya', $order['estimasi_biaya'] ?? '') }}"
                            class="w-full rounded-xl border border-gray-200 pl-11 pr-4 py-2.5 text-sm focus:border-amber-500 focus:ring-1 focus:ring-amber-500 focus:outline-none transition-all"
                            placeholder="Masukkan nominal biaya">
                    </div>
                </div>

                {{-- Estimasi Waktu --}}
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-700">
                        Estimasi Waktu Produksi
                    </label>
                    <input
                        type="text"
                        name="estimasi_waktu"
                        value="{{ old('estimasi_waktu', $order['estimasi_waktu'] ?? '') }}"
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-amber-500 focus:ring-1 focus:ring-amber-500 focus:outline-none transition-all"
                        placeholder="Contoh: 7-14 hari kerja">
                </div>

                {{-- Status Pesanan --}}
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-700">
                        Status Pesanan
                    </label>
                    <select
                        id="status_pesanan"
                        name="status_pesanan"
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-amber-500 focus:ring-1 focus:ring-amber-500 focus:outline-none transition-all bg-white">
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
                    <label class="mb-1.5 block text-sm font-semibold text-gray-700 flex justify-between items-center">
                        <span>Tahap Produksi saat Ini</span>
                        <span id="tahap_warning" class="text-xs font-normal text-rose-500 hidden">*Pilih Status 'Diproses' dahulu</span>
                    </label>
                    <select
                        id="tahap_produksi"
                        name="tahap_produksi"
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-amber-500 focus:ring-1 focus:ring-amber-500 focus:outline-none transition-all bg-white disabled:bg-gray-100 disabled:text-gray-400 disabled:cursor-not-allowed">

                        <option value="persiapan" {{ old('tahap_produksi', $order['latest_status']['status'] ?? $order['tahap_produksi'] ?? '') == 'persiapan' ? 'selected' : '' }}>
                            📦 Persiapan
                        </option>
                        <option value="pengukiran" {{ old('tahap_produksi', $order['latest_status']['status'] ?? $order['tahap_produksi'] ?? '') == 'pengukiran' ? 'selected' : '' }}>
                            🔨 Pengukiran
                        </option>
                        <option value="finishing" {{ old('tahap_produksi', $order['latest_status']['status'] ?? $order['tahap_produksi'] ?? '') == 'finishing' ? 'selected' : '' }}>
                            ✨ Finishing
                        </option>
                        <option value="selesai" {{ old('tahap_produksi', $order['latest_status']['status'] ?? $order['tahap_produksi'] ?? '') == 'selesai' ? 'selected' : '' }}>
                            ✅ Selesai
                        </option>
                    </select>
                </div>

                {{-- Catatan Produksi --}}
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-700">
                        Catatan Internal Produksi
                    </label>
                    <textarea
                        name="catatan"
                        rows="4"
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-amber-500 focus:ring-1 focus:ring-amber-500 focus:outline-none transition-all placeholder:text-gray-400"
                        placeholder="Tambahkan catatan progres detail pengerjaan ukiran/produk di sini...">{{ old('catatan', $order['catatan'] ?? '') }}</textarea>
                </div>

                {{-- Submit Actions --}}
                <div class="pt-2 space-y-3">
                    <button
                        type="submit"
                        class="w-full inline-flex justify-center items-center rounded-xl bg-amber-600 px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-amber-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-600 transition-colors">
                        Simpan Perubahan
                    </button>

                    <a href="{{ route('orders.index') }}"
                       class="w-full inline-flex justify-center items-center rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-gray-600 shadow-sm hover:bg-gray-50 transition-colors">
                        Kembali
                    </a>
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

    // SEBELUM SUBMIT: Aktifkan kembali input agar nilainya ikut terkirim ke Laravel
    form.addEventListener("submit", function () {
        if (statusPesanan.value === "diproses") {
            tahapProduksi.disabled = false;
        }
    });
});
</script>
@endsection
