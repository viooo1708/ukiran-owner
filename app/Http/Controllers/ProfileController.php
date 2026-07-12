<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    /**
     * Menampilkan halaman profil.
     */
    public function index()
    {
        try {

            $response = $this->api->get('/profile');

            if (!$response->successful()) {

                return redirect()
                    ->back()
                    ->with('error', 'Gagal mengambil data profil.');

            }

            $profile = $response->json()['data'];

            return view('profile.index', compact('profile'));

        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->with('error', 'Backend API tidak dapat dihubungi.');

        }
    }

    /**
     * Update profil owner.
     */
    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:150',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'password' => 'nullable|confirmed|min:8',
            'foto' => 'nullable|image|max:2048',
        ]);

        try {

            $data = [
                'nama' => $request->nama,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ];

            if ($request->filled('password')) {
                $data['password'] = $request->password;
                $data['password_confirmation'] = $request->password_confirmation;
            }

            // Jika upload foto
            if ($request->hasFile('foto')) {

                $response = $this->api->upload(
                    '/profile?_method=PUT',
                    $data,
                    $request->file('foto')->getRealPath(),
                    'foto'
                );

            } else {

                $response = $this->api->put('/profile', $data);

            }

            if (!$response->successful()) {

                $message = $response->json()['message']
                    ?? 'Profil gagal diperbarui.';

                return back()
                    ->withInput()
                    ->with('error', $message);

            }

            $profile = $response->json()['data'];

            // Perbarui session user
            Session::put('user', $profile);

            return redirect()
                ->route('profile.index')
                ->with('success', 'Profil berhasil diperbarui.');

        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with('error', 'Backend API tidak dapat dihubungi.');

        }
    }
}
