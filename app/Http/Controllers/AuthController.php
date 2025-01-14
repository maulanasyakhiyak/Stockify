<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Events\UserActivityLogged;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

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
            User::where('id',Auth::user()->id)->update(['is_active' => true]);

            switch (Auth::user()->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard')->with('success', 'Berhasil login!!');
                case 'manager':
                    return redirect()->route('manager.dashboard')->with('success', 'Berhasil login!!');
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
        User::where('id',Auth::user()->id)->update(['is_active' => false]);
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah logout');
    }

    public function showLinkRequestForm(){
        return view('guest.forgot-password');
    }

    public function sendResetLinkEmail(Request $request){
        $request->validate(['email' => 'required|email']);

        // Mengirimkan link reset password
        $response = Password::sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
        ? back()->with('status', 'Link reset password telah dikirimkan!')
        : back()->withErrors(['email' => 'Email tidak ditemukan.']);

    }

    public function showResetForm($token)
    {
        return view('guest.reset-form', ['token' => $token]); // Menyertakan token di view
    }

    public function reset(Request $request)
    {
        // Validasi form reset password
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required',
        ]);

        // Memperbarui password
        $response = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        // Cek jika reset password berhasil
        return $response == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Password berhasil direset!')
            : back()->withErrors(['email' => 'Gagal mereset password.']);
    }
}
