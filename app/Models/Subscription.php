<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'broadcast_id',
        'cancelled',
        'cancelled_at'
    ];

    public function cancel() {
        $this->cancelled = true;
        $this->cancelled_at = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
        $this->save();
    }
}
