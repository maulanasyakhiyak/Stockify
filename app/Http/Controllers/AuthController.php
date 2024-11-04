<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function showLogin()
    {
        return view('guest.sign-in');
    }

    public function login(Request $r)
    {
        // Validasi input
        $r->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Ambil data untuk autentikasi
        $credentials = $r->only('email', 'password');

        // Opsi remember me
        $remember = $r->has('remember');

        // Coba autentikasi pengguna
        if (Auth::attempt($credentials, $remember)) {
            // Regenerasi session untuk keamanan
            $r->session()->regenerate();

            switch (Auth::user()->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard')->with('success', 'Berhasil login!!');
                case 'manajer':
                    return redirect()->route('manajer.dashboard')->with('success', 'Berhasil login!!');
                case 'staff':
                    return redirect()->route('staff.dashboard')->with('success', 'Berhasil login!!');
                default:
                    Auth::logout();

                    return redirect()->back()->withErrors(['error' => 'Role pengguna tidak valid.', 'email' => 'Role pengguna tidak valid.']);
            }
        }

        // Jika gagal, kembali ke halaman login dengan pesan error
        return redirect()->back()->withErrors(['error' => 'Email atau password salah.'])->onlyInput('email');

    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah logout');
    }
}
