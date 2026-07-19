<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use App\Models\Order; // Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        try {
            $response = $this->api->get('/reports/summary');
            // ... (penanganan error tetap sama)

            $data = $response->json();
            $ringkasan = $data['ringkasan'] ?? [];

            // AMBIL DATA PESANAN YANG DIPROSES
            // Kita butuh data pesanan yang status terakhirnya adalah persiapan, pengukiran, atau finishing.
            // Jika API Anda tidak mengirimkan data detail status per pesanan,
            // Anda harus memodifikasi endpoint /reports/summary di Backend Anda.

            $orders = $data['data'] ?? [];
            $totalDiproses = $ringkasan['total_diproses'] ?? 0;

            // Hitung manual berdasarkan data yang diterima dari API
            $countPersiapan = 0;
            $countPengukiran = 0;
            $countFinishing = 0;

            foreach ($orders as $order) {
                if ($order['status_pesanan'] === 'diproses') {
                    $statusTerakhir = $order['latest_status']['status'] ?? null;
                    if ($statusTerakhir === 'persiapan') $countPersiapan++;
                    if ($statusTerakhir === 'pengukiran') $countPengukiran++;
                    if ($statusTerakhir === 'finishing') $countFinishing++;
                }
            }

            // Hitung persentase riil (bukan estimasi)
            $progressProduksi = [
                ['name' => 'Persiapan', 'value' => $totalDiproses > 0 ? round(($countPersiapan / $totalDiproses) * 100) : 0],
                ['name' => 'Pengukiran', 'value' => $totalDiproses > 0 ? round(($countPengukiran / $totalDiproses) * 100) : 0],
                ['name' => 'Finishing', 'value' => $totalDiproses > 0 ? round(($countFinishing / $totalDiproses) * 100) : 0],
            ];

            return view('dashboard.index', [
                'ringkasan' => $ringkasan,
                'orders' => $orders,
                'progressProduksi' => $progressProduksi,
                'user' => Session::get('user'),
            ]);

        } catch (\Exception $e) {
            // ... (penanganan error catch tetap sama)
        }
    }
}
