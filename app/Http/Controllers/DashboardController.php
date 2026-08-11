<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function index(Request $request)
    {
        try {
            $response = $this->api->get('/reports/summary', [
                'page' => $request->get('page', 1)
            ]);

            if (!$response->successful()) {
                return view('dashboard.index', [
                    'ringkasan' => [],
                    'orders' => [],
                    'progressProduksi' => [
                        ['name' => 'Persiapan', 'value' => 0],
                        ['name' => 'Pengukiran', 'value' => 0],
                        ['name' => 'Finishing', 'value' => 0],
                    ],
                    'aktivitas' => [],
                    'user' => Session::get('user'),
                ])->with('error', 'Gagal memuat data dari server.');
            }

            $data = $response->json();
            $ringkasan = $data['ringkasan'] ?? [];

            // Tangkap data pesanan dengan aman dari format paginasi API
            $paginatorData = $data['data'] ?? [];
            $orders = is_array($paginatorData) ? ($paginatorData['data'] ?? $paginatorData) : [];

            $totalDiproses = $ringkasan['total_diproses'] ?? 0;

            // Hitung persentase progress berdasarkan status pesanan yang sedang diproses
            $countPersiapan = 0;
            $countPengukiran = 0;
            $countFinishing = 0;

            foreach ($orders as $order) {
                $statusPesanan = is_array($order) ? ($order['status_pesanan'] ?? '') : ($order->status_pesanan ?? '');

                if (strtolower($statusPesanan) === 'diproses') {
                    $latestStatus = is_array($order) ? ($order['latest_status']['status'] ?? null) : ($order->latest_status->status ?? null);
                    $statusTerakhir = strtolower($latestStatus ?? 'persiapan');

                    if ($statusTerakhir === 'persiapan') $countPersiapan++;
                    elseif ($statusTerakhir === 'pengukiran') $countPengukiran++;
                    elseif ($statusTerakhir === 'finishing') $countFinishing++;
                    else $countPersiapan++; // Default fallback jika belum terekam
                }
            }

            $progressProduksi = [
                ['name' => 'Persiapan', 'value' => $totalDiproses > 0 ? round(($countPersiapan / $totalDiproses) * 100) : 0],
                ['name' => 'Pengukiran', 'value' => $totalDiproses > 0 ? round(($countPengukiran / $totalDiproses) * 100) : 0],
                ['name' => 'Finishing', 'value' => $totalDiproses > 0 ? round(($countFinishing / $totalDiproses) * 100) : 0],
            ];

            // Aktivitas workshop dapat dikosongkan sementara atau ditarik jika endpoint API mendukungnya
            $aktivitas = [];

            return view('dashboard.index', [
                'ringkasan' => $ringkasan,
                'orders' => $orders,
                'progressProduksi' => $progressProduksi,
                'aktivitas' => $aktivitas,
                'user' => Session::get('user'),
            ]);

        } catch (\Exception $e) {
            return view('dashboard.index', [
                'ringkasan' => [],
                'orders' => [],
                'progressProduksi' => [
                    ['name' => 'Persiapan', 'value' => 0],
                    ['name' => 'Pengukiran', 'value' => 0],
                    ['name' => 'Finishing', 'value' => 0],
                ],
                'aktivitas' => [],
                'user' => Session::get('user'),
            ])->with('error', 'Koneksi ke API Server gagal: ' . $e->getMessage());
        }
    }
}
