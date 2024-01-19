<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Data Pengguna';
        $users = User::all();

        return view('admin.data_pengguna', compact('title', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            "nama" => "required",
            'email' => 'required|email|unique:users',
            "password" => "required",
            "role" => "required"
        ]);

        $user = User::create($validation);

        $rekening = '64' . $user->id . now('dmYHis');
        Wallet::create([
            'rekening' => $rekening,
            'id_user' => $user->id,
            'saldo' => 0,
            'status' => 'aktif'
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan sebuah data pengguna baru!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            "nama" => "required",
            "role" => "required",
            Rule::unique('users', 'email')->ignore($id),
        ]);

        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'Pengguna tidak ditemukan.');
        }

        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        if ($request->password) {
            $request->validate([
                'password' => 'min:8'
            ]);
            $user->password = bcrypt($request->password);
            $user->save();
        }

        return redirect()->back()->with('success', 'Berhasil mengedit sebuah data pengguna!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // if ($user->wallets) {
        //     $user->wallets->delete();
        // }

        $user->delete();

        return redirect()->back()->with('success', 'Berhasil menghapus sebuah data pengguna!');
    }
}
