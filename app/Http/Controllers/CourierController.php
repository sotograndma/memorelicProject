<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CourierController extends Controller
{
    /**
     * Menampilkan daftar kurir.
     */
    public function index()
    {
        $couriers = Courier::all();
        return view('admin.users.couriers.index', compact('couriers'));
    }

    /**
     * Menampilkan form untuk membuat akun kurir.
     */
    public function create()
    {
        return view('admin.users.couriers.create');
    }

    /**
     * Menyimpan akun kurir baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:couriers',
            'email' => 'required|string|email|max:255|unique:couriers|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        Courier::createWithUser($request->all());

        return redirect()->route('admin.couriers.index')->with('success', 'Kurir berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit akun kurir.
     */
    public function edit($id)
    {
        $courier = Courier::findOrFail($id);
        return view('admin.users.couriers.edit', compact('courier'));
    }

    /**
     * Memperbarui akun kurir.
     */
    public function update(Request $request, $id)
    {
        $courier = Courier::findOrFail($id);

        $request->validate([
            'username' => 'required|string|max:255|unique:couriers,username,' . $courier->id,
            'email' => 'required|string|email|max:255|unique:couriers,email,' . $courier->id . '|unique:users,email,' . $courier->user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $courier->update([
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $courier->password,
        ]);

        // Perbarui juga di tabel users
        $courier->user->update([
            'name' => $request->username,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $courier->user->password,
        ]);

        return redirect()->route('admin.couriers.index')->with('success', 'Kurir berhasil diperbarui.');
    }

    /**
     * Menghapus akun kurir.
     */
    public function destroy($id)
    {
        $courier = Courier::findOrFail($id);
        $courier->user()->delete(); // Hapus dari tabel users
        $courier->delete(); // Hapus dari tabel couriers

        return redirect()->route('admin.couriers.index')->with('success', 'Kurir berhasil dihapus.');
    }
}
