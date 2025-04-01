<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    /**
     * Menampilkan daftar akun admin dan customer
     */
    public function index()
    {
        $users = User::all();
        $admins = Admin::all();

        return view('admin.users.index', compact('users', 'admins'));
    }

    /**
     * Menampilkan form untuk membuat akun baru
     */
    public function createAdmin()
    {
        return view('admin.users.create_admin');
    }

    public function createCustomer()
    {
        return view('admin.users.create_customer');
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users|unique:admins',
            'password' => 'required|string|min:6|confirmed',
        ]);

        Admin::createWithUser($request->all());

        return redirect()->route('admin.users.index')->with('success', 'Admin berhasil ditambahkan.');
    }

    public function storeCustomer(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users|unique:customers',
            'password' => 'required|string|min:6|confirmed',
        ]);

        Customer::createWithUser($request->all());

        return redirect()->route('admin.users.index')->with('success', 'Customer berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit akun
     */
    public function edit($id, $type)
    {
        if ($type === 'admin') {
            $user = Admin::findOrFail($id);
        } else {
            $user = User::findOrFail($id);
        }

        return view('admin.users.edit', compact('user', 'type'));
    }

    /**
     * Memperbarui akun admin atau customer
     */
    public function update(Request $request, $id, $type)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($id),
                Rule::unique('admins')->ignore($id),
            ],
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if ($type === 'admin') {
            $user = Admin::findOrFail($id);
        } else {
            $user = User::findOrFail($id);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Akun berhasil diperbarui.');
    }

    /**
     * Menghapus akun admin atau customer
     */
    public function destroy($id, $type)
    {
        if ($type === 'admin') {
            Admin::findOrFail($id)->delete();
        } else {
            User::findOrFail($id)->delete();
        }

        return redirect()->route('admin.users.index')->with('success', 'Akun berhasil dihapus.');
    }
}
