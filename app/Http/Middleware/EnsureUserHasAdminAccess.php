<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasAdminAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah sedang mengakses halaman login Filament
        if ($request->routeIs('filament.admin.auth.login')) {
            return $next($request);
        }

        // Use admin guard to check authentication
        $user = $request->user('admin');

        // Jika belum login, arahkan ke halaman login Filament
        if (! $user) {
            return redirect()->route('filament.admin.auth.login');
        }

        // Jika login tapi bukan admin atau teacher
        if (! in_array($user->role, ['admin', 'teacher'])) {
            abort(403, 'Forbidden');
        }

        return $next($request);
    }
}
