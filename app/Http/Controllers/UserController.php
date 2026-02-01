<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    protected WalletService $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.data_pengguna', [
            'title' => 'Data Pengguna',
            'users' => User::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required|in:admin,siswa,bank,kantin',
        ]);

        $user = User::create($validated);

        $this->walletService->createWallet($user->id);

        return redirect()->back()->with('success', 'Berhasil menambahkan sebuah data pengguna baru!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($id),
            ],
            'role' => 'required|in:admin,siswa,bank,kantin',
            'password' => 'nullable|min:8',
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ]);

        if (!empty($validated['password'])) {
            $user->update(['password' => bcrypt($validated['password'])]);
        }

        return redirect()->back()->with('success', 'Berhasil mengedit sebuah data pengguna!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Berhasil menghapus sebuah data pengguna!');
    }
}
