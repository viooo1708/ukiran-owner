<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    /**
     * Service untuk komunikasi dengan Backend API.
     */
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    /**
     * Menampilkan Dashboard Owner.
     */
    public function index()
    {
        // Nilai default untuk struktur progress produksi
        $defaultProgress = [
            ['name' => 'Pahatan', 'value' => 0],
            ['name' => 'Finishing', 'value' => 0],
            ['name' => 'Perakitan', 'value' => 0]
        ];

        try {
            // Ambil ringkasan laporan dari Backend API
            $response = $this->api->get('/reports/summary');

            // Jika token tidak valid
            if ($response->status() === 401) {
                Session::flush();
                return redirect('/login')
                    ->with('error', 'Sesi login telah berakhir.');
            }

            // Jika gagal mengambil data
            if (!$response->successful()) {
                return view('dashboard.index', [
                    'ringkasan' => [
                        'total_pesanan' => 0,
                        'total_selesai' => 0,
                        'total_diproses' => 0,
                        'total_dibatalkan' => 0,
                        'total_pendapatan_estimasi' => 0,
                    ],
                    'orders' => [],
                    'progressProduksi' => $defaultProgress, // Kirim nilai 0
                    'user' => Session::get('user'),
                ])->with('error', 'Gagal mengambil data dashboard.');
            }

            $data = $response->json();
            $ringkasan = $data['ringkasan'] ?? [];

            // LOGIKA DINAMIS: Menghitung progress berdasarkan data riil API
            $totalDiproses = $ringkasan['total_diproses'] ?? 0;
            $totalSelesai = $ringkasan['total_selesai'] ?? 0;
            $totalPesanan = $ringkasan['total_pesanan'] ?? 0;

            if ($totalPesanan > 0) {
                // Skema hitungan: Persentase naik seiring banyaknya pesanan selesai & diproses
                $baseProgress = ($totalSelesai / $totalPesanan) * 100;

                // Jika ada yang sedang diproses, berikan bobot tambahan di tiap divisi workshop
                $tahapPahatan   = min(100, round($baseProgress + ($totalDiproses > 0 ? 40 : 0)));
                $tahapFinishing = min(100, round($baseProgress + ($totalDiproses > 0 ? 20 : 0)));
                $tahapPerakitan = min(100, round($baseProgress));
            } else {
                $tahapPahatan = 0;
                $tahapFinishing = 0;
                $tahapPerakitan = 0;
            }

            $progressProduksi = [
                ['name' => 'Pahatan', 'value' => $tahapPahatan],
                ['name' => 'Finishing', 'value' => $tahapFinishing],
                ['name' => 'Perakitan', 'value' => $tahapPerakitan]
            ];

            return view('dashboard.index', [
                'ringkasan' => $ringkasan,
                'orders' => $data['data'] ?? [],
                'progressProduksi' => $progressProduksi, // Data dinamis sukses dikirim!
                'user' => Session::get('user'),
            ]);

        } catch (\Exception $e) {
            return view('dashboard.index', [
                'ringkasan' => [
                    'total_pesanan' => 0,
                    'total_selesai' => 0,
                    'total_diproses' => 0,
                    'total_dibatalkan' => 0,
                    'total_pendapatan_estimasi' => 0,
                ],
                'orders' => [],
                'progressProduksi' => $defaultProgress, // Kirim nilai 0 saat catch eror
                'user' => Session::get('user'),
            ])->with('error', 'Backend API tidak dapat dihubungi.');
        }
    }
}
