<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use App\Models\User;

class NisLoginController extends Controller
{
    /**
     * Tampilkan halaman login (Inertia).
     */
    public function showLoginForm()
    {
        return Inertia::render('auth/login', [
            'status' => session('status'),
        ]);
    }

    /**
     * Proses login berdasarkan NIS dan password.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nis' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('nis', $credentials['nis'])->first();

        if (! $user) {
            return back()->withErrors(['nis' => 'NIS tidak ditemukan.']);
        }

        if (! Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors(['password' => 'Password salah.']);
        }

        Auth::guard('web')->login($user, $request->boolean('remember'));

        $request->session()->regenerate();

        // Only students and teachers can login through this endpoint
        // Admins should use /admin/login for the admin panel
        if ($user->role === 'admin') {
            Auth::guard('web')->logout();
            return back()->withErrors(['nis' => 'Admin harus login melalui panel admin di /admin/login']);
        }

        // Redirect to dashboard for students and teachers
        return redirect()->intended('/');
    }

    /**
     * Logout user dari session.
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
