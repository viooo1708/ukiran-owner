<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    /**
     * Menampilkan halaman laporan.
     */
    public function index(Request $request)
    {
        try {
            $query = [];

            // KOREKSI: Tangkap "tanggal_mulai" dari Blade, lalu masukkan sebagai "dari" untuk API
            if ($request->filled('tanggal_mulai')) {
                $query['dari'] = $request->tanggal_mulai;
            }

            // KOREKSI: Tangkap "tanggal_selesai" dari Blade, lalu masukkan sebagai "sampai" untuk API
            if ($request->filled('tanggal_selesai')) {
                $query['sampai'] = $request->tanggal_selesai;
            }

            $response = $this->api->get('/reports/summary', $query);

            if (!$response->successful()) {
                return view('reports.index', [
                    'ringkasan' => [],
                    'orders' => [],
                ])->with('error', 'Gagal mengambil data laporan.');
            }

            $data = $response->json();

            return view('reports.index', [
                'ringkasan' => $data['ringkasan'] ?? [],
                'orders' => $data['data'] ?? [],
                // KOREKSI: Kembalikan nilai ke Blade agar input tanggal tidak ter-reset setelah submit
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
            ]);

        } catch (\Exception $e) {
            return view('reports.index', [
                'ringkasan' => [],
                'orders' => [],
            ])->with('error', 'Backend API tidak dapat dihubungi.');
        }
    }
}
