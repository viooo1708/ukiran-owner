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
        // 1. Validasi input dari form edit
        $request->validate([
            'nama'   => 'required|string|max:150',
            'no_hp'  => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'role'   => 'required|string|in:pelanggan,owner',
        ]);

        try {
            // 2. Siapkan data yang akan dikirim ke API
            $data = [
                'nama'   => $request->nama,
                'no_hp'  => $request->no_hp,
                'alamat' => $request->alamat,
                'role'   => $request->role,
            ];

            // 3. Kirim request PUT ke endpoint /users/{id} di API Backend
            $response = $this->api->put("/users/$id", $data);

            // 4. Jika API mengembalikan error
            if (!$response->successful()) {
                $message = $response->json()['message'] ?? 'Gagal memperbarui data pelanggan.';
                return back()->withInput()->with('error', $message);
            }

            // 5. Jika sukses, redirect kembali ke halaman kelola pelanggan (profile.index)
            return redirect()
                ->route('users.index')
                ->with('success', 'Data pelanggan berhasil diperbarui.');

        } catch (\Exception $e) {
            // 6. Antisipasi jika server API offline atau crash
            return back()
                ->withInput()
                ->with('error', 'Backend API tidak dapat dihubungi.');
        }
    }

    public function destroy($id)
    {
        $response = $this->api->delete("/users/$id");

        return redirect()->route('users.index')
            ->with('success', 'Pelanggan berhasil dihapus.');
    }
}
