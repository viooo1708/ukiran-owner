@extends('layouts.app')

@section('title', 'Kelola Profil Pelanggan')

@section('content')
<div class="space-y-8">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-[#5d4037]">
                Kelola Profil Pelanggan
            </h1>
            <p class="text-gray-500 mt-1">
                Owner dapat melihat dan mengelola seluruh data pelanggan.
            </p>
        </div>

        <form action="{{ route('profile.index') }}" method="GET" id="searchForm">
            <div class="relative">
                <input
                    type="text"
                    id="searchInput"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama, email, atau no hp..."
                    class="w-full sm:w-72 rounded-lg border border-gray-300 pl-4 pr-10 py-2 focus:ring-[#6d4c41] focus:border-[#6d4c41] text-sm"
                >
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>
        </form>
    </div>

    <!-- {{-- Flash Message --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg text-sm shadow-sm flex justify-between items-center">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-green-900 font-bold hover:opacity-70">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg text-sm shadow-sm flex justify-between items-center">
            <span>{{ session('error') }}</span>
            <button onclick="this.parentElement.remove()" class="text-red-900 font-bold hover:opacity-70">&times;</button>
        </div>
    @endif -->

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="px-6 py-4 border-b flex justify-between items-center bg-gray-50">
            <h2 class="text-lg font-semibold text-[#5d4037]">
                Daftar Pelanggan
            </h2>
            <span id="userCount" class="text-xs bg-[#efebe9] text-[#5d4037] px-2.5 py-1 rounded-full font-medium">
                Total: {{ count($users) }} Orang
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-[#efebe9]">
                    <tr class="text-left text-[#5d4037]">
                        <th class="px-6 py-4 w-16">No</th>
                        <th class="px-6 py-4 w-20">Foto</th>
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">No HP</th>
                        <th class="px-6 py-4">Alamat</th>
                        <th class="px-6 py-4">Role</th>
                        <th class="px-6 py-4 text-center w-40">Aksi</th>
                    </tr>
                </thead>
                <tbody id="userTableBody">
                @forelse($users as $user)
                    <tr class="border-b hover:bg-gray-50 transition-colors user-row">
                        <td class="px-6 py-4 font-medium text-gray-600 row-number">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-6 py-4">
                            @if(!empty($user['foto']))
                                <img src="{{ $user['foto'] }}" class="w-10 h-10 rounded-full object-cover shadow-sm">
                            @else
                                <div class="w-10 h-10 rounded-full bg-[#d7ccc8] flex items-center justify-center text-[#5d4037] font-bold shadow-sm">
                                    {{ strtoupper(substr($user['nama'], 0, 1)) }}
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-800 search-name">
                            {{ $user['nama'] }}
                        </td>
                        <td class="px-6 py-4 text-gray-600 search-email">
                            {{ $user['email'] }}
                        </td>
                        <td class="px-6 py-4 text-gray-600 search-phone">
                            {{ $user['no_hp'] ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-gray-500 max-w-xs truncate">
                            {{ $user['alamat'] ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            @if($user['role'] == 'owner')
                                <span class="bg-blue-100 text-blue-700 text-xs px-2.5 py-1 rounded-full font-medium">
                                    Owner
                                </span>
                            @else
                                <span class="bg-green-100 text-green-700 text-xs px-2.5 py-1 rounded-full font-medium">
                                    Pelanggan
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                {{-- KOREKSI: Menggunakan 'users.edit' sesuai dengan web.php --}}
                                <a href="{{ route('users.edit', $user['id']) }}" class="text-sm font-medium text-amber-600 hover:text-amber-800 transition-colors px-2 py-1 rounded hover:bg-amber-50">
                                    Edit
                                </a>
                                <span class="text-gray-300">|</span>

                                {{-- KOREKSI: Menggunakan 'users.destroy' sesuai dengan web.php --}}
                                <form action="{{ route('users.destroy', $user['id']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini? Tindakan ini tidak bisa dibatalkan.')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800 transition-colors px-2 py-1 rounded hover:bg-red-50">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr id="emptyRow">
                        <td colspan="8" class="text-center py-12 text-gray-500 bg-gray-50">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            Data pelanggan belum tersedia.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Skrip Live Search Tanpa Reload --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const rows = document.querySelectorAll('.user-row');
        const userCount = document.getElementById('userCount');
        const tableBody = document.getElementById('userTableBody');

        // Membuat baris "Tidak Ditemukan" secara dinamis jika hasil filter kosong
        const noResultRow = document.createElement('tr');
        noResultRow.id = 'dynamicEmptyRow';
        noResultRow.className = 'hidden';
        noResultRow.innerHTML = `<td colspan="8" class="text-center py-12 text-gray-500 bg-gray-50">Data pencarian tidak ditemukan.</td>`;
        tableBody.appendChild(noResultRow);

        searchInput.addEventListener('input', function (e) {
            const keyword = e.target.value.toLowerCase().trim();
            let visibleCount = 0;

            rows.forEach(row => {
                const name = row.querySelector('.search-name').textContent.toLowerCase();
                const email = row.querySelector('.search-email').textContent.toLowerCase();
                const phone = row.querySelector('.search-phone').textContent.toLowerCase();

                if (name.includes(keyword) || email.includes(keyword) || phone.includes(keyword)) {
                    row.classList.remove('hidden');
                    visibleCount++;
                    // Perbarui nomor urut real-time sesuai urutan visual baru
                    row.querySelector('.row-number').textContent = visibleCount;
                } else {
                    row.classList.add('hidden');
                }
            });

            // Update badge total data terfilter
            userCount.textContent = `Ditemukan: ${visibleCount} Orang`;

            // Tampilkan pesan kosong jika semua data tersembunyi
            if (visibleCount === 0 && rows.length > 0) {
                noResultRow.classList.remove('hidden');
            } else {
                noResultRow.classList.add('hidden');
            }
        });
    });
</script>
@endsection
