<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Courier extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'username',
        'email',
        'password',
        'profile_photo',
    ];

    protected $hidden = [
        'password',
    ];

    // Relasi ke tabel users agar bisa login dengan Laravel Breeze
    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    // Fungsi untuk membuat courier sekaligus menambah user di tabel users
    public static function createWithUser($data)
    {
        $courier = self::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'profile_photo' => $data['profile_photo'] ?? null,
        ]);

        // Tambahkan juga ke tabel users
        $user = User::create([
            'name' => $courier->username,
            'email' => $courier->email,
            'password' => $courier->password,
            'role' => 'courier',
            'userable_id' => $courier->id,
            'userable_type' => Courier::class,
        ]);

        return $courier;
    }
}
