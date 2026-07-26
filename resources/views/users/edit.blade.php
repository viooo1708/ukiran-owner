@extends('layouts.app')

@section('title', 'Edit Data Pelanggan')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 animate-fade-in pb-12 text-gray-800">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pb-6 border-b border-[#e5ddd8]">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#3e2723] tracking-tight">
                Edit Profil Pelanggan
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Perbarui informasi profil atau ubah hak akses peran (role) pengguna ini.
            </p>
        </div>

        <a href="{{ route('profile.index') }}" class="inline-flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 px-4 py-2 rounded-xl text-sm font-medium transition-colors shadow-sm">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            Kembali ke Daftar Pelanggan
        </a>
    </div>

    {{-- Form Container Card --}}
    <div class="bg-white rounded-2xl border border-[#eadfd8] shadow-sm overflow-hidden max-w-4xl mx-auto">
        <form action="{{ route('users.update', $user['id']) }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8 space-y-6">
            @csrf
            @method('PUT')

            {{-- Preview Foto Saat Ini --}}
            <div class="flex items-center gap-4 bg-[#faf8f5] p-4 rounded-xl border border-[#eadfd8]">
                <div>
                    @if(!empty($user['foto']))
                        <img src="{{ $user['foto'] }}" class="w-14 h-14 rounded-xl object-cover shadow-sm border border-gray-200">
                    @else
                        <div class="w-14 h-14 rounded-xl bg-[#efebe9] flex items-center justify-center text-[#5d4037] text-lg font-bold shadow-sm">
                            {{ strtoupper(substr($user['nama'], 0, 1)) }}
                        </div>
                    @endif
                </div>
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-600">Foto Profil Pengguna</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Diatur langsung oleh pengguna via aplikasi atau sistem utama.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Input Nama --}}
                <div>
                    <label for="nama" class="block mb-2 text-xs font-bold uppercase tracking-wider text-gray-600">
                        Nama Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="nama"
                        name="nama"
                        value="{{ old('nama', $user['nama']) }}"
                        required
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#5d4037]/10 focus:border-[#5d4037] transition-all font-semibold text-gray-800 @error('nama') border-rose-500 @enderror"
                    >
                    @error('nama')
                        <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Input Email --}}
                <div>
                    <label for="email" class="block mb-2 text-xs font-bold uppercase tracking-wider text-gray-600">
                        Alamat Email
                    </label>
                    <input
                        type="email"
                        id="email"
                        value="{{ $user['email'] }}"
                        disabled
                        class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-400 cursor-not-allowed font-medium"
                    >
                    <p class="text-[11px] text-gray-400 mt-1">Email tidak dapat diubah demi keamanan kredensial.</p>
                </div>

                {{-- Input No HP --}}
                <div>
                    <label for="no_hp" class="block mb-2 text-xs font-bold uppercase tracking-wider text-gray-600">
                        Nomor HP / WhatsApp
                    </label>
                    <input
                        type="text"
                        id="no_hp"
                        name="no_hp"
                        value="{{ old('no_hp', $user['no_hp'] ?? '') }}"
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#5d4037]/10 focus:border-[#5d4037] transition-all font-medium text-gray-800 @error('no_hp') border-rose-500 @enderror"
                        placeholder="Contoh: 08123456789"
                    >
                    @error('no_hp')
                        <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Pilihan Peran (Role) --}}
                <div>
                    <label for="role" class="block mb-2 text-xs font-bold uppercase tracking-wider text-gray-600">
                        Hak Akses / Peran <span class="text-rose-500">*</span>
                    </label>
                    <select
                        id="role"
                        name="role"
                        required
                        class="w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#5d4037]/10 focus:border-[#5d4037] transition-all font-medium text-gray-800"
                    >
                        <option value="pelanggan" {{ old('role', $user['role']) == 'pelanggan' ? 'selected' : '' }}>Pelanggan (Customer)</option>
                        <option value="owner" {{ old('role', $user['role']) == 'owner' ? 'selected' : '' }}>Owner (Administrator)</option>
                    </select>
                    <p class="text-[11px] text-gray-400 mt-1">Perhatian: Hak akses Owner memberikan kontrol kendali penuh sistem.</p>
                </div>
            </div>

            {{-- Input Alamat --}}
            <div>
                <label for="alamat" class="block mb-2 text-xs font-bold uppercase tracking-wider text-gray-600">
                    Alamat Domisili
                </label>
                <textarea
                    id="alamat"
                    name="alamat"
                    rows="3"
                    class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#5d4037]/10 focus:border-[#5d4037] transition-all leading-relaxed text-gray-800 placeholder:text-gray-400 @error('alamat') border-rose-500 @enderror"
                    placeholder="Tuliskan alamat lengkap domisili pelanggan..."
                >{{ old('alamat', $user['alamat'] ?? '') }}</textarea>
                @error('alamat')
                    <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Aksi Footer --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('profile.index') }}"
                    class="px-5 py-2.5 rounded-xl border border-gray-300 bg-white text-xs font-bold text-gray-600 hover:bg-gray-50 transition-colors">
                    Batal
                </a>

                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-[#5d4037] hover:bg-[#3e2723] text-white text-xs font-bold shadow-sm transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
