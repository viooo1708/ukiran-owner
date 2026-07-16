@extends('layouts.app')

@section('title', 'Pusat Kendali Owner - Kriya Ukir')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- Header Utama --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-gray-100 pb-5">
        <div>
            <h1 class="text-3xl font-bold text-[#5d4037] tracking-tight">Pusat Kendali Owner</h1>
            <p class="text-sm text-gray-500 mt-1">Pantau performa ringkas toko dan amankan kredensial akun Kriya Ukir Anda.</p>
        </div>
        <div class="inline-flex items-center gap-2 bg-[#efebe9] text-[#5d4037] font-semibold px-4 py-2 rounded-xl border border-[#d7ccc8] text-xs self-start md:self-center shadow-sm">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            Hak Akses: Super Administrator
        </div>
    </div>

    {{-- Komponen Profile Banner --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group">
        {{-- Banner Atas dengan Efek Gradasi & Pola Grid Halus --}}
        <div class="h-40 bg-gradient-to-r from-[#4e342e] via-[#5d4037] to-[#8d6e63] relative overflow-hidden">
            <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/5 rounded-full blur-2xl"></div>
            <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-black/10 rounded-full blur-xl"></div>
        </div>

        {{-- Blok Info Utama (Foto Profil & Nama) --}}
        <div class="px-8 pb-6 flex flex-col sm:flex-row items-center sm:items-end gap-6 -mt-16 relative z-10 border-b border-gray-50">
            {{-- Bingkai Foto Profil --}}
            <div class="relative group/avatar">
                @if(session('user.foto'))
                    <img id="avatar-master" src="{{ session('user.foto') }}"
                        class="w-32 h-32 rounded-2xl object-cover border-4 border-white shadow-lg bg-gray-50 transition-transform duration-300 group-hover/avatar:scale-[1.02]">
                @else
                    <div class="w-32 h-32 rounded-2xl bg-gradient-to-br from-[#8d6e63] to-[#5d4037] text-white flex items-center justify-center text-4xl font-bold border-4 border-white shadow-lg transition-transform duration-300 group-hover/avatar:scale-[1.02]">
                        {{ strtoupper(substr(session('user.nama', 'O'), 0, 1)) }}
                    </div>
                @endif
                {{-- Badge Indikator Online/Aktif Ringkas --}}
                <span class="absolute bottom-2 right-2 w-4 h-4 bg-emerald-500 border-2 border-white rounded-full shadow-sm animate-pulse"></span>
            </div>

            {{-- Detail Informasi Teks --}}
            <div class="pt-2 sm:pt-0 pb-1 text-center sm:text-left flex-1 space-y-1">
                <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                    <h2 class="text-2xl font-extrabold text-gray-800 tracking-tight">{{ session('user.nama') }}</h2>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-[#efebe9] text-[#5d4037] border border-[#d7ccc8] mx-auto sm:mx-0 w-fit">
                        Owner
                    </span>
                </div>
                <p class="text-sm text-gray-500 flex items-center justify-center sm:justify-start gap-2">
                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span class="hover:text-[#5d4037] transition-colors duration-150 cursor-pointer">{{ session('user.email') }}</span>
                </p>
            </div>
        </div>

        {{-- Navigasi Tab Menu --}}
        <div class="bg-gray-50/70 px-6 flex gap-2 overflow-x-auto scrollbar-none">
            <button onclick="switchTab('tab-overview')" id="btn-tab-overview" class="tab-btn px-4 py-3.5 text-sm font-semibold border-b-2 border-[#5d4037] text-[#5d4037] transition-all flex items-center gap-2 whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Ringkasan Informasi
            </button>
            <button onclick="switchTab('tab-edit')" id="btn-tab-edit" class="tab-btn px-4 py-3.5 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-[#5d4037] transition-all flex items-center gap-2 whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11 20H8v-3L19.586 9.414z"/></svg>
                Ubah Profil
            </button>
            <button onclick="switchTab('tab-security')" id="btn-tab-security" class="tab-btn px-4 py-3.5 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-[#5d4037] transition-all flex items-center gap-2 whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                Keamanan Akun
            </button>
        </div>
    </div>

    {{-- KONTEN TAB 1: OVERVIEW (RINGKASAN INFORMASI) --}}
    <div id="tab-overview" class="tab-content space-y-6">
        {{-- Detail Informasi Statis --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
            <h3 class="text-base font-bold text-gray-800 mb-5 flex items-center gap-2">
                <span class="w-1.5 h-4 bg-[#5d4037] inline-block rounded-full"></span>
                Biodata Terdaftar
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-12 text-sm">
                <div class="flex justify-between items-center border-b border-gray-100 pb-3">
                    <span class="text-gray-400 font-medium">Nama Pemilik</span>
                    <span class="font-semibold text-gray-800">{{ session('user.nama', '-') }}</span>
                </div>
                <div class="flex justify-between items-center border-b border-gray-100 pb-3">
                    <span class="text-gray-400 font-medium">Kontak Telepon</span>
                    <span class="font-semibold text-gray-800">{{ session('user.no_hp', '-') }}</span>
                </div>
                <div class="flex justify-between items-center border-b border-gray-100 pb-3">
                    <span class="text-gray-400 font-medium">Level Otentikasi</span>
                    <span class="font-bold text-[#5d4037] bg-[#efebe9] px-2.5 py-0.5 rounded-lg border border-[#d7ccc8] text-xs">Owner (Sistem Utama)</span>
                </div>
                <div class="flex justify-between items-center border-b border-gray-100 pb-3">
                    <span class="text-gray-400 font-medium">Status Operasional</span>
                    <span class="text-emerald-600 font-semibold flex items-center gap-1.5 text-xs bg-emerald-50 px-2.5 py-0.5 rounded-lg border border-emerald-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block animate-pulse"></span>
                        Aktif Melayani
                    </span>
                </div>
                <div class="md:col-span-2 flex flex-col gap-2 pt-2">
                    <span class="text-gray-400 font-medium">Alamat Workshop / Domisili</span>
                    <p class="text-gray-700 bg-gray-50/80 p-4 rounded-xl border border-gray-100 leading-relaxed text-sm shadow-inner">{{ session('user.alamat', 'Alamat belum diatur.') }}</p>
                </div>
            </div>
        </div>

        {{-- Log Keamanan Sederhana --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold text-gray-800 flex items-center gap-2">
                    <span class="w-1.5 h-4 bg-[#5d4037] inline-block rounded-full"></span>
                    Riwayat Sesi Keamanan Akun
                </h3>
                <span class="text-xs font-semibold text-gray-400 bg-gray-100 px-2 py-1 rounded-md">Diperbarui real-time</span>
            </div>
            <div class="text-xs text-[#7f5f15] bg-amber-50/60 border border-amber-200/70 p-4 rounded-xl flex items-start gap-3 leading-relaxed">
                <svg class="w-5 h-5 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <div>
                    <span class="font-bold block mb-0.5 text-amber-800">Tips Keamanan Penting:</span>
                    Gunakan kombinasi kata sandi yang kuat dan perbarui secara berkala untuk melindungi seluruh data finansial serta transaksi pengrajin kayu Kriya Ukir Anda dari akses yang tidak sah.
                </div>
            </div>
        </div>
    </div>

    {{-- SATUKAN FORM DI SINI UNTUK TAB EDIT & SECURITY --}}
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="main-profile-form">
        @csrf
        @method('PUT')

        {{-- KONTEN TAB 2: UBAH PROFIL --}}
        <div id="tab-edit" class="tab-content hidden animate-fade-in space-y-6">
            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Nama Lengkap Owner</label>
                        <input type="text" name="nama" value="{{ old('nama', session('user.nama')) }}" required class="w-full text-sm rounded-xl border-gray-300 shadow-sm focus:ring-[#6d4c41] focus:border-[#6d4c41]">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 uppercase mb-2">Alamat Email</label>
                        <input type="email" value="{{ session('user.email') }}" readonly class="w-full text-sm rounded-xl border-gray-200 bg-gray-50 text-gray-400 cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Nomor Handphone/WhatsApp</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp', session('user.no_hp')) }}" class="w-full text-sm rounded-xl border-gray-300 shadow-sm focus:ring-[#6d4c41] focus:border-[#6d4c41]">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 uppercase mb-2">Peran Otoritas</label>
                        <input type="text" value="Owner / Pemilik Usaha" readonly class="w-full text-sm rounded-xl border-gray-200 bg-gray-50 text-gray-400 cursor-not-allowed">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Foto Profil Baru</label>
                        <input type="file" name="foto" accept="image/*" onchange="previewAvatar(event)" class="block w-full text-xs text-gray-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Alamat Lengkap Workshop</label>
                        <textarea name="alamat" rows="3" class="w-full text-sm rounded-xl border-gray-300 shadow-sm focus:ring-[#6d4c41] focus:border-[#6d4c41]">{{ old('alamat', session('user.alamat')) }}</textarea>
                    </div>
                </div>
                <div class="flex justify-end pt-5 border-t border-gray-100 mt-6">
                    <button type="submit" onclick="this.disabled=true; this.innerText='Menyimpan...'; this.form.submit();" class="px-6 py-2.5 rounded-xl text-sm font-semibold text-white bg-[#5d4037] hover:bg-[#4e342e] shadow-sm">
                        Simpan Pembaruan Profil
                    </button>
                </div>
            </div>
        </div>

        {{-- KONTEN TAB 3: KEAMANAN (PASSWORD) --}}
        <div id="tab-security" class="tab-content hidden animate-fade-in space-y-6">
            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                <div class="max-w-xl space-y-5">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Kata Sandi Baru</label>
                        <input type="password" name="password" placeholder="Minimal 8 karakter unik..." class="w-full text-sm rounded-xl border-gray-300 focus:ring-[#6d4c41] focus:border-[#6d4c41]">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Ulangi Kata Sandi Baru</label>
                        <input type="password" name="password_confirmation" placeholder="Konfirmasi ulang sandi..." class="w-full text-sm rounded-xl border-gray-300 focus:ring-[#6d4c41] focus:border-[#6d4c41]">
                    </div>
                </div>
                <div class="flex justify-end pt-5 border-t border-gray-100 mt-6">
                    <button type="submit" onclick="this.disabled=true; this.innerText='Mengamankan...'; this.form.submit();" class="px-6 py-2.5 rounded-xl text-sm font-semibold text-white bg-[#5d4037] hover:bg-[#4e342e] shadow-sm">
                        Perbarui Kata Sandi
                    </button>
                </div>
            </div>
        </div>
    </form>
    </div>

</div>

{{-- Script Pengendali Tab Switcher & Preview --}}
<script>
    function switchTab(tabId) {
        // 1. Sembunyikan semua konten tab
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });

        // 2. Tampilkan tab yang dipilih
        document.getElementById(tabId).classList.remove('hidden');

        // 3. Reset style tombol navigasi tab
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('border-[#5d4037]', 'text-[#5d4037]', 'font-semibold');
            btn.classList.add('border-transparent', 'text-gray-500', 'font-medium');
        });

        // 4. Aktifkan style tombol yang diklik
        const activeBtn = document.getElementById('btn-' + tabId);
        activeBtn.classList.add('border-[#5d4037]', 'text-[#5d4037]', 'font-semibold');
        activeBtn.classList.remove('border-transparent', 'text-gray-500', 'font-medium');
    }

    function previewAvatar(event) {
        const input = event.target;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const masterImg = document.getElementById('avatar-master');
                if(masterImg) masterImg.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
