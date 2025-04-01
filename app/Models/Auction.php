<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Auction extends Model
{
    use HasFactory;

    protected $fillable = [
        'customers_id',
        'name',
        'description',
        'image_path',
        'starting_bid',
        'buy_now_price',
        'minimum_increment',
        'start_time',
        'end_time',
        'highest_bid',
        'highest_bidder_id',
        'status',
        'is_checkout_done',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_checkout_done' => 'boolean',
    ];

    // Relasi ke pemilik barang
    public function owner()
    {
        return $this->belongsTo(Customer::class, 'customers_id');
    }

    // Relasi ke penawar tertinggi
    public function highestBidder()
    {
        return $this->belongsTo(Customer::class, 'highest_bidder_id');
    }

    // Relasi ke semua bid yang masuk
    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    // Scope: hanya yang aktif
    public function scopeActive($query)
    {
        return $query->where('status', 'ongoing')
            ->where('end_time', '>', now());
    }

    // Cek apakah sudah bisa buy now
    public function canBuyNow()
    {
        return $this->buy_now_price !== null && $this->highest_bid >= $this->buy_now_price;
    }

    // Cek apakah user adalah pemenang lelang
    public function isUserWinner($userId)
    {
        return $this->highest_bidder_id === $userId && $this->status !== 'ongoing';
    }

    // Cek apakah waktu lelang sudah habis
    public function isEnded()
    {
        return $this->end_time->isPast();
    }

    // Cek apakah bisa checkout sekarang
    public function canCheckout($userId)
    {
        return $this->isUserWinner($userId) && !$this->is_checkout_done;
    }
}
