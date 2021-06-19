<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Broadcast extends Model
{
    use HasFactory;

    protected $fillable = [
        'mentor_id',
        'name',
        'category',
        'avatar',
        'description',
        'broadcast_datetime',
        'price',
        'views'
    ];

    protected $casts = [
        'broadcast_datetime' => 'datetime',
    ];

    public function mentor()
    {
        return $this->hasOne(Mentor::class);
    }

    public function isSubscribed(User $user)
    {
        return Subscription::where('user_id', $user->id)
            ->where('broadcast_id', $this->id)
            ->where('cancelled', false)
            ->exists();
    }
}
