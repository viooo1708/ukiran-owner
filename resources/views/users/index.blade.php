@extends('layouts.app')

@section('title', 'Kelola Profil Pelanggan')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 animate-fade-in pb-12 text-gray-800">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pb-6 border-b border-[#e5ddd8]">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#3e2723] tracking-tight">
                Kelola Profil Pelanggan
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Owner dapat melihat dan mengelola seluruh data pelanggan yang terdaftar pada sistem.
            </p>
        </div>

        <form action="{{ route('profile.index') }}" method="GET" id="searchForm" class="w-full sm:w-80">
            <div class="relative">
                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 flex items-center pointer-events-none">
                    <span class="material-symbols-outlined text-lg">search</span>
                </span>
                <input
                    type="text"
                    id="searchInput"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama, email, atau no hp..."
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 bg-white text-xs font-medium text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#5d4037]/10 focus:border-[#5d4037] shadow-sm transition-all placeholder:text-gray-400"
                >
            </div>
        </form>
    </div>

    {{-- Main Container Card --}}
    <div class="bg-white rounded-2xl border border-[#eadfd8] shadow-sm overflow-hidden">

        {{-- Card Header Toolbar --}}
        <div class="p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-[#faf8f5] border-b border-[#e5ddd8]">
            <div>
                <h2 class="text-base font-bold text-[#3e2723]">
                    Daftar Pelanggan
                </h2>
                <p class="text-xs text-gray-500 mt-0.5 font-semibold">
                    Total Akun: <span class="text-[#5d4037] font-bold bg-[#efebe9] px-2 py-0.5 rounded border border-[#d7ccc8]" id="userCount">{{ count($users) }}</span> Orang Terdaftar
                </p>
            </div>
        </div>

        {{-- Table Area --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm" id="userTable">
                <thead>
                    <tr class="bg-[#faf7f4] text-gray-500 text-xs font-semibold uppercase tracking-wider border-b border-gray-100">
                        <th class="py-4 px-6 w-16 text-center">No</th>
                        <th class="py-4 px-6 w-20 text-center">Visual</th>
                        <th class="py-4 px-6">Identitas Pengguna</th>
                        <th class="py-4 px-6">Email Akses</th>
                        <th class="py-4 px-6 w-36">Kontak (No HP)</th>
                        <th class="py-4 px-6">Alamat Domisili</th>
                        <th class="py-4 px-6 w-28 text-center">Peran</th>
                        <th class="py-4 px-6 text-center w-36">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100" id="userTableBody">
                @forelse($users as $user)
                    <tr class="user-row hover:bg-[#faf7f4]/60 transition-colors duration-150 group">
                        <td class="py-4 px-6 font-semibold text-gray-500 text-xs text-center row-number">
                            {{ $loop->iteration }}
                        </td>
                        <td class="py-4 px-6">
                            <div class="w-12 h-12 mx-auto rounded-xl overflow-hidden shadow-sm border border-gray-200 bg-gray-50 flex items-center justify-center relative">
                                @if(!empty($user['foto']))
                                    <img src="{{ $user['foto'] }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                @else
                                    <div class="w-full h-full bg-[#efebe9] flex items-center justify-center text-[#5d4037] font-bold text-sm">
                                        {{ strtoupper(substr($user['nama'], 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="py-4 px-6 search-name">
                            <h3 class="font-bold text-[#3e2723] text-sm group-hover:text-[#5d4037] transition-colors line-clamp-1">
                                {{ $user['nama'] }}
                            </h3>
                        </td>
                        <td class="py-4 px-6 text-gray-600 text-xs font-medium search-email">
                            {{ $user['email'] }}
                        </td>
                        <td class="py-4 px-6 text-gray-600 text-xs font-medium search-phone">
                            {{ $user['no_hp'] ?? '-' }}
                        </td>
                        <td class="py-4 px-6 text-gray-500 text-xs max-w-xs truncate leading-relaxed">
                            {{ $user['alamat'] ?? '-' }}
                        </td>
                        <td class="py-4 px-6 text-center">
                            @if($user['role'] == 'owner')
                                <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold bg-blue-50 text-blue-800 border border-blue-200/40">
                                    Owner
                                </span>
                            @else
                                <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200/40">
                                    Pelanggan
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-center">
                            <div class="flex justify-center gap-2">
                                {{-- Edit --}}
                                <a href="{{ route('users.edit', $user['id']) }}"
                                   class="inline-flex items-center justify-center px-3 py-1.5 bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 text-xs font-semibold rounded-lg shadow-sm transition-colors"
                                   title="Ubah Data">
                                    Edit
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('users.destroy', $user['id']) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini permanen?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center justify-center px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 text-xs font-semibold rounded-lg shadow-sm transition-colors"
                                            title="Hapus Akun">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr id="emptyRow">
                        <td colspan="8" class="text-center py-20 text-gray-400">
                            <span class="material-symbols-outlined text-4xl block mb-2 text-gray-300">group_off</span>
                            <p class="font-bold text-gray-700 text-sm">Belum ada data pelanggan yang terdaftar</p>
                            <p class="text-xs text-gray-400 mt-1">Data pelanggan akan muncul secara otomatis di sini saat mereka mendaftar.</p>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            {{-- Empty State Pencarian Kosong --}}
            <div id="dynamicEmptyRow" class="hidden text-center py-20 text-gray-400">
                <span class="material-symbols-outlined text-4xl block mb-2 text-gray-300">search_off</span>
                <p class="font-bold text-gray-700 text-sm">Tidak ada pelanggan yang cocok</p>
                <p class="text-xs text-gray-400 mt-1">Coba sesuaikan kembali kata kunci pencarian nama, email, atau nomor handphone Anda.</p>
            </div>
        </div>
    </div>
</div>

{{-- Skrip Live Search Tanpa Reload --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const rows = document.querySelectorAll('.user-row');
        const userCount = document.getElementById('userCount');
        const dynamicEmptyRow = document.getElementById('dynamicEmptyRow');

        searchInput.addEventListener('input', function (e) {
            const keyword = e.target.value.toLowerCase().trim();
            let visibleCount = 0;

            rows.forEach(row => {
                const name = row.querySelector('.search-name').textContent.toLowerCase();
                const email = row.querySelector('.search-email').textContent.toLowerCase();
                const phone = row.querySelector('.search-phone').textContent.toLowerCase();

                if (name.includes(keyword) || email.includes(keyword) || phone.includes(keyword)) {
                    row.style.display = '';
                    visibleCount++;
                    row.querySelector('.row-number').textContent = visibleCount;
                } else {
                    row.style.display = 'none';
                }
            });

            // Update badge total data terfilter
            userCount.textContent = visibleCount;

            // Tampilkan pesan kosong jika hasil filter nol
            if (visibleCount === 0 && rows.length > 0) {
                dynamicEmptyRow.classList.remove('hidden');
            } else {
                dynamicEmptyRow.classList.add('hidden');
            }
        });
    });
</script>
@endsection
