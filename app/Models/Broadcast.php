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
        'price'
    ];

    protected $casts = [
        'broadcast_datetime' => 'datetime',
    ];

    public function mentor()
    {
        return $this->hasOne(Mentor::class);
    }
}
