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

    /**
     * Update status pesanan.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status_pesanan' => 'required|in:menunggu_konfirmasi,diproses,dibatalkan,selesai',
            'estimasi_biaya' => 'nullable|numeric',
            'estimasi_waktu' => 'nullable|string|max:100',
            'catatan' => 'nullable|string',
        ]);

        try {

            $response = $this->api->put("/orders/$id", [

                'status_pesanan' => $request->status_pesanan,

                'estimasi_biaya' => $request->estimasi_biaya,

                'estimasi_waktu' => $request->estimasi_waktu,

                'catatan' => $request->catatan,

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

            return back()
                ->withInput()
                ->with('error', 'Backend API tidak dapat dihubungi.');

        }
    }
}
