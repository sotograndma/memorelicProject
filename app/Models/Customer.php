<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Customer extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'username',
        'email',
        'password',
        'profile_photo',
        'locations',
    ];

    protected $hidden = [
        'password',
    ];

    // Relasi ke Item (Barang yang Dijual)
    public function items()
    {
        return $this->hasMany(Item::class, 'customers_id');
    }

    // Relasi ke Auction (Barang yang Dilelang)
    public function auctions()
    {
        return $this->hasMany(Auction::class, 'customers_id');
    }

    // Relasi ke tabel users agar bisa login
    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    // Fungsi untuk membuat customer sekaligus menambah user di tabel users
    public static function createWithUser($data)
    {
        $customer = self::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'profile_photo' => $data['profile_photo'] ?? null,
            'locations' => $data['locations'] ?? null,
        ]);

        // Tambahkan juga ke tabel users
        $user = User::create([
            'name' => $customer->username,
            'email' => $customer->email,
            'password' => $customer->password,
            'role' => 'customer',
            'userable_id' => $customer->id,
            'userable_type' => Customer::class,
        ]);

        return $customer;
    }
}
