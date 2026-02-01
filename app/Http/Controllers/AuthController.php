<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\WalletService;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected WalletService $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    /**
     * Tampilkan halaman login
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return $this->redirectBasedOnRole(Auth::user()->role);
        }

        return redirect()
            ->route('login')
            ->withErrors('Email dan password yang dimasukkan tidak sesuai')
            ->withInput();
    }

    /**
     * Tampilkan halaman registrasi
     */
    public function regist()
    {
        return view('auth.regist');
    }

    /**
     * Proses registrasi
     */
    public function store(RegisterRequest $request)
    {
        $user = User::create($request->only(['nama', 'email', 'password', 'role']));

        $this->walletService->createWallet($user->id);

        return redirect()
            ->route('login')
            ->with('success', 'Berhasil menambahkan sebuah data pengguna baru!');
    }

    /**
     * Proses logout
     */
    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Redirect berdasarkan role user
     */
    protected function redirectBasedOnRole(string $role)
    {
        $routes = [
            'admin' => 'admin.index',
            'siswa' => 'siswa.index',
            'bank' => 'bank.index',
            'kantin' => 'kantin.index',
        ];

        return redirect()->route($routes[$role] ?? 'login');
    }
}
