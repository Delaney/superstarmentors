<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'category',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function broadcasts()
    {
        return $this->hasMany(Broadcast::class);
    }
}
