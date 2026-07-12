<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    /**
     * Menampilkan halaman login.
     */
    public function index()
    {
        // Jika sudah login, langsung ke dashboard
        if (Session::has('token')) {
            return redirect('/dashboard');
        }

        return view('auth.login');
    }

    /**
     * Proses login owner.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        try {

            $response = $this->api->post('/login', [
                'email' => $request->email,
                'password' => $request->password,
            ]);

            if (!$response->successful()) {

                $message = $response->json()['message']
                    ?? 'Email atau password salah.';

                return back()
                    ->withInput()
                    ->with('error', $message);
            }

            $result = $response->json();

            // Pastikan hanya owner yang boleh login
            if (($result['user']['role'] ?? null) !== 'owner') {

                return back()
                    ->withInput()
                    ->with('error', 'Akun ini bukan akun Owner.');
            }

            // Simpan session
            Session::put('token', $result['token']);
            Session::put('user', $result['user']);

            return redirect('/dashboard')
                ->with('success', 'Selamat datang, Owner.');

        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with('error', 'Tidak dapat terhubung ke server API.');
        }
    }

    /**
     * Logout.
     */
    public function logout()
    {
        try {

            $this->api->post('/logout');

        } catch (\Exception $e) {
            // Abaikan jika API tidak dapat dihubungi
        }

        Session::forget('token');
        Session::forget('user');

        Session::flush();

        return redirect('/login')
            ->with('success', 'Logout berhasil.');
    }
}
