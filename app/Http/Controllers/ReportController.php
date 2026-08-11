<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ReportController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function index(Request $request)
    {
        try {
            $query = [];

            if ($request->filled('tanggal_mulai')) {
                $query['tanggal_mulai'] = $request->tanggal_mulai;
            }
            if ($request->filled('tanggal_selesai')) {
                $query['tanggal_selesai'] = $request->tanggal_selesai;
            }
            if ($request->filled('status')) {
                $query['status'] = $request->status;
            }
            if ($request->filled('product_id')) {
                $query['product_id'] = $request->product_id;
            }
            if ($request->filled('pelanggan')) {
                $query['pelanggan'] = $request->pelanggan;
            }

            // Tangkap nomor halaman saat ini dari request web
            $query['page'] = $request->get('page', 1);

            $response = $this->api->get('/reports/summary', $query);
            $productResponse = $this->api->get('/products');
            $productsList = collect($productResponse->successful() ? ($productResponse->json()['data'] ?? []) : []);

            if (!$response->successful()) {
                return view('reports.index', [
                    'ringkasan' => [],
                    'orders' => new LengthAwarePaginator([], 0, 10),
                    'productsList' => $productsList,
                ])->with('error', 'Gagal mengambil data laporan.');
            }

            $json = $response->json();
            $paginatorData = $json['data'] ?? [];

            // Rekonstruksi data paginasi dari array hasil API
            $orders = new LengthAwarePaginator(
                $paginatorData['data'] ?? [],
                $paginatorData['total'] ?? 0,
                $paginatorData['per_page'] ?? 10,
                $paginatorData['current_page'] ?? 1,
                ['path' => $request->url(), 'query' => $request->query()]
            );

            return view('reports.index', [
                'ringkasan' => $json['ringkasan'] ?? [],
                'orders' => $orders,
                'productsList' => $productsList,
            ]);

        } catch (\Exception $e) {
            return view('reports.index', [
                'ringkasan' => [],
                'orders' => new LengthAwarePaginator([], 0, 10),
                'productsList' => collect([]),
            ])->with('error', 'Backend API tidak dapat dihubungi.');
        }
    }
}
