@extends('layouts.app')
@section('title', 'Produk')
@section('content')

<div class="max-w-7xl mx-auto p-8">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Katalog Produk
            </h1>
            <p class="text-gray-500 mt-2">
                Kelola produk ukiran yang tersedia untuk pelanggan.
            </p>
        </div>

        <a href="{{ route('products.create') }}"
            class="mt-4 md:mt-0 flex items-center gap-2 bg-amber-700 text-white px-5 py-3 rounded-xl hover:bg-amber-800 transition">
            <span class="material-symbols-outlined">
                add
            </span>
            Tambah Produk
        </a>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="mb-5 bg-green-100 text-green-700 px-5 py-4 rounded-xl">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-5 bg-red-100 text-red-700 px-5 py-4 rounded-xl">
            {{ session('error') }}
        </div>
    @endif

    {{-- Card --}}
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">

        {{-- Search --}}
        <div class="p-6 border-b flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold text-gray-800">
                    Daftar Produk
                </h2>
                <p class="text-sm text-gray-500">
                    Total {{ count($products) }} produk
                </p>
            </div>
            <div class="relative">
                <span class="absolute left-3 top-2.5 text-gray-400">
                    <span class="material-symbols-outlined">
                        search
                    </span>
                </span>
                <input
                    type="text"
                    id="searchProduct"
                    placeholder="Cari produk..."
                    class="pl-10 pr-4 py-2 rounded-xl border-gray-200 bg-gray-50 focus:ring-amber-500">
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full" id="productTable">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">
                            Gambar
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">
                            Nama Produk
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">
                            Jenis Ukiran
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">
                            Bahan
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">
                            Harga
                        </th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700">
                            Aksi
                        </th>
                    </tr>
                </thead>

<tbody>
@forelse($products as $product)
<tr
    class="product-row border-b border-gray-100 hover:bg-amber-50 hover:shadow-sm transition-all duration-200 cursor-pointer"

    data-nama="{{ $product['nama_product'] }}"
    data-jenis="{{ $product['jenis_ukiran'] }}"
    data-ukuran="{{ $product['ukuran'] }}"
    data-bahan="{{ $product['bahan'] }}"
    data-motif="{{ $product['motif'] }}"
    data-harga="{{ number_format($product['estimasi_harga'],0,',','.') }}"
    data-deskripsi="{{ $product['deskripsi'] }}"
    data-gambar="{{ $product['gambar'] }}">

    {{-- Gambar --}}
    <td class="px-6 py-4">
        @if(!empty($product['gambar']))
            <img
                src="{{ $product['gambar'] }}"
                class="w-24 h-24 rounded-xl object-cover border border-gray-200 shadow">
        @else
            <div class="w-20 h-20 rounded-xl bg-gray-100 flex items-center justify-center">
                <span class="material-symbols-outlined text-gray-400">
                    image
                </span>
            </div>
        @endif
    </td>

    {{-- Nama --}}
    <td class="px-6 py-4">
        <h3 class="font-semibold text-gray-800">
            {{ $product['nama_product'] }}
        </h3>

        <p class="text-sm text-gray-500 mt-1">
            {{ Str::limit($product['deskripsi'] ?? '-',50) }}
        </p>
    </td>

    {{-- Jenis Ukiran --}}
    <td class="px-6 py-4">
        <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-sm font-medium text-amber-700">
            {{ $product['jenis_ukiran'] ?? '-' }}
        </span>
    </td>

    {{-- Bahan --}}
    <td class="px-6 py-4">
        <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-sm text-gray-700">
            {{ $product['bahan'] ?? '-' }}
        </span>
    </td>

    {{-- Harga --}}
    <td class="px-6 py-4">
        <span class="inline-flex items-center rounded-full bg-green-100 px-4 py-2 text-green-700 font-bold">
            Rp {{ number_format($product['estimasi_harga'],0,',','.') }}
        </span>
    </td>

    {{-- Aksi --}}
    <td class="px-6 py-4">

        <div class="flex justify-center gap-2">

            {{-- Edit --}}
            <a
                onclick="event.stopPropagation();"
                href="{{ route('products.edit',$product['id']) }}"
                title="Edit"
                class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 text-blue-700 transition hover:bg-blue-200">

                <span class="material-symbols-outlined">
                    edit
                </span>

            </a>

            {{-- Delete --}}
            <form
                onclick="event.stopPropagation();"
                action="{{ route('products.destroy',$product['id']) }}"
                method="POST">

                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    title="Hapus"
                    onclick="return confirm('Hapus produk ini?')"
                    class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-100 text-red-700 transition hover:bg-red-200">

                    <span class="material-symbols-outlined">
                        delete
                    </span>

                </button>

            </form>

        </div>

    </td>

