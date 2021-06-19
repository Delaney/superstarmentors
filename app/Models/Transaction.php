<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'broadcast_id',
        'paystack_reference',
        'transaction_type',
        'transaction_group',
        'payment_method',
        'payment_status',
        'notes',
        'amount',
    ];

    public function user()
    {
        return $this->belongsTo(Order::class);
    }
}
