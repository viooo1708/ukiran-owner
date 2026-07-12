<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class OwnerMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah token tersedia
        if (!Session::has('token')) {

            return redirect('/login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data user dari session
        $user = Session::get('user');

        // Cek apakah data user ada
        if (!$user) {

            Session::flush();

            return redirect('/login')
                ->with('error', 'Sesi login tidak valid.');
        }

        // Cek role owner
        if (($user['role'] ?? null) !== 'owner') {

            Session::flush();

            return redirect('/login')
                ->with('error', 'Anda tidak memiliki akses ke halaman Owner.');
        }

        return $next($request);
    }
}
