<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'customers_id',
        'name',
        'description',
        'price',
        'status',
        'image_path', // Menyimpan path gambar
    ];

    // Relasi ke User (Customer)
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customers_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'item_id');
    }
}
