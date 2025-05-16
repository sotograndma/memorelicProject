<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'auction_id',
        'item_id',
        'total_price',
        'status',
        'payment_code',
        'shipping_address',
        'quantity',
    ];

    // Relasi ke User (Customer)
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    // Relasi ke Item
    public function auction()
    {
        return $this->belongsTo(Auction::class, 'auction_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function isAuction()
    {
        return $this->auction_id !== null;
    }
}
