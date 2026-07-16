@extends('layouts.app')

@section('title', 'Edit Data Pelanggan')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    {{-- Navigasi Kembali --}}
    <div>
        <a href="{{ route('profile.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-[#5d4037] transition-colors">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar Pelanggan
        </a>
    </div>

    {{-- Judul Halaman --}}
    <div>
        <h1 class="text-3xl font-bold text-[#5d4037]">Edit Profil Pelanggan</h1>
        <p class="text-gray-500 mt-1">Perbarui informasi profil atau ubah hak akses peran (role) pengguna ini.</p>
    </div>

    {{-- Form Edit --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <form action="{{ route('users.update', $user['id']) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            {{-- Preview Foto Saat Ini --}}
            <div class="flex items-center space-y-0 gap-4">
                <div>
                    @if(!empty($user['foto']))
                        <img src="{{ $user['foto'] }}" class="w-16 h-16 rounded-full object-cover shadow-sm border border-gray-200">
                    @else
                        <div class="w-16 h-16 rounded-full bg-[#d7ccc8] flex items-center justify-center text-[#5d4037] text-xl font-bold shadow-sm">
                            {{ strtoupper(substr($user['nama'], 0, 1)) }}
                        </div>
                    @endif
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-700">Foto Profil</h3>
                    <p class="text-xs text-gray-400">Diatur langsung oleh pelanggan via aplikasi / API.</p>
                </div>
            </div>

            <hr class="border-gray-100">

            {{-- Input Nama --}}
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <input
                    type="text"
                    id="nama"
                    name="nama"
                    value="{{ old('nama', $user['nama']) }}"
                    required
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:ring-[#6d4c41] focus:border-[#6d4c41] @error('nama') border-red-500 @enderror"
                >
                @error('nama')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                {{-- Input Email (Readonly jika kebijakan API tidak memperbolehkan ganti email) --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                    <input
                        type="email"
                        id="email"
                        value="{{ $user['email'] }}"
                        disabled
                        class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2 text-sm text-gray-400 cursor-not-allowed"
                    >
                    <p class="text-xs text-gray-400 mt-1">Email tidak dapat diubah demi keamanan akun.</p>
                </div>

                {{-- Input No HP --}}
                <div>
                    <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-1">Nomor HP</label>
                    <input
                        type="text"
                        id="no_hp"
                        name="no_hp"
                        value="{{ old('no_hp', $user['no_hp'] ?? '') }}"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:ring-[#6d4c41] focus:border-[#6d4c41] @error('no_hp') border-red-500 @enderror"
                        placeholder="Contoh: 08123456789"
                    >
                    @error('no_hp')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Pilihan Peran (Role) --}}
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Hak Akses / Peran <span class="text-red-500">*</span></label>
                <select
                    id="role"
                    name="role"
                    required
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:ring-[#6d4c41] focus:border-[#6d4c41]"
                >
                    <option value="pelanggan" {{ old('role', $user['role']) == 'pelanggan' ? 'selected' : '' }}>Pelanggan (Customer)</option>
                    <option value="owner" {{ old('role', $user['role']) == 'owner' ? 'selected' : '' }}>Owner (Administrator)</option>
                </select>
                <p class="text-xs text-gray-400 mt-1">Hati-hati: Memberikan role 'Owner' akan memberikan akses penuh ke dashboard ini kepada pengguna terkait.</p>
            </div>

            {{-- Input Alamat --}}
            <div>
                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat Domisili</label>
                <textarea
                    id="alamat"
                    name="alamat"
                    rows="3"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:ring-[#6d4c41] focus:border-[#6d4c41] @error('alamat') border-red-500 @enderror"
                    placeholder="Tuliskan alamat lengkap..."
                >{{ old('alamat', $user['alamat'] ?? '') }}</textarea>
                @error('alamat')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <button type="submit" class="rounded-lg bg-[#5d4037] px-4 py-2 text-sm font-medium text-white hover:bg-[#4e342e] transition-colors shadow-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
