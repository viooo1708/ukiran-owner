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

                    'user' => Session::get('user'),

                ])->with('error', 'Gagal mengambil data dashboard.');
            }

            $data = $response->json();

            return view('dashboard.index', [

                'ringkasan' => $data['ringkasan'] ?? [],

                'orders' => $data['data'] ?? [],

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

                'user' => Session::get('user'),

            ])->with('error', 'Backend API tidak dapat dihubungi.');
        }
    }
}
