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

            if ($request->filled('dari')) {
                $query['dari'] = $request->dari;
            }

            if ($request->filled('sampai')) {
                $query['sampai'] = $request->sampai;
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

                'dari' => $request->dari,

                'sampai' => $request->sampai,

            ]);

        } catch (\Exception $e) {

            return view('reports.index', [

                'ringkasan' => [],

                'orders' => [],

            ])->with('error', 'Backend API tidak dapat dihubungi.');

        }
    }
}
