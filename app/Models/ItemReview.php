<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemReview extends Model
{
    use HasFactory;

    protected $fillable = ['transaction_id', 'item_id', 'customer_id', 'rating', 'comment'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
