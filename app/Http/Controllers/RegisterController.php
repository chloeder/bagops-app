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
        $validated = $request->validate(
            [
                'satuan_kerja_id' => 'required|in:1,2,3,4,5,6,7,8,9,10,11',
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8|max:255',
            ],
            [
                'name.required' => 'Nama tidak boleh kosong',
                'name.max' => 'Nama tidak boleh lebih dari 255 karakter',
                'username.required' => 'Username tidak boleh kosong',
                'username.unique' => 'Username sudah terdaftar',
                'email.required' => 'Email tidak boleh kosong',
                'email.email' => 'Email tidak valid',
                'email.unique' => 'Email sudah terdaftar',
                'password.required' => 'Password tidak boleh kosong',
                'password.min' => 'Password tidak boleh kurang dari 8 karakter',
                'password.max' => 'Password tidak boleh lebih dari 255 karakter',
                'satuan_kerja_id.required' => 'Satuan Kerja tidak boleh kosong',
                'satuan_kerja_id.in' => 'Satuan Kerja tidak boleh kosong',

            ]
        );
        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);
        $user = User::where('role', 1)->get();
        Notification::send($user, new NewUser($validated));
        return redirect()->route('login')->with('success', 'Registrasi telah berhasil, Menunggu konfirmasi dari admin');
    }
}
