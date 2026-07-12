@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')

<div class="max-w-5xl mx-auto">

    {{-- Header --}}
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-[#5d4037]">
            Profil Saya
        </h2>

        <p class="text-gray-500 mt-1">
            Kelola informasi akun owner Kriya Ukir
        </p>
    </div>


    {{-- Profile Card --}}
    <div class="bg-white rounded-2xl shadow border border-gray-200 overflow-hidden">

        {{-- Cover --}}
        <div class="h-32 bg-[#5d4037]"></div>


        <div class="px-8 pb-8">

            {{-- Foto Profil --}}
            <div class="-mt-16 mb-6">

                @if(session('user.foto'))

                    <img
                        src="{{ session('user.foto') }}"
                        class="w-32 h-32 rounded-full object-cover border-4 border-white shadow">

                @else

                    <div
                        class="w-32 h-32 rounded-full bg-[#8d6e63] text-white flex items-center justify-center text-4xl font-bold border-4 border-white shadow">

                        {{ strtoupper(substr(session('user.nama'),0,1)) }}

                    </div>

                @endif

            </div>



            {{-- Form --}}
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')


                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                    {{-- Nama --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Lengkap
                        </label>

                        <input
                            type="text"
                            name="nama"
                            value="{{ session('user.nama') }}"
                            class="w-full rounded-xl border-gray-300 focus:ring-[#6d4c41] focus:border-[#6d4c41]">

                    </div>



                    {{-- Email --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Email
                        </label>

                        <input
                            type="email"
                            value="{{ session('user.email') }}"
                            readonly
                            class="w-full rounded-xl border-gray-200 bg-gray-100">

                    </div>



                    {{-- No HP --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nomor HP
                        </label>

                        <input
                            type="text"
                            name="no_hp"
                            value="{{ session('user.no_hp') }}"
                            class="w-full rounded-xl border-gray-300 focus:ring-[#6d4c41] focus:border-[#6d4c41]">

                    </div>



                    {{-- Role --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Role
                        </label>

                        <input
                            type="text"
                            value="Owner"
                            readonly
                            class="w-full rounded-xl border-gray-200 bg-gray-100">

                    </div>



                    {{-- Alamat --}}
                    <div class="md:col-span-2">

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Alamat
                        </label>

                        <textarea
                            name="alamat"
                            rows="3"
                            class="w-full rounded-xl border-gray-300 focus:ring-[#6d4c41] focus:border-[#6d4c41]">{{ session('user.alamat') }}</textarea>

                    </div>



                    {{-- Foto --}}
                    <div class="md:col-span-2">

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Foto Profil
                        </label>

                        <input
                            type="file"
                            name="foto"
                            accept="image/*"
                            class="w-full rounded-xl border-gray-300">

                        <p class="text-xs text-gray-500 mt-2">
                            Format JPG, PNG maksimal 2MB
                        </p>

                    </div>


                </div>



                {{-- Password --}}
                <div class="mt-8 border-t pt-6">

                    <h3 class="text-lg font-bold text-[#5d4037] mb-4">
                        Ubah Password
                    </h3>


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                        <div>

                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Password Baru
                            </label>

                            <input
                                type="password"
                                name="password"
                                class="w-full rounded-xl border-gray-300 focus:ring-[#6d4c41] focus:border-[#6d4c41]">

                        </div>



                        <div>

                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Konfirmasi Password
                            </label>

                            <input
                                type="password"
                                name="password_confirmation"
                                class="w-full rounded-xl border-gray-300 focus:ring-[#6d4c41] focus:border-[#6d4c41]">

                        </div>


                    </div>

                </div>



                {{-- Button --}}
                <div class="mt-8 flex justify-end">

                    <button
                        type="submit"
                        class="px-6 py-3 bg-[#5d4037] text-white rounded-xl hover:bg-[#4e342e] transition">

                        Simpan Perubahan

                    </button>

                </div>


            </form>


        </div>

    </div>


</div>


@endsection
