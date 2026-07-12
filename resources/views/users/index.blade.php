@extends('layouts.app')

@section('title', 'Kelola Profil Pelanggan')

@section('content')
<div class="space-y-8">

    {{-- Header --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-[#5d4037]">
                Kelola Profil Pelanggan
            </h1>

            <p class="text-gray-500 mt-1">
                Owner dapat melihat dan mengelola seluruh data pelanggan.
            </p>
        </div>

        <form action="{{ route('profile.index') }}" method="GET">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari pelanggan..."
                class="w-72 rounded-lg border border-gray-300 px-4 py-2 focus:ring-[#6d4c41] focus:border-[#6d4c41]"
            >
        </form>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <div class="px-6 py-4 border-b">
            <h2 class="text-lg font-semibold text-[#5d4037]">
                Daftar Pelanggan
            </h2>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-[#efebe9]">

                <tr class="text-left text-[#5d4037]">

                    <th class="px-6 py-4">No</th>
                    <th class="px-6 py-4">Foto</th>
                    <th class="px-6 py-4">Nama</th>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4">No HP</th>
                    <th class="px-6 py-4">Alamat</th>
                    <th class="px-6 py-4">Role</th>
                    <th class="px-6 py-4 text-center">Aksi</th>

                </tr>

                </thead>

                <tbody>

                @forelse($users as $user)

                    <tr class="border-b hover:bg-gray-50">

                        <td class="px-6 py-4">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-6 py-4">

                            @if(!empty($user['foto']))

                                <img
                                    src="{{ $user['foto'] }}"
                                    class="w-12 h-12 rounded-full object-cover">

                            @else

                                <div class="w-12 h-12 rounded-full bg-[#d7ccc8] flex items-center justify-center text-[#5d4037] font-bold">
                                    {{ strtoupper(substr($user['nama'],0,1)) }}
                                </div>

                            @endif

                        </td>

                        <td class="px-6 py-4 font-medium">
                            {{ $user['nama'] }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $user['email'] }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $user['no_hp'] ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $user['alamat'] ?? '-' }}
                        </td>

                        <td class="px-6 py-4">

                            @if($user['role'] == 'owner')

                                <span class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full">
                                    Owner
                                </span>

                            @else

                                <span class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full">
                                    Pelanggan
                                </span>

                            @endif

                        </td>

                        <td class="px-6 py-4 text-center">
    <span class="text-gray-500 text-sm">
        Belum tersedia
    </span>
</td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="8" class="text-center py-10 text-gray-500">

                            Data pelanggan belum tersedia.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>
@endsection
