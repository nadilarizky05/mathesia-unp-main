<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileUpdateController extends Controller
{

    public function update(Request $request)
    {
        $user = User::find(Auth::id());
        if (!$user) {
            return back()->with([
                'error' => 'User not found.',
            ]);
        }

        
        // Validasi nama
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        'nis' => 'nullable|string|unique:users,nis,' . $user->id,
    
        ]);

        // Selalu update nama
        $user->name = $request->name;
        $user->email = $request->email;
        $user->nis = $request->nis;

        // Jika user ingin mengganti password
        if ($request->filled('password') || $request->filled('newPassword') || $request->filled('confirmPassword')) {

            $request->validate([
                'password' => 'required',
                'newPassword' => 'required|min:6',
                'confirmPassword' => 'required|same:newPassword',
            ]);

            // Cek password lama
            if (!Hash::check($request->password, $user->password)) {
                return back()->with([
                    'error' => 'Password lama tidak sesuai ❌',
                ]);
            }

            // Update password baru
            $user->password = Hash::make($request->newPassword);
        }

        // Simpan semua perubahan
        $user->save();

        return back()->with([
            'success' => 'Profil berhasil diperbarui ✅',
        ]);
    }
}