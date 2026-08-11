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
        'tahap_produksi' => 'required|in:persiapan,pengukiran,finishing'
    ]);

    try {
        // Ubah key 'tahap_produksi' menjadi 'status' agar cocok dengan ProductStatusController di Backend API
        $response = $this->api->put("/orders/{$id}/production-status", [
            'status' => $request->tahap_produksi
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
            'jumlah_dp' => 'nullable|numeric|min:0',
            'status_pembayaran' => 'nullable|in:belum_bayar,dp_dibayar,lunas',
            'estimasi_waktu' => 'nullable|string|max:100',
            'estimasi_selesai' => 'nullable|date',
            'tahap_produksi' => 'nullable|in:persiapan,pengukiran,finishing',
            'catatan'        => 'nullable|string',
        ]);

        try {
            $dataPayload = [
                'status_pesanan' => $request->status_pesanan,
                'estimasi_biaya' => $request->estimasi_biaya,
                'jumlah_dp' => $request->jumlah_dp,
                'status_pembayaran' => $request->status_pembayaran,
                'estimasi_waktu' => $request->estimasi_waktu,
                'estimasi_selesai' => $request->estimasi_selesai,
                'catatan'        => $request->catatan,
            ];

            // HANYA SERTAKAN tahap_produksi jika status pesanannya benar-benar 'diproses'
            if ($request->status_pesanan === 'diproses') {
                $dataPayload['status'] = $request->tahap_produksi; // Ubah dari 'tahap_produksi' ke 'status'
            }

            $response = $this->api->put("/orders/$id", $dataPayload);
            $resJson = $response->json();

            $isSuccess = $response->successful() || (is_array($resJson) && ($resJson['success'] ?? false) === true);

            if (!$isSuccess) {
                return back()
                    ->withInput()
                    ->with('error', 'Pesanan gagal diperbarui oleh server API: ' . ($resJson['message'] ?? 'Kesalahan tidak diketahui'));
            }

            return redirect()
                ->route('orders.index')
                ->with('success', 'Status pesanan berhasil diperbarui.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * Get chat via API proxy
     */
    public function getChats($id)
    {
        try {
            $response = $this->api->get("/orders/{$id}/chats");
            return response()->json($response->json(), $response->status());
        } catch (\Exception $e) {
            return response()->json(['error' => 'API Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Store chat via API proxy
     */
    public function storeChat(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        try {
            $response = $this->api->post("/orders/{$id}/chats", [
                'message' => $request->message
            ]);
            return response()->json($response->json(), $response->status());
        } catch (\Exception $e) {
            return response()->json(['error' => 'API Error: ' . $e->getMessage()], 500);
        }
    }
}
