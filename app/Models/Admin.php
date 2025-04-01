<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // Relasi ke tabel users agar bisa login
    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    // Fungsi untuk membuat admin sekaligus menambah user di tabel users
    public static function createWithUser($data)
    {
        $admin = self::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Tambahkan juga ke tabel users
        $user = User::create([
            'name' => $admin->name,
            'email' => $admin->email,
            'password' => $admin->password,
            'role' => 'admin',
            'userable_id' => $admin->id,
            'userable_type' => Admin::class,
        ]);

        return $admin;
    }
}
