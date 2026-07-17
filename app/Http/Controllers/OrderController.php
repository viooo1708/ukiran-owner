<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    /**
     * Menampilkan seluruh pesanan.
     */
    public function index()
    {
        try {

            $response = $this->api->get('/orders');

            if (!$response->successful()) {
                return back()->with('error', 'Gagal mengambil data pesanan.');
            }

            $orders = $response->json()['data'] ?? [];

            return view('orders.index', compact('orders'));

        } catch (\Exception $e) {

            return back()->with('error', 'Backend API tidak dapat dihubungi.');

        }
    }

    /**
     * Menampilkan detail pesanan.
     */
    public function show($id)
    {
        try {

            $response = $this->api->get("/orders/$id");

            if (!$response->successful()) {

                return redirect()
                    ->route('orders.index')
                    ->with('error', 'Pesanan tidak ditemukan.');

            }

            $order = $response->json()['data'];

            return view('orders.show', compact('order'));

        } catch (\Exception $e) {

            return redirect()
                ->route('orders.index')
                ->with('error', 'Backend API tidak dapat dihubungi.');

        }
    }

    /**
     * Form edit status pesanan.
     */
    public function edit($id)
    {
        try {

            $response = $this->api->get("/orders/$id");

            if (!$response->successful()) {

                return redirect()
                    ->route('orders.index')
                    ->with('error', 'Pesanan tidak ditemukan.');

            }

            $order = $response->json()['data'];

            return view('orders.edit', compact('order'));

        } catch (\Exception $e) {

            return redirect()
                ->route('orders.index')
                ->with('error', 'Backend API tidak dapat dihubungi.');

        }
    }

    public function updateProduction(Request $request, $id)
    {
        $request->validate([
            // Samakan juga list-nya di sini
            'tahap_produksi' => 'required|in:persiapan,pengukiran,finishing,selesai'
        ]);

        try {
            // Kirim perubahan status produksi ke Backend API Anda
            $response = $this->api->put("/orders/{$id}/production-status", [
                'tahap_produksi' => $request->tahap_produksi
            ]);

            if ($response->successful()) {
                return redirect()->back()->with('success', 'Tahap produksi berhasil diperbarui!');
            }

            return redirect()->back()->with('error', 'Gagal memperbarui tahap produksi di server.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem koneksi API.');
        }
    }

    /**
     * Update status pesanan.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status_pesanan' => 'required|in:menunggu_konfirmasi,diproses,dibatalkan,selesai',
            'estimasi_biaya' => 'nullable|numeric',
            'estimasi_waktu' => 'nullable|string|max:100',

            // SWASTIKAN BAGIAN INI DISAMAKAN DENGAN API
            'tahap_produksi' => 'nullable|in:persiapan,pengukiran,finishing,selesai',

            'catatan'        => 'nullable|string',
        ]);

        try {
            $response = $this->api->put("/orders/$id", [
                'status_pesanan' => $request->status_pesanan,
                'estimasi_biaya' => $request->estimasi_biaya,
                'estimasi_waktu' => $request->estimasi_waktu,
                'tahap_produksi' => $request->tahap_produksi,
                'catatan'        => $request->catatan,
            ]);

            if (!$response->successful()) {
                return back()
                    ->withInput()
                    ->with('error', 'Pesanan gagal diperbarui.');
            }

            return redirect()
                ->route('orders.index')
                ->with('success', 'Status pesanan berhasil diperbarui.');

        } catch (\Exception $e) {
            // Mengganti dd() dengan redirect back yang aman agar user tidak melihat halaman error mentah
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}
