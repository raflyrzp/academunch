<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    function index()
    {
        return view('auth.login');
    }

    function login(Request $request)
    {
        $request->validate(
            [
                'email' => 'required',
                'password' => 'required',
            ],
            [
                'email.required' => 'Email harus diisi',
                'password.required' => 'Password harus diisi',
            ]
        );

        $infologin = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($infologin)) {
            if (Auth::user()->role == "admin") {
                return redirect()->route('admin.index');
            } else if (Auth::user()->role == "siswa") {
                return redirect()->route('siswa.index');
            } else if (Auth::user()->role == "bank") {
                return redirect()->route('bank.index');
            } else if (Auth::user()->role == "kantin") {
                return redirect()->route('kantin.index');
            }
        } else {
            return redirect(route('login'))->withErrors('Email dan password yang dimasukkan tidak sesuai')->withInput();
        }
    }

    public function regist()
    {
        return view('auth.regist');
    }

    public function store(Request $request)
    {
        $validation = $request->validate([
            "nama" => "required",
            'email' => 'required|email|unique:users',
            "password" => "required",
            "role" => "required"
        ]);

        if ($request->password !== $request->confirmPassword) {
            return redirect(route('regist'))->withErrors('Password dan Konfirmasi Password tidak sama.')->withInput();
        }

        $user = User::create($validation);

        $rekening = '64' . $user->id . now()->format('YmdHis');
        Wallet::create([
            'rekening' => $rekening,
            'id_user' => $user->id,
            'saldo' => 0,
            'status' => 'aktif'
        ]);

        return redirect()->route('login')->with('success', 'Berhasil menambahkan sebuah data pengguna baru!');
    }

    function logout()
    {
        session()->flush();
        Auth::logout();
        return redirect('');
    }
}
