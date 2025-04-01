<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    use HasFactory;

    protected $fillable = [
        'auction_id',
        'customer_id',
        'bid_amount',
        'is_highest',
    ];

    /**
     * Relasi ke model Auction.
     */
    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    /**
     * Relasi ke model Customer.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
