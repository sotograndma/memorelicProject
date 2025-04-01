<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'customer_id',
        'item_id',
        'shipment_id',
        'payment_status',
        'total_price',
        'payment_method',
        'order_status',
    ];

    // Relasi ke pelanggan (customer)
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    // Relasi ke barang (item)
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    // Relasi ke pengiriman (shipment) jika ada
    public function shipment()
    {
        return $this->hasOne(Shipment::class, 'order_id');
    }
}
