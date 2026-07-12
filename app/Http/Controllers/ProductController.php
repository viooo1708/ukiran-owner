<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    /**
     * Menampilkan daftar produk.
     */
    public function index()
    {
        try {

            $response = $this->api->get('/products');

            if (!$response->successful()) {
                return back()->with('error', 'Gagal mengambil data produk.');
            }

            $products = $response->json()['data'] ?? [];

            return view('products.index', compact('products'));

        } catch (\Exception $e) {

            return back()->with('error', 'Backend API tidak dapat dihubungi.');

        }
    }

    /**
     * Form tambah produk.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Simpan produk baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_product' => 'required',
            'estimasi_harga' => 'required|numeric',
            'gambar' => 'nullable|image|max:2048',
        ]);

        try {

            $data = [
                'nama_product' => $request->nama_product,
                'jenis_ukiran' => $request->jenis_ukiran,
                'ukuran' => $request->ukuran,
                'bahan' => $request->bahan,
                'motif' => $request->motif,
                'deskripsi' => $request->deskripsi,
                'estimasi_harga' => $request->estimasi_harga,
            ];

            if ($request->hasFile('gambar')) {

                $response = $this->api->upload(
                    '/products',
                    $data,
                    $request->file('gambar')->getRealPath(),
                    'gambar'
                );

            } else {

                $response = $this->api->post('/products', $data);

            }

            if (!$response->successful()) {

                return back()
                    ->withInput()
                    ->with('error', 'Produk gagal ditambahkan.');

            }

            return redirect()
                ->route('products.index')
                ->with('success', 'Produk berhasil ditambahkan.');

        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with('error', 'Backend API tidak dapat dihubungi.');

        }
    }

    /**
     * Form edit produk.
     */
    public function edit($id)
    {
        try {

            $response = $this->api->get("/products/$id");

            if (!$response->successful()) {

                return redirect()
                    ->route('products.index')
                    ->with('error', 'Produk tidak ditemukan.');

            }

            $product = $response->json()['data'];

            return view('products.edit', compact('product'));

        } catch (\Exception $e) {

            return redirect()
                ->route('products.index')
                ->with('error', 'Backend API tidak dapat dihubungi.');

        }
    }

    /**
     * Update produk.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_product' => 'required',
            'estimasi_harga' => 'required|numeric',
        ]);

        try {

            $data = [
                'nama_product' => $request->nama_product,
                'jenis_ukiran' => $request->jenis_ukiran,
                'ukuran' => $request->ukuran,
                'bahan' => $request->bahan,
                'motif' => $request->motif,
                'deskripsi' => $request->deskripsi,
                'estimasi_harga' => $request->estimasi_harga,
            ];

            if ($request->hasFile('gambar')) {

                $response = $this->api->upload(
                    "/products/$id?_method=PUT",
                    $data,
                    $request->file('gambar')->getRealPath(),
                    'gambar'
                );

            } else {

                $response = $this->api->put("/products/$id", $data);

            }

            if (!$response->successful()) {

                return back()
                    ->withInput()
                    ->with('error', 'Produk gagal diperbarui.');

            }

            return redirect()
                ->route('products.index')
                ->with('success', 'Produk berhasil diperbarui.');

        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with('error', 'Backend API tidak dapat dihubungi.');

        }
    }

    /**
     * Hapus produk.
     */
    public function destroy($id)
    {
        try {

            $response = $this->api->delete("/products/$id");

            if (!$response->successful()) {

                return back()
                    ->with('error', 'Produk gagal dihapus.');

            }

            return redirect()
                ->route('products.index')
                ->with('success', 'Produk berhasil dihapus.');

        } catch (\Exception $e) {

            return back()
                ->with('error', 'Backend API tidak dapat dihubungi.');

        }
    }
}
