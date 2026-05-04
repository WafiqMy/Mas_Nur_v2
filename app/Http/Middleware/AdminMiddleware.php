<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Session::get('user');

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $role = strtolower(trim((string) ($user['role'] ?? '')));

        if ($role !== 'admin') {
            return redirect()->route('home')
                ->with('error', 'Akses ditolak. Halaman ini hanya untuk admin.');
        }

        return $next($request);
    }
}
