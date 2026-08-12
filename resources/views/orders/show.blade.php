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

        <a href="{{ route('orders.edit', is_array($order) ? $order['id'] : $order->id) }}"
           class="inline-flex items-center justify-center rounded-xl bg-[#5d4037] hover:bg-[#3e2723] px-5 py-3 text-sm font-bold text-white shadow-sm transition-colors">
            <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
            </svg>
            Edit Pesanan
        </a>
    </div>

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3 items-start">

        {{-- Informasi Utama (Kolom Kiri - 2 Span) --}}
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
                            {{ is_array($order) ? ($order['kode_pesanan'] ?? '-') : ($order->kode_pesanan ?? '-') }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center py-3.5">
                        <span class="font-medium text-gray-500">Tanggal Pesanan</span>
                        <span class="font-bold text-gray-800">
                            @php
                                $tgl = is_array($order) ? ($order['tanggal_pesanan'] ?? null) : ($order->tanggal_pesanan ?? null);
                            @endphp
                            {{ $tgl ? \Carbon\Carbon::parse($tgl)->format('d-m-Y H:i') : '-' }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center py-3.5">
                        <span class="font-medium text-gray-500">Status</span>
                        @php
                            $stVal = is_array($order) ? ($order['status_pesanan'] ?? '') : ($order->status_pesanan ?? '');
                            $status = strtolower($stVal);
                            $badgeStyle = match(true) {
                                str_contains($status, 'selesai') => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                str_contains($status, 'proses')  => 'bg-blue-50 text-blue-700 border-blue-200',
                                str_contains($status, 'batal')   => 'bg-rose-50 text-rose-700 border-rose-200',
                                default => 'bg-amber-50 text-amber-700 border-amber-200',
                            };
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $badgeStyle }}">
                            {{ ucfirst(str_replace('_', ' ', $stVal ?: 'menunggu')) }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center py-3.5">
                        <span class="font-medium text-gray-500">Estimasi Biaya</span>
                        <span class="text-base font-extrabold text-emerald-700">
                            Rp {{ number_format(is_array($order) ? ($order['estimasi_biaya'] ?? 0) : ($order->estimasi_biaya ?? 0), 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center py-3.5">
                        <span class="font-medium text-gray-500">Jumlah DP (Uang Muka)</span>
                        <span class="text-base font-bold text-amber-700">
                            Rp {{ number_format(is_array($order) ? ($order['jumlah_dp'] ?? 0) : ($order->jumlah_dp ?? 0), 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center py-3.5">
                        <span class="font-medium text-gray-500">Status Pembayaran</span>
                        @php
                            $stBayarVal = is_array($order) ? ($order['status_pembayaran'] ?? 'belum_bayar') : ($order->status_pembayaran ?? 'belum_bayar');
                            $statusBayar = strtolower($stBayarVal);
                            $badgeBayarStyle = match($statusBayar) {
                                'lunas' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                'dp_dibayar' => 'bg-amber-50 text-amber-700 border-amber-200',
                                default => 'bg-gray-100 text-gray-600 border-gray-200',
                            };
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border {{ $badgeBayarStyle }}">
                            {{ ucfirst(str_replace('_', ' ', $statusBayar)) }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center py-3.5">
                        <span class="font-medium text-gray-500">Estimasi Waktu</span>
                        <span class="font-semibold text-gray-800">
                            {{ is_array($order) ? ($order['estimasi_waktu'] ?? '-') : ($order->estimasi_waktu ?? '-') }}
                        </span>
                    </div>

                    {{-- Perkiraan Tanggal Selesai --}}
                    <div class="flex justify-between items-center py-3.5 last:pb-0">
                        <span class="font-medium text-gray-500">Perkiraan Tanggal Selesai</span>
                        <span class="font-bold text-[#5d4037] bg-amber-50 px-2.5 py-1 rounded-lg border border-amber-200">
                            @php
                                $estimasiSelesai = is_array($order) ? ($order['estimasi_selesai'] ?? null) : ($order->estimasi_selesai ?? null);
                            @endphp
                            {{ $estimasiSelesai ? \Carbon\Carbon::parse($estimasiSelesai)->format('d-m-Y') : 'Belum ditentukan' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Daftar Produk Pesanan (Mendukung Multi-Item & Multi-Gambar) --}}
            @php
                $orderItems = is_array($order)
                    ? ($order['order_items'] ?? ($order['items'] ?? []))
                    : ($order->orderItems ?? ($order->items ?? []));

                if(empty($orderItems) && (is_array($order) ? (isset($order['product']) || isset($order['nama_custom'])) : (isset($order->product) || isset($order->nama_custom)))) {
                    $orderItems = [$order];
                }
            @endphp

            <div class="rounded-2xl bg-white border border-[#eadfd8] shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-[#e5ddd8] bg-[#faf8f5] flex justify-between items-center">
                    <h2 class="text-base font-bold text-[#3e2723]">Daftar Produk Pesanan</h2>
                    <span class="text-xs font-bold bg-[#efebe9] text-[#5d4037] px-2.5 py-1 rounded-lg border border-[#d7ccc8]">
                        {{ count($orderItems) }} Item
                    </span>
                </div>

                <div class="p-6 space-y-4">
                    @forelse($orderItems as $item)
                        @php
                            $prodName = is_array($item)
                                ? ($item['product']['nama_product'] ?? ($item['nama_custom'] ?? 'Produk Custom'))
                                : ($item->product->nama_product ?? ($item->nama_custom ?? 'Produk Custom'));

                            $jumlah = is_array($item) ? ($item['jumlah'] ?? 1) : ($item->jumlah ?? 1);
                            $ukuran = is_array($item) ? ($item['ukuran'] ?? ($item['specification']['ukuran'] ?? '-')) : ($item->ukuran ?? ($item->specification->ukuran ?? '-'));
                            $material = is_array($item) ? ($item['material'] ?? ($item['specification']['material'] ?? '-')) : ($item->material ?? ($item->specification->material ?? '-'));
                            $motif = is_array($item) ? ($item['motif_ukiran'] ?? ($item['motif'] ?? ($item['specification']['motif_ukiran'] ?? '-'))) : ($item->motif_ukiran ?? ($item->motif ?? ($item->specification->motif_ukiran ?? '-')));
                            $subtotal = is_array($item) ? ($item['subtotal'] ?? ($item['estimasi_biaya'] ?? 0)) : ($item->subtotal ?? ($item->estimasi_biaya ?? 0));

                            $rawImages = [];
                            $orderImg = is_array($order) ? ($order['gambar'] ?? null) : ($order->gambar ?? null);
                            if ($orderImg) $rawImages[] = $orderImg;

                            $itemImg = is_array($item) ? ($item['gambar'] ?? null) : ($item->gambar ?? null);
                            if ($itemImg) $rawImages[] = $itemImg;

                            $prodImg = is_array($item) ? ($item['product']['gambar'] ?? null) : ($item->product->gambar ?? null);
                            if ($prodImg) $rawImages[] = $prodImg;

                            $allImages = array_unique($rawImages);
                        @endphp

                        <div class="rounded-xl border border-[#eadfd8] bg-[#faf8f5] p-4 space-y-3">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                                <div class="flex items-center gap-3">
                                    @if(count($allImages) > 0)
                                        <div class="flex items-center gap-2 flex-wrap">
                                            @foreach($allImages as $imgSrc)
                                                @php
                                                    $formattedImg = Str::startsWith($imgSrc, 'http') ? $imgSrc : asset('storage/' . str_replace('storage/', '', $imgSrc));
                                                @endphp
                                                <img src="{{ $formattedImg }}" alt="Produk" class="w-16 h-16 object-cover rounded-xl border border-gray-200 shadow-sm cursor-pointer hover:scale-105 transition-transform" onclick="window.open('{{ $formattedImg }}', '_blank')" onerror="this.onerror=null; this.src='https://via.placeholder.com/150?text=No+Image';">
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="w-16 h-16 rounded-xl bg-gray-100 border border-gray-200 flex items-center justify-center text-gray-400 text-xs font-bold">No Image</div>
                                    @endif

                                    <div>
                                        <h3 class="font-bold text-[#3e2723] text-sm">{{ $prodName }}</h3>
                                        <p class="text-xs text-gray-500 mt-0.5">Jumlah: <span class="font-bold text-gray-700">{{ $jumlah }} Pcs</span></p>
                                    </div>
                                </div>
                                @if($subtotal > 0)
                                    <span class="text-xs font-extrabold text-amber-700 bg-amber-50 px-2.5 py-1 rounded-lg border border-amber-200">
                                        Rp {{ number_format($subtotal, 0, ',', '.') }}
                                    </span>
                                @endif
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 pt-2 border-t border-[#eadfd8]/60 text-xs">
                                <div><span class="text-gray-400 font-semibold block text-[10px] uppercase">Ukuran</span><span class="font-medium text-gray-700">{{ $ukuran }}</span></div>
                                <div><span class="text-gray-400 font-semibold block text-[10px] uppercase">Material</span><span class="font-medium text-gray-700">{{ $material }}</span></div>
                                <div><span class="text-gray-400 font-semibold block text-[10px] uppercase">Motif Ukiran</span><span class="font-medium text-gray-700">{{ $motif }}</span></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-gray-400 italic text-center py-4">Tidak ada produk dalam pesanan ini.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Sidebar (Kolom Kanan - 1 Span) --}}
        <div class="space-y-6">
            {{-- Data Pelanggan --}}
            <div class="rounded-2xl bg-white border border-[#eadfd8] shadow-sm p-6">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="p-2.5 bg-[#efebe9] text-[#5d4037] rounded-xl border border-[#d7ccc8]">
                        <span class="material-symbols-outlined text-xl">person</span>
                    </div>
                    <h2 class="text-base font-bold text-[#3e2723]">Data Pelanggan</h2>
                </div>

                <div class="bg-[#faf8f5] rounded-xl p-4 border border-[#eadfd8]">
                    @php
                        $userData = is_array($order) ? ($order['user'] ?? null) : ($order->user ?? null);
                        $namaPelanggan = is_array($userData) ? ($userData['nama'] ?? ($userData['name'] ?? '-')) : ($userData->nama ?? ($userData->name ?? '-'));
                        $emailPelanggan = is_array($userData) ? ($userData['email'] ?? '-') : ($userData->email ?? '-');

                        // Ekstraksi dan format nomor HP pelanggan
                        $rawPhone = is_array($userData) ? ($userData['no_hp'] ?? ($userData['phone'] ?? null)) : ($userData->no_hp ?? ($userData->phone ?? null));
                        $cleanPhone = null;
                        if ($rawPhone) {
                            $cleanPhone = preg_replace('/[^0-9]/', '', $rawPhone);
                            if (str_starts_with($cleanPhone, '0')) {
                                $cleanPhone = '62' . substr($cleanPhone, 1);
                            }
                        }

                        // Data Pesanan
                        $kodePsn = is_array($order) ? ($order['kode_pesanan'] ?? '-') : ($order->kode_pesanan ?? '-');
                        $estBiaya = is_array($order) ? ($order['estimasi_biaya'] ?? 0) : ($order->estimasi_biaya ?? 0);
                        $fmtBiaya = number_format($estBiaya, 0, ',', '.');

                        // Ekstraksi Detail Item Produk
                        $orderItems = is_array($order)
                            ? ($order['order_items'] ?? ($order['items'] ?? []))
                            : ($order->orderItems ?? ($order->items ?? []));

                        if(empty($orderItems) && (is_array($order) ? (isset($order['product']) || isset($order['nama_custom'])) : (isset($order->product) || isset($order->nama_custom)))) {
                            $orderItems = [$order];
                        }

                        $detailProdukText = "";
                        if (!empty($orderItems)) {
                            $i = 1;
                            foreach ($orderItems as $item) {
                                $pName = is_array($item)
                                    ? ($item['product']['nama_product'] ?? ($item['nama_custom'] ?? 'Produk Custom'))
                                    : ($item->product->nama_product ?? ($item->nama_custom ?? 'Produk Custom'));

                                $qty = is_array($item) ? ($item['jumlah'] ?? 1) : ($item->jumlah ?? 1);
                                $ukuran = is_array($item) ? ($item['ukuran'] ?? ($item['specification']['ukuran'] ?? '-')) : ($item->ukuran ?? ($item->specification->ukuran ?? '-'));
                                $material = is_array($item) ? ($item['material'] ?? ($item['specification']['material'] ?? '-')) : ($item->material ?? ($item->specification->material ?? '-'));

                                $detailProdukText .= "\n- {$i}. *{$pName}* ({$qty} Pcs) | Ukuran: {$ukuran} | Bahan: {$material}";
                                $i++;
                            }
                        } else {
                            $detailProdukText = "\n- Pesanan Custom";
                        }

                        // Susun Pesan otomatis dari Owner ke Pelanggan yang rapi
                        $waMessage = "Halo *$namaPelanggan*, saya Owner Adi Ukiran. Saya ingin mendiskusikan progres pengerjaan pesanan Anda dengan nomor *$kodePsn*.\n\n*Detail Pesanan:*$detailProdukText\n\n*Total Biaya:* Rp $fmtBiaya";

                        $waUrl = $cleanPhone ? "https://wa.me/$cleanPhone?text=" . urlencode($waMessage) : null;
                    @endphp

                    <p class="font-bold text-gray-900 text-sm">{{ $namaPelanggan }}</p>
                    <p class="mt-1 text-xs text-gray-500 font-medium">{{ $emailPelanggan }}</p>
                    @if($rawPhone)
                        <p class="mt-1 text-xs text-gray-500 font-medium">{{ $rawPhone }}</p>
                    @endif
                </div>

                {{-- Tombol Chat WhatsApp --}}
                <div class="mt-4">
                    @if($cleanPhone)
                        <a href="{{ $waUrl }}" target="_blank" class="flex items-center justify-center w-full rounded-xl bg-[#25D366] hover:bg-[#1DA851] px-4 py-2.5 text-sm font-bold text-white shadow-sm transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                            Hubungi via WhatsApp
                        </a>
                    @else
                        <div class="p-3 bg-red-50 text-red-600 rounded-xl text-xs font-medium border border-red-100 text-center">
                            Nomor HP pelanggan tidak tersedia di sistem.
                        </div>
                    @endif
                </div>
            </div>


            {{-- Catatan Produksi --}}
            <div class="rounded-2xl bg-white border border-[#eadfd8] shadow-sm p-6">
                <h2 class="mb-3 text-base font-bold text-[#3e2723] flex items-center gap-2">
                    <span class="material-symbols-outlined text-amber-700 text-lg">description</span>
                    Catatan Produksi
                </h2>
                <div class="text-sm text-gray-600 bg-amber-50/50 border border-amber-200/60 p-4 rounded-xl italic">
                    "{{ is_array($order) ? ($order['catatan'] ?? 'Belum ada catatan khusus untuk pesanan ini.') : ($order->catatan ?? 'Belum ada catatan khusus untuk pesanan ini.') }}"
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
