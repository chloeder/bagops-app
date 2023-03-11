<?php

namespace App\Http\Controllers;

use App\Models\SatuanKerja;
use App\Models\User;
use App\Notifications\ForAdminNotif;
use App\Notifications\NewUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class RegisterController extends Controller
{
    public function index()
    {
        $satker = SatuanKerja::where('id', '>', 1)->get();
        return view('auth.register', compact('satker'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:users',
            'username' => 'required|min:3|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|max:255',
            'satuan_kerja_id' => 'required',
        ]);
        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);
        $user = User::where('role', 1)->get();
        Notification::send($user, new NewUser($validated));
        return redirect()->route('login')->with('success', 'Registrasi telah berhasil, Menunggu konfirmasi dari admin');
    }

    public function forgot_password()
    {
        return view('auth.forgot-password');
    }
}
