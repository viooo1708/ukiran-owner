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

    @php
        $statusPesananAktif = is_array($order) ? ($order['status_pesanan'] ?? '') : ($order->status_pesanan ?? '');
        $isCancelled = ($statusPesananAktif === 'dibatalkan');
    @endphp

    {{-- Alert jika pesanan dibatalkan --}}
    @if($isCancelled)
        <div class="rounded-2xl bg-rose-50 border border-rose-200 p-4 text-rose-800 text-sm flex items-center gap-3">
            <span class="material-symbols-outlined text-rose-600">error</span>
            <div>
                <span class="font-bold">Pesanan Telah Dibatalkan oleh Pelanggan.</span>
                Formulir di bawah ini dikunci dan tidak dapat diubah kembali.
            </div>
        </div>
    @endif

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
                        #{{ is_array($order) ? ($order['id'] ?? '-') : ($order->id ?? '-') }}
                    </span>
                </div>

                <div class="flex justify-between items-center py-3.5">
                    <span class="font-medium text-gray-500">Kode Pesanan</span>
                    <span class="font-mono font-bold text-[#5d4037]">
                        {{ is_array($order) ? ($order['kode_pesanan'] ?? '-') : ($order->kode_pesanan ?? '-') }}
                    </span>
                </div>

                <div class="flex justify-between items-center py-3.5">
                    <span class="font-medium text-gray-500">Pelanggan</span>
                    @php
                        $user = is_array($order) ? ($order['user'] ?? null) : ($order->user ?? null);
                    @endphp
                    <span class="font-bold text-gray-800">{{ is_array($user) ? ($user['nama'] ?? ($user['name'] ?? '-')) : ($user->nama ?? ($user->name ?? '-')) }}</span>
                </div>

                <div class="flex justify-between items-center py-3.5">
                    <span class="font-medium text-gray-500">Email</span>
                    <span class="text-gray-600">{{ is_array($user) ? ($user['email'] ?? '-') : ($user->email ?? '-') }}</span>
                </div>

                {{-- Daftar Produk Pesanan (Multi-Item / Keranjang) --}}
                <div class="py-4">
                    <span class="font-medium text-gray-500 block mb-2">Daftar Produk Pesanan</span>
                    @php
                        $orderItems = is_array($order)
                            ? ($order['order_items'] ?? ($order['items'] ?? []))
                            : ($order->orderItems ?? ($order->items ?? []));

                        if(empty($orderItems) && (is_array($order) ? (isset($order['product']) || isset($order['nama_custom'])) : (isset($order->product) || isset($order->nama_custom)))) {
                            $orderItems = [$order];
                        }
                    @endphp

                    <div class="space-y-2.5">
                        @forelse($orderItems as $item)
                            @php
                                $pName = is_array($item) ? ($item['product']['nama_product'] ?? ($item['nama_custom'] ?? 'Produk Custom')) : ($item->product->nama_product ?? ($item->nama_custom ?? 'Produk Custom'));
                                $qty = is_array($item) ? ($item['jumlah'] ?? 1) : ($item->jumlah ?? 1);
                                $sub = is_array($item) ? ($item['subtotal'] ?? ($item['estimasi_biaya'] ?? 0)) : ($item->subtotal ?? ($item->estimasi_biaya ?? 0));
                                $dimen = is_array($item) ? ($item['ukuran'] ?? ($item['specification']['ukuran'] ?? '-')) : ($item->ukuran ?? ($item->specification->ukuran ?? '-'));
                                $mat = is_array($item) ? ($item['material'] ?? ($item['specification']['material'] ?? '-')) : ($item->material ?? ($item->specification->material ?? '-'));
                            @endphp
                            <div class="p-3 bg-[#faf8f5] border border-[#eadfd8] rounded-xl text-xs space-y-1">
                                <div class="flex justify-between font-bold text-[#3e2723]">
                                    <span>{{ $pName }} ({{ $qty }} Pcs)</span>
                                    @if($sub > 0)
                                        <span class="text-amber-700">Rp {{ number_format($sub, 0, ',', '.') }}</span>
                                    @endif
                                </div>
                                <p class="text-gray-500">Ukuran: {{ $dimen }} | Material: {{ $mat }}</p>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 italic">Tidak ada produk.</p>
                        @endforelse
                    </div>
                </div>

                <div class="flex justify-between items-center py-3.5">
                    <span class="font-medium text-gray-500">Estimasi Biaya Saat Ini</span>
                    <span class="font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-200">
                        Rp {{ number_format(is_array($order) ? ($order['estimasi_biaya'] ?? 0) : ($order->estimasi_biaya ?? 0), 0, ',', '.') }}
                    </span>
                </div>

                <div class="flex justify-between items-center py-3.5 last:pb-0">
                    <span class="font-medium text-gray-500">Jumlah DP (Uang Muka)</span>
                    <span class="font-bold text-amber-700 bg-amber-50 px-2.5 py-1 rounded-lg border border-amber-200">
                        Rp {{ number_format(is_array($order) ? ($order['jumlah_dp'] ?? 0) : ($order->jumlah_dp ?? 0), 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Form Update Side-Card --}}
        <div class="rounded-2xl bg-white border border-[#eadfd8] shadow-sm p-6">
            <h2 class="text-base font-bold text-[#3e2723] mb-5 pb-3 border-b border-[#e5ddd8]">
                Form Pembaruan Status
            </h2>

            <form action="{{ route('orders.update', is_array($order) ? $order['id'] : $order->id) }}" method="POST" class="space-y-4">
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
                            value="{{ old('estimasi_biaya', is_array($order) ? ($order['estimasi_biaya'] ?? '') : ($order->estimasi_biaya ?? '')) }}"
                            {{ $isCancelled ? 'disabled' : '' }}
                            class="w-full rounded-xl border border-gray-200 pl-11 pr-4 py-2.5 text-sm focus:border-[#5d4037] focus:ring-2 focus:ring-[#5d4037]/10 focus:outline-none transition-all font-semibold text-gray-800 disabled:bg-gray-100 disabled:text-gray-400 disabled:cursor-not-allowed"
                            placeholder="Nominal biaya">
                    </div>
                </div>

                {{-- Jumlah DP (Uang Muka) --}}
                <div>
                    <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-gray-600">
                        Jumlah DP (Uang Muka) (Rp)
                    </label>
                    <div class="relative rounded-xl shadow-sm">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <span class="text-xs font-bold text-gray-400">Rp</span>
                        </div>
                        <input
                            type="number"
                            name="jumlah_dp"
                            value="{{ old('jumlah_dp', is_array($order) ? ($order['jumlah_dp'] ?? '') : ($order->jumlah_dp ?? '')) }}"
                            {{ $isCancelled ? 'disabled' : '' }}
                            class="w-full rounded-xl border border-gray-200 pl-11 pr-4 py-2.5 text-sm focus:border-[#5d4037] focus:ring-2 focus:ring-[#5d4037]/10 focus:outline-none transition-all font-semibold text-gray-800 disabled:bg-gray-100 disabled:text-gray-400 disabled:cursor-not-allowed"
                            placeholder="Nominal DP yang dibayar">
                    </div>
                </div>

                {{-- Status Pembayaran --}}
                <div>
                    <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-gray-600">
                        Status Pembayaran
                    </label>
                    <select
                        name="status_pembayaran"
                        {{ $isCancelled ? 'disabled' : '' }}
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-[#5d4037] focus:ring-2 focus:ring-[#5d4037]/10 focus:outline-none transition-all bg-white font-medium text-gray-800 disabled:bg-gray-100 disabled:text-gray-400 disabled:cursor-not-allowed">
                        <option value="belum_bayar" {{ old('status_pembayaran', is_array($order) ? ($order['status_pembayaran'] ?? '') : ($order->status_pembayaran ?? '')) == 'belum_bayar' ? 'selected' : '' }}>Belum Bayar</option>
                        <option value="dp_dibayar" {{ old('status_pembayaran', is_array($order) ? ($order['status_pembayaran'] ?? '') : ($order->status_pembayaran ?? '')) == 'dp_dibayar' ? 'selected' : '' }}>DP Dibayar</option>
                        <option value="lunas" {{ old('status_pembayaran', is_array($order) ? ($order['status_pembayaran'] ?? '') : ($order->status_pembayaran ?? '')) == 'lunas' ? 'selected' : '' }}>Lunas</option>
                    </select>
                </div>

                {{-- Perkiraan Tanggal Selesai --}}
                <div>
                    <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-gray-600">
                        Perkiraan Tanggal Selesai
                    </label>
                    @php
                        $rawTglSelesai = is_array($order) ? ($order['estimasi_selesai'] ?? '') : ($order->estimasi_selesai ?? '');
                        $formattedTglSelesai = $rawTglSelesai ? \Carbon\Carbon::parse($rawTglSelesai)->format('Y-m-d') : '';
                    @endphp
                    <input
                        type="date"
                        id="estimasi_selesai"
                        name="estimasi_selesai"
                        value="{{ old('estimasi_selesai', $formattedTglSelesai) }}"
                        {{ $isCancelled ? 'disabled' : '' }}
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-[#5d4037] focus:ring-2 focus:ring-[#5d4037]/10 focus:outline-none transition-all font-semibold text-gray-800 disabled:bg-gray-100 disabled:text-gray-400 disabled:cursor-not-allowed">
                </div>

                {{-- Estimasi Waktu --}}
                <div>
                    <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-gray-600 flex justify-between items-center">
                        <span>Estimasi Waktu Produksi</span>
                        <span class="text-[10px] text-gray-400 font-normal">*(Otomatis dari tanggal selesai)</span>
                    </label>
                    <input
                        type="text"
                        id="estimasi_waktu"
                        name="estimasi_waktu"
                        value="{{ old('estimasi_waktu', is_array($order) ? ($order['estimasi_waktu'] ?? '') : ($order->estimasi_waktu ?? '')) }}"
                        {{ $isCancelled ? 'disabled' : '' }}
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-[#5d4037] focus:ring-2 focus:ring-[#5d4037]/10 focus:outline-none transition-all disabled:bg-gray-100 disabled:text-gray-400 disabled:cursor-not-allowed bg-gray-50 font-medium text-gray-700"
                        placeholder="Pilih tanggal selesai di atas...">
                </div>

                {{-- Status Pesanan --}}
                <div>
                    <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-gray-600">
                        Status Pesanan
                    </label>
                    <select
                        id="status_pesanan"
                        name="status_pesanan"
                        {{ $isCancelled ? 'disabled' : '' }}
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-[#5d4037] focus:ring-2 focus:ring-[#5d4037]/10 focus:outline-none transition-all bg-white font-medium text-gray-800 disabled:bg-gray-100 disabled:text-gray-400 disabled:cursor-not-allowed">
                        <option value="menunggu_konfirmasi" {{ old('status_pesanan', is_array($order) ? ($order['status_pesanan'] ?? '') : ($order->status_pesanan ?? '')) == 'menunggu_konfirmasi' ? 'selected' : '' }}>
                            Menunggu Konfirmasi
                        </option>
                        <option value="diproses" {{ old('status_pesanan', is_array($order) ? ($order['status_pesanan'] ?? '') : ($order->status_pesanan ?? '')) == 'diproses' ? 'selected' : '' }}>
                            Diproses
                        </option>
                        <option value="selesai" {{ old('status_pesanan', is_array($order) ? ($order['status_pesanan'] ?? '') : ($order->status_pesanan ?? '')) == 'selesai' ? 'selected' : '' }}>
                            Selesai
                        </option>
                        <option value="dibatalkan" {{ old('status_pesanan', is_array($order) ? ($order['status_pesanan'] ?? '') : ($order->status_pesanan ?? '')) == 'dibatalkan' ? 'selected' : '' }}>
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
                        {{ $isCancelled ? 'disabled' : '' }}
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-[#5d4037] focus:ring-2 focus:ring-[#5d4037]/10 focus:outline-none transition-all bg-white font-medium text-gray-800 disabled:bg-gray-100 disabled:text-gray-400 disabled:cursor-not-allowed">

                        @php
                            $activeTahap = old('tahap_produksi', is_array($order) ? ($order['latest_status']['status'] ?? ($order['tahap_produksi'] ?? 'persiapan')) : ($order->latest_status->status ?? ($order->tahap_produksi ?? 'persiapan')));
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
                        {{ $isCancelled ? 'disabled' : '' }}
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-[#5d4037] focus:ring-2 focus:ring-[#5d4037]/10 focus:outline-none transition-all placeholder:text-gray-400 disabled:bg-gray-100 disabled:text-gray-400 disabled:cursor-not-allowed"
                        placeholder="Tambahkan catatan progres detail pengerjaan ukiran/produk di sini...">{{ old('catatan', is_array($order) ? ($order['catatan'] ?? '') : ($order->catatan ?? '')) }}</textarea>
                </div>

                {{-- Submit Actions --}}
                <div class="pt-3">
                    @if(!$isCancelled)
                        <button
                            type="submit"
                            class="w-full inline-flex justify-center items-center rounded-xl bg-[#5d4037] hover:bg-[#3e2723] px-4 py-3 text-sm font-bold text-white shadow-sm transition-colors">
                            Simpan Perubahan
                        </button>
                    @else
                        <button
                            type="button"
                            disabled
                            class="w-full inline-flex justify-center items-center rounded-xl bg-gray-200 px-4 py-3 text-sm font-bold text-gray-400 cursor-not-allowed">
                            Pesanan Dibatalkan (Tidak Dapat Disimpan)
                        </button>
                    @endif
                </div>
            </form>
        </div>

    </div>
</div>

{{-- Skrip JavaScript untuk Kalkulasi Otomatis & Penanganan Tahap Produksi --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    const statusPesanan = document.getElementById("status_pesanan");
    const tahapProduksi = document.getElementById("tahap_produksi");
    const tahapWarning = document.getElementById("tahap_warning");
    const estimasiSelesaiInput = document.getElementById("estimasi_selesai");
    const estimasiWaktuInput = document.getElementById("estimasi_waktu");
    const form = statusPesanan.closest('form');

    @if($isCancelled)
        return;
    @endif

    function calculateEstimasiWaktu() {
        const selectedDate = estimasiSelesaiInput.value;
        if (!selectedDate) return;

        const targetDate = new Date(selectedDate);
        const today = new Date();

        today.setHours(0, 0, 0, 0);
        targetDate.setHours(0, 0, 0, 0);

        const diffTime = targetDate - today;
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

        if (diffDays > 0) {
            estimasiWaktuInput.value = `${diffDays} hari lagi`;
        } else if (diffDays === 0) {
            estimasiWaktuInput.value = `Hari ini`;
        } else {
            estimasiWaktuInput.value = `Sudah lewat / Selesai`;
        }
    }

    if (estimasiSelesaiInput) {
        estimasiSelesaiInput.addEventListener("change", calculateEstimasiWaktu);
    }

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
