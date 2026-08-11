@extends('layouts.app')

@section('title', 'Data Pesanan')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 animate-fade-in pb-12">

    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#3e2723] tracking-tight">
                Data Pesanan
            </h1>
            <p class="text-sm sm:text-base text-gray-500 mt-1">
                Kelola dan pantau seluruh data pesanan pelanggan Anda dengan mudah.
            </p>
        </div>

        {{-- Date Badge (Opsional, disamakan dengan Dashboard agar konsisten) --}}
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

    {{-- Card Main Container --}}
    <div class="bg-white rounded-2xl border border-[#eadfd8] shadow-sm overflow-hidden">

        {{-- Header Card (Filter & Search) --}}
        <div class="flex flex-col gap-4 border-b border-gray-100 p-6 sm:flex-row sm:items-center sm:justify-between bg-[#faf8f5]">
            <div>
                <h3 class="font-bold text-lg text-[#3e2723]">
                    Daftar Pesanan
                </h3>
                <p class="text-xs text-gray-400 mt-0.5">
                    Total <span class="text-[#5d4037] font-bold bg-[#efebe9] px-2.5 py-0.5 rounded-full border border-[#d7ccc8]">{{ is_array($orders) ? count($orders) : 0 }}</span> Pesanan
                </p>
            </div>

            {{-- Fitur Pencarian & Filter --}}
            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">

                {{-- Filter Dropdown --}}
                <div class="relative w-full sm:w-48">
                    <select id="filterStatus" class="w-full rounded-xl border border-gray-200 bg-white py-2.5 pl-4 pr-10 text-xs font-semibold text-gray-700 focus:border-[#5d4037] focus:ring-2 focus:ring-[#5d4037]/10 focus:outline-none shadow-sm transition-all appearance-none cursor-pointer">
                        <option value="">Semua Status</option>
                        <option value="menunggu_konfirmasi">Menunggu Konfirmasi</option>
                        <option value="diproses">Diproses</option>
                        <option value="selesai">Selesai</option>
                        <option value="dibatalkan">Dibatalkan</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                        <span class="material-symbols-outlined text-sm">expand_more</span>
                    </div>
                </div>

                {{-- Search Input --}}
                <div class="relative w-full sm:w-80">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
                        <span class="material-symbols-outlined text-sm">search</span>
                    </span>
                    <input
                        type="text"
                        id="searchOrder"
                        placeholder="Cari nama, produk, atau kode..."
                        class="w-full rounded-xl border border-gray-200 bg-white py-2.5 pl-10 pr-4 text-xs font-semibold text-gray-900 placeholder-gray-400 focus:border-[#5d4037] focus:ring-2 focus:ring-[#5d4037]/10 focus:outline-none shadow-sm transition-all">
                </div>
            </div>
        </div>

        {{-- Table Container --}}
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left text-sm" id="orderTable">
                <thead>
                    <tr class="bg-[#faf7f4] text-gray-500 text-xs font-semibold uppercase tracking-wider border-b border-gray-100">
                        <th class="py-3.5 px-6">Foto</th>
                        <th class="py-3.5 px-6">Pelanggan</th>
                        <th class="py-3.5 px-6">Produk</th>
                        <th class="py-3.5 px-6">Estimasi Biaya</th>
                        <th class="py-3.5 px-6">Tahap Produksi</th>
                        <th class="py-3.5 px-6">Status Transaksi</th>
                        <th class="py-3.5 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-xs">
                    @forelse($orders as $order)
                    <tr class="hover:bg-[#faf7f4]/60 transition-colors order-row" data-status="{{ strtolower($order['status_pesanan'] ?? '') }}">

                        {{-- Kolom Foto --}}
                        <td class="px-6 py-4">
                            @php
                                $firstItem = is_array($order) ? ($order['order_items'][0] ?? null) : ($order->orderItems->first() ?? null);
                                $gambarPath = null;
                                if (is_array($order)) {
                                    $gambarPath = $order['gambar'] ?? $order['foto'] ?? null;
                                    if (!$gambarPath && $firstItem) {
                                        $gambarPath = $firstItem['gambar'] ?? ($firstItem['product']['gambar'] ?? null);
                                    }
                                } else {
                                    $gambarPath = $order->gambar ?? $order->foto ?? null;
                                    if (!$gambarPath && $firstItem) {
                                        $gambarPath = $firstItem->gambar ?? ($firstItem->product->gambar ?? null);
                                    }
                                }
                            @endphp

                            @if($gambarPath)
                                <img src="{{ Str::startsWith($gambarPath, 'http') ? $gambarPath : (Str::startsWith($gambarPath, 'storage/') ? asset($gambarPath) : asset('storage/' . $gambarPath)) }}"
                                     alt="Foto Produk"
                                     class="w-12 h-12 object-cover rounded-xl border border-gray-200 shadow-sm"
                                     onerror="this.onerror=null; this.src='https://via.placeholder.com/150?text=No+Image';">
                            @else
                                <div class="w-12 h-12 rounded-xl bg-gray-50 border border-gray-200 flex items-center justify-center text-gray-400 text-[10px] font-bold">
                                    No Image
                                </div>
                            @endif
                        </td>

                        {{-- Pelanggan --}}
                        <td class="px-6 py-4">
                            <div class="max-w-xs truncate">
                                <p class="font-bold text-[#3e2723]">{{ $order['user']['nama'] ?? ($order['user']['name'] ?? '-') }}</p>
                                <p class="text-[11px] text-gray-400 font-medium mt-0.5">{{ $order['user']['email'] ?? '' }}</p>
                            </div>
                        </td>

                        {{-- Produk --}}
                        <td class="px-6 py-4">
                            <span class="font-medium text-gray-700">
                                @php
                                    $orderItems = is_array($order) ? ($order['order_items'] ?? ($order['items'] ?? [])) : ($order->orderItems ?? ($order->items ?? []));
                                    if(empty($orderItems) && (is_array($order) ? (isset($order['product']) || isset($order['nama_custom'])) : (isset($order->product) || isset($order->nama_custom)))) {
                                        $orderItems = [$order];
                                    }
                                @endphp

                                @if(count($orderItems) > 0)
                                    {{ collect($orderItems)->map(function($item) {
                                        $name = is_array($item) ? ($item['product']['nama_product'] ?? ($item['nama_custom'] ?? 'Pesanan Custom')) : ($item->product->nama_product ?? ($item->nama_custom ?? 'Pesanan Custom'));
                                        $qty = is_array($item) ? ($item['jumlah'] ?? 1) : ($item->jumlah ?? 1);
                                        return "{$name} ({$qty}x)";
                                    })->implode(', ') }}
                                @else
                                    Pesanan Custom
                                @endif
                            </span>
                        </td>

                        {{-- Estimasi Biaya --}}
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-lg bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-700 border border-emerald-200">
                                Rp {{ number_format($order['estimasi_biaya'] ?? 0, 0, ',', '.') }}
                            </span>
                        </td>

                        {{-- Tahap Produksi --}}
                        <td class="px-6 py-4">
                            @php
                                $statusPesanan = strtolower($order['status_pesanan'] ?? '');
                                $currentTahap = strtolower($order['latest_status']['status'] ?? 'persiapan');
                            @endphp

                            @if($statusPesanan == 'menunggu_konfirmasi')
                                <span class="inline-flex items-center rounded-lg bg-gray-50 px-2.5 py-1 font-semibold text-gray-600 border border-gray-200">
                                    ⏳ Belum Diproses
                                </span>
                            @elseif($statusPesanan == 'dibatalkan')
                                <span class="inline-flex items-center rounded-lg bg-rose-50 px-2.5 py-1 font-semibold text-rose-700 border border-rose-200">
                                    ❌ Dibatalkan
                                </span>
                            @elseif($statusPesanan == 'selesai')
                                <span class="inline-flex items-center rounded-lg bg-emerald-50 px-2.5 py-1 font-semibold text-emerald-700 border border-emerald-200">
                                    ✅ Selesai
                                </span>
                            @elseif($statusPesanan == 'diproses')
                                @if($currentTahap == 'persiapan')
                                    <span class="inline-flex items-center rounded-lg bg-gray-50 px-2.5 py-1 font-bold text-gray-700 border border-gray-200">
                                        📦 Persiapan
                                    </span>
                                @elseif($currentTahap == 'pengukiran')
                                    <span class="inline-flex items-center rounded-lg bg-amber-50 px-2.5 py-1 font-bold text-amber-700 border border-amber-200">
                                        🔨 Pengukiran
                                    </span>
                                @elseif($currentTahap == 'finishing')
                                    <span class="inline-flex items-center rounded-lg bg-purple-50 px-2.5 py-1 font-bold text-purple-700 border border-purple-200">
                                        ✨ Finishing
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-lg bg-gray-50 px-2.5 py-1 font-semibold text-gray-600 border border-gray-200">
                                        📦 Persiapan
                                    </span>
                                @endif
                            @endif
                        </td>

                        {{-- Status Transaksi --}}
                        <td class="px-6 py-4">
                            @php
                                $status = strtolower($order['status_pesanan'] ?? '');
                                $badgeStyle = match(true) {
                                    str_contains($status, 'selesai') => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    str_contains($status, 'proses')  => 'bg-blue-50 text-blue-700 border-blue-200',
                                    str_contains($status, 'batal')   => 'bg-rose-50 text-rose-700 border-rose-200',
                                    default => 'bg-amber-50 text-amber-700 border-amber-200',
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full font-semibold border text-xs {{ $badgeStyle }}">
                                {{ ucfirst(str_replace('_', ' ', $order['status_pesanan'] ?? 'menunggu')) }}
                            </span>
                        </td>

                        {{-- Aksi --}}
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center items-center gap-1.5">
                                <a href="{{ route('orders.show', $order['id']) }}"
                                class="inline-flex items-center justify-center px-3.5 py-1.5 bg-[#5d4037] hover:bg-[#3e2723] text-white text-xs font-semibold rounded-lg shadow-sm transition-colors"
                                title="Lihat Detail">
                                    Detail
                                </a>

                                <a href="{{ route('orders.edit', $order['id']) }}"
                                class="inline-flex items-center justify-center px-3.5 py-1.5 bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 text-xs font-semibold rounded-lg shadow-sm transition-colors"
                                title="Edit Pesanan">
                                    Edit
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr id="emptyRow">
                        <td colspan="7" class="py-16 text-center text-gray-400">
                            <span class="material-symbols-outlined text-4xl block mb-2 text-gray-300">inbox</span>
                            <p class="font-medium text-sm">Belum ada data pesanan yang tersedia.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Container --}}
        <div id="paginationContainer" class="flex flex-col sm:flex-row items-center justify-between px-6 py-4 border-t border-gray-100 bg-[#faf8f5] text-xs">
            <span id="paginationInfo" class="text-gray-500 mb-3 sm:mb-0 font-medium">Menampilkan 0 dari 0 data</span>
            <div id="paginationButtons" class="flex items-center gap-1.5">
                {{-- Tombol halaman di-generate otomatis via JS --}}
            </div>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchOrder');
    const filterStatus = document.getElementById('filterStatus');
    const rows = Array.from(document.querySelectorAll('#orderTable tbody tr.order-row'));
    const emptyRow = document.getElementById('emptyRow');
    const paginationInfo = document.getElementById('paginationInfo');
    const paginationButtons = document.getElementById('paginationButtons');

    let currentPage = 1;
    const rowsPerPage = 10;

    function updateTable() {
        const searchValue = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const statusValue = filterStatus ? filterStatus.value.toLowerCase() : '';

        const filteredRows = rows.filter(row => {
            const textContent = row.innerText.toLowerCase();
            const rowStatus = row.getAttribute('data-status') || '';

            const matchesSearch = textContent.includes(searchValue);
            const matchesFilter = statusValue === '' || rowStatus === statusValue;

            return matchesSearch && matchesFilter;
        });

        const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
        if (currentPage > totalPages && totalPages > 0) {
            currentPage = totalPages;
        } else if (currentPage < 1) {
            currentPage = 1;
        }

        rows.forEach(row => row.style.display = 'none');

        const startIndex = (currentPage - 1) * rowsPerPage;
        const endIndex = startIndex + rowsPerPage;
        const visibleRows = filteredRows.slice(startIndex, endIndex);

        visibleRows.forEach(row => row.style.display = '');

        if (emptyRow) {
            if (filteredRows.length === 0) {
                emptyRow.style.display = '';
                if (searchValue !== '' || statusValue !== '') {
                    emptyRow.querySelector('p').innerText = 'Tidak ada pesanan yang cocok dengan pencarian atau filter Anda.';
                } else {
                    emptyRow.querySelector('p').innerText = 'Belum ada data pesanan yang tersedia.';
                }
            } else {
                emptyRow.style.display = 'none';
            }
        }

        if (filteredRows.length > 0) {
            paginationInfo.innerText = `Menampilkan ${startIndex + 1} - ${Math.min(endIndex, filteredRows.length)} dari ${filteredRows.length} data`;
        } else {
            paginationInfo.innerText = `Menampilkan 0 dari 0 data`;
        }

        renderPaginationButtons(totalPages);
    }

    function renderPaginationButtons(totalPages) {
        paginationButtons.innerHTML = '';

        if (totalPages <= 1) return;

        const prevButton = document.createElement('button');
        prevButton.innerHTML = '&laquo; Prev';
        prevButton.className = `px-3 py-1.5 rounded-lg border font-bold transition-colors ${currentPage === 1 ? 'bg-gray-100 text-gray-300 border-gray-200 cursor-not-allowed' : 'bg-white text-gray-700 border-gray-200 hover:bg-[#5d4037] hover:text-white hover:border-[#5d4037]'}`;
        prevButton.disabled = currentPage === 1;
        prevButton.addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                updateTable();
            }
        });
        paginationButtons.appendChild(prevButton);

        for (let i = 1; i <= totalPages; i++) {
            const pageButton = document.createElement('button');
            pageButton.innerText = i;
            pageButton.className = `px-3 py-1.5 rounded-lg border font-bold transition-colors ${currentPage === i ? 'bg-[#5d4037] text-white border-[#5d4037]' : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-100'}`;
            pageButton.addEventListener('click', () => {
                currentPage = i;
                updateTable();
            });
            paginationButtons.appendChild(pageButton);
        }

        const nextButton = document.createElement('button');
        nextButton.innerHTML = 'Next &raquo;';
        nextButton.className = `px-3 py-1.5 rounded-lg border font-bold transition-colors ${currentPage === totalPages ? 'bg-gray-100 text-gray-300 border-gray-200 cursor-not-allowed' : 'bg-white text-gray-700 border-gray-200 hover:bg-[#5d4037] hover:text-white hover:border-[#5d4037]'}`;
        nextButton.disabled = currentPage === totalPages;
        nextButton.addEventListener('click', () => {
            if (currentPage < totalPages) {
                currentPage++;
                updateTable();
            }
        });
        paginationButtons.appendChild(nextButton);
    }

    if (searchInput) {
        searchInput.addEventListener('input', () => {
            currentPage = 1;
            updateTable();
        });
    }

    if (filterStatus) {
        filterStatus.addEventListener('change', () => {
            currentPage = 1;
            updateTable();
        });
    }

    updateTable();
});
</script>

@push('scripts')
<script type="module">
    if (window.Echo) {
        window.Echo.channel('orders')
            .listen('OrderCreated', (e) => {
                console.log('Pesanan baru terdeteksi:', e.order);
                alert('Ada pesanan baru! Halaman akan diperbarui.');
                window.location.reload();
            });
    }
</script>
@endpush
@endsection
