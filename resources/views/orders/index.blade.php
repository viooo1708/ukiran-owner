@extends('layouts.app')

@section('title', 'Pesanan')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 animate-fade-in pb-12">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#3e2723] tracking-tight">Data Pesanan</h1>
            <p class="mt-1 text-sm text-gray-500">Kelola dan pantau seluruh data pesanan pelanggan Anda dengan mudah.</p>
        </div>
    </div>

    {{-- Card Main Container --}}
    <div class="bg-white rounded-2xl border border-[#eadfd8] shadow-sm overflow-hidden">

        {{-- Header Card --}}
        <div class="flex flex-col gap-4 border-b border-[#e5ddd8] p-6 sm:flex-row sm:items-center sm:justify-between bg-[#faf8f5]">
            <div>
                <h2 class="text-lg font-bold text-[#3e2723]">Daftar Pesanan</h2>
                <p class="text-xs font-semibold text-gray-500 mt-0.5">
                    Total <span class="text-[#5d4037] font-bold bg-[#efebe9] px-2.5 py-0.5 rounded-full border border-[#d7ccc8]">{{ is_array($orders) ? count($orders) : 0 }}</span> Pesanan
                </p>
            </div>

            {{-- Fitur Pencarian & Filter --}}
            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">

                {{-- Filter Dropdown --}}
                <div class="relative w-full sm:w-48">
                    <select id="filterStatus" class="w-full rounded-xl border border-gray-200 bg-white py-2.5 pl-4 pr-10 text-xs font-medium text-gray-700 focus:border-[#5d4037] focus:ring-2 focus:ring-[#5d4037]/10 focus:outline-none shadow-sm transition-all appearance-none cursor-pointer">
                        <option value="">Semua Status</option>
                        <option value="menunggu_konfirmasi">Menunggu Konfirmasi</option>
                        <option value="diproses">Diproses</option>
                        <option value="selesai">Selesai</option>
                        <option value="dibatalkan">Dibatalkan</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                {{-- Search Input --}}
                <div class="relative w-full sm:w-80">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input
                        type="text"
                        id="searchOrder"
                        placeholder="Cari nama, produk, atau kode..."
                        class="w-full rounded-xl border border-gray-200 bg-white py-2.5 pl-10 pr-4 text-xs font-medium text-gray-900 placeholder-gray-400 focus:border-[#5d4037] focus:ring-2 focus:ring-[#5d4037]/10 focus:outline-none shadow-sm transition-all">
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left text-sm" id="orderTable">
                <thead>
                    <tr class="bg-[#faf7f4] text-gray-500 text-xs font-semibold uppercase tracking-wider border-b border-gray-100">
                        <!-- <th class="py-4 px-6">ID</th> -->
                        <th class="py-4 px-6">Pelanggan</th>
                        <th class="py-4 px-6">Produk</th>
                        <th class="py-4 px-6">Estimasi Biaya</th>
                        <th class="py-4 px-6">Tahap Produksi</th>
                        <th class="py-4 px-6">Status Transaksi</th>
                        <th class="py-4 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($orders as $order)
                    <tr class="hover:bg-[#faf7f4]/60 transition-colors order-row" data-status="{{ strtolower($order['status_pesanan'] ?? '') }}">
                        <!-- <td class="px-6 py-4 font-mono text-xs font-bold text-[#5d4037]">
                            #{{ $order['id'] }}
                        </td> -->
                        <td class="px-6 py-4">
                            <div class="max-w-xs truncate">
                                <p class="font-bold text-sm text-gray-900">{{ $order['user']['nama'] ?? '-' }}</p>
                                <p class="text-xs text-gray-400 font-medium mt-0.5">{{ $order['user']['email'] ?? '' }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-semibold text-gray-800">
                                {{ $order['product']['nama_product'] ?? ($order['nama_custom'] ?? 'Pesanan Custom') }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-lg bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-700 ring-1 ring-inset ring-emerald-600/10">
                                Rp {{ number_format($order['estimasi_biaya'] ?? 0, 0, ',', '.') }}
                            </span>
                        </td>

                        <td class="px-6 py-4">
                            @php
                                $statusPesanan = strtolower($order['status_pesanan'] ?? '');
                                $currentTahap = strtolower($order['latest_status']['status'] ?? 'persiapan');
                            @endphp

                            @if($statusPesanan == 'menunggu_konfirmasi')
                                <span class="inline-flex items-center rounded-md bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600">
                                    ⏳ Belum Diproses
                                </span>
                            @elseif($statusPesanan == 'dibatalkan')
                                <span class="inline-flex items-center rounded-md bg-rose-50 px-2.5 py-1 text-xs font-semibold text-rose-700">
                                    ❌ Dibatalkan
                                </span>
                            @elseif($statusPesanan == 'selesai')
                                <span class="inline-flex items-center rounded-md bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                    ✅ Selesai
                                </span>
                            @elseif($statusPesanan == 'diproses')
                                @if($currentTahap == 'persiapan')
                                    <span class="inline-flex items-center rounded-md bg-gray-50 px-2.5 py-1 text-xs font-bold text-gray-700">
                                        📦 Persiapan
                                    </span>
                                @elseif($currentTahap == 'pengukiran')
                                    <span class="inline-flex items-center rounded-md bg-amber-50 px-2.5 py-1 text-xs font-bold text-amber-700">
                                        🔨 Pengukiran
                                    </span>
                                @elseif($currentTahap == 'finishing')
                                    <span class="inline-flex items-center rounded-md bg-purple-50 px-2.5 py-1 text-xs font-bold text-purple-700">
                                        ✨ Finishing
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-md bg-gray-50 px-2.5 py-1 text-xs font-semibold text-gray-600">
                                        📦 Persiapan
                                    </span>
                                @endif
                            @endif
                        </td>

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
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $badgeStyle }}">
                                {{ ucfirst(str_replace('_', ' ', $order['status_pesanan'] ?? 'menunggu')) }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center items-center gap-2">
                                <a href="{{ route('orders.show', $order['id']) }}"
                                class="inline-flex items-center justify-center px-3 py-1.5 bg-[#5d4037] hover:bg-[#3e2723] text-white text-xs font-semibold rounded-lg shadow-sm transition-colors"
                                title="Lihat Detail">
                                    Detail
                                </a>

                                <a href="{{ route('orders.edit', $order['id']) }}"
                                class="inline-flex items-center justify-center px-3 py-1.5 bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 text-xs font-semibold rounded-lg shadow-sm transition-colors"
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
        <div id="paginationContainer" class="flex flex-col sm:flex-row items-center justify-between p-4 border-t border-gray-100 bg-[#faf8f5] text-xs">
            <span id="paginationInfo" class="text-gray-500 mb-3 sm:mb-0 font-medium">Menampilkan 0 dari 0 data</span>
            <div id="paginationButtons" class="flex items-center gap-1.5">
                {{-- Tombol halaman akan di-generate otomatis via JS --}}
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

        // 1. Filter baris berdasarkan pencarian dan status
        const filteredRows = rows.filter(row => {
            const textContent = row.innerText.toLowerCase();
            const rowStatus = row.getAttribute('data-status') || '';

            const matchesSearch = textContent.includes(searchValue);
            const matchesFilter = statusValue === '' || rowStatus === statusValue;

            return matchesSearch && matchesFilter;
        });

        // 2. Hitung total halaman
        const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
        if (currentPage > totalPages && totalPages > 0) {
            currentPage = totalPages;
        } else if (currentPage < 1) {
            currentPage = 1;
        }

        // 3. Sembunyikan semua baris terlebih dahulu
        rows.forEach(row => row.style.display = 'none');

        // 4. Tentukan baris mana yang akan ditampilkan pada halaman aktif (10 data)
        const startIndex = (currentPage - 1) * rowsPerPage;
        const endIndex = startIndex + rowsPerPage;
        const visibleRows = filteredRows.slice(startIndex, endIndex);

        visibleRows.forEach(row => row.style.display = '');

        // 5. Atur tampilan baris kosong (empty state)
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

        // 6. Update informasi teks pagination
        if (filteredRows.length > 0) {
            paginationInfo.innerText = `Menampilkan ${startIndex + 1} - ${Math.min(endIndex, filteredRows.length)} dari ${filteredRows.length} data`;
        } else {
            paginationInfo.innerText = `Menampilkan 0 dari 0 data`;
        }

        // 7. Render Tombol Navigasi Pagination
        renderPaginationButtons(totalPages);
    }

    function renderPaginationButtons(totalPages) {
        paginationButtons.innerHTML = '';

        if (totalPages <= 1) return;

        // Tombol Sebelumnya (Prev)
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

        // Tombol Nomor Halaman
        for (let i = 1; i <= totalPages; i++) {
            // Batasi tampilan nomor halaman jika terlalu banyak (opsional, tampilkan semua jika di bawah 10 halaman)
            const pageButton = document.createElement('button');
            pageButton.innerText = i;
            pageButton.className = `px-3 py-1.5 rounded-lg border font-bold transition-colors ${currentPage === i ? 'bg-[#5d4037] text-white border-[#5d4037]' : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-100'}`;
            pageButton.addEventListener('click', () => {
                currentPage = i;
                updateTable();
            });
            paginationButtons.appendChild(pageButton);
        }

        // Tombol Selanjutnya (Next)
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

    // Event Listener untuk Search dan Filter
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            currentPage = 1; // Reset ke halaman 1 saat mengetik pencarian
            updateTable();
        });
    }

    if (filterStatus) {
        filterStatus.addEventListener('change', () => {
            currentPage = 1; // Reset ke halaman 1 saat mengubah filter status
            updateTable();
        });
    }

    // Jalankan pertama kali saat halaman dimuat
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
