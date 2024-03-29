<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            if (Auth::user()->status != 'active') {
                Auth::logout();

                $request->session()->invalidate();

                $request->session()->regenerateToken();

                return back()->with('error', 'Akun belum Aktif, Hubungi Petugas Untuk Mengaktifkan Akun');
            }
            $request->session()->regenerate();

            return redirect()->intended('dashboard')->with('success', 'Selamat Datang ' . Auth::user()->name);
        }

        return back()->with('error', 'Username atau Password Anda Salah!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