</tr>

@empty

<tr>
    <td colspan="6" class="text-center py-10 text-gray-500">
        Belum ada produk.
    </td>
</tr>

@endforelse
</tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Detail Produk --}}
<div id="productModal"
class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50 p-6">

<div
class="relative bg-white rounded-3xl shadow-2xl w-full max-w-5xl overflow-hidden">

<button
id="closeModal"
class="absolute right-5 top-5 w-10 h-10 rounded-full bg-white shadow hover:bg-red-50">

<span class="material-symbols-outlined">
close
</span>

</button>

<div class="grid md:grid-cols-2">

<div class="bg-gray-100">

<img
id="modalImage"
src=""
class="w-full h-full min-h-[520px] object-cover">

</div>

<div class="p-10 overflow-y-auto">

<h2
id="modalNama"
class="text-3xl font-bold text-gray-800 mb-3">
</h2>

<div
id="modalJenis"
class="inline-block bg-amber-100 text-amber-700 px-4 py-2 rounded-full font-medium mb-8">
</div>

<div class="grid grid-cols-2 gap-6">

<div>

<p class="text-sm text-gray-500">
Ukuran
</p>

<p
id="modalUkuran"
class="font-semibold text-lg">
</p>

</div>

<div>

<p class="text-sm text-gray-500">
Bahan
</p>

<p
id="modalBahan"
class="font-semibold text-lg">
</p>

</div>

<div>

<p class="text-sm text-gray-500">
Motif
</p>

<p
id="modalMotif"
class="font-semibold text-lg">
</p>

</div>

<div>

<p class="text-sm text-gray-500">
Estimasi Harga
</p>

<p
id="modalHarga"
class="text-3xl font-bold text-green-600">
</p>

</div>

</div>

<div class="mt-8">

<h4 class="text-lg font-semibold mb-2">

Deskripsi Produk

</h4>

<p
id="modalDeskripsi"
class="text-gray-600 leading-8 text-justify">
</p>

</div>

</div>

</div>

</div>

</div>
{{-- Search Script --}}
<script>

// Search
document.getElementById('searchProduct')
.addEventListener('keyup', function(){

    let value = this.value.toLowerCase();

    document.querySelectorAll('#productTable tbody tr')
    .forEach(row=>{

        row.style.display =
        row.innerText.toLowerCase().includes(value)
        ? ''
        : 'none';

    });

});

// Modal
const modal = document.getElementById('productModal');

document.querySelectorAll('.product-row').forEach(row=>{

    row.addEventListener('click',function(){

        document.getElementById('modalNama').textContent =
        this.dataset.nama;

        document.getElementById('modalJenis').textContent =
        this.dataset.jenis;

        document.getElementById('modalUkuran').textContent =
        this.dataset.ukuran;

        document.getElementById('modalBahan').textContent =
        this.dataset.bahan;

        document.getElementById('modalMotif').textContent =
        this.dataset.motif;

        document.getElementById('modalHarga').textContent =
        this.dataset.harga;

        document.getElementById('modalDeskripsi').textContent =
        this.dataset.deskripsi;

        let gambar = this.dataset.gambar;

        document.getElementById('modalImage').src =
            gambar && gambar !== ''
            ? gambar
            : 'https://placehold.co/600x400?text=No+Image';

        modal.classList.remove('hidden');
        modal.classList.add('flex');

    });

});

// Tutup modal
document.getElementById('closeModal')
.addEventListener('click',function(){

    modal.classList.remove('flex');
    modal.classList.add('hidden');

});

// Klik background
modal.addEventListener('click',function(e){

    if(e.target===modal){

        modal.classList.remove('flex');
        modal.classList.add('hidden');

    }

});

</script>
@endsection
