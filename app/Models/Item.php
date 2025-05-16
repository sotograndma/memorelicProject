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
        'image_path',

        // Field tambahan
        'condition',
        'min_order',
        'year_of_origin',
        'material',
        'height',
        'width',
        'weight',
        'region_of_origin',
        'maker',
        'rarity_level',
        'authenticity_certificate',
        'authenticity_certificate_images',
        'restoration_info',
        'provenance',
        'category',
        'damage_notes',

        // Pengiriman
        'shipping_locations',
        'shipping_cost',

        // Stok dan retur
        'stock',
        'sold_count',
        'returns_package',
    ];

    // Relasi ke Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customers_id');
    }

    // Relasi ke Transaksi
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'item_id');
    }
}
