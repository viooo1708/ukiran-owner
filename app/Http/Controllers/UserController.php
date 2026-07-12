<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        $response = $this->api->get('/users');

        if (!$response->successful()) {
            return back()->with('error', 'Gagal mengambil data pelanggan.');
        }

        $users = $response->json()['data'];

        return view('users.index', compact('users'));
    }

    public function show($id)
    {
        $response = $this->api->get("/users/$id");

        if (!$response->successful()) {
            abort(404);
        }

        $user = $response->json()['data'];

        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        $response = $this->api->get("/users/$id");

        if (!$response->successful()) {
            abort(404);
        }

        $user = $response->json()['data'];

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $response = $this->api->delete("/users/$id");

        return redirect()->route('users.index')
            ->with('success', 'Pelanggan berhasil dihapus.');
    }
}
