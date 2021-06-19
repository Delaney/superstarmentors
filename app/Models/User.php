<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
use Overtrue\LaravelFollow\Followable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Followable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'account_type',
        'email',
        'email_verified',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function roll_api_key() {
        do {
            $token = base64_encode( hash('sha256',time()) . hash('sha256',getenv('APP_KEY')) . random_bytes(206) );
            $this->api_token = $token;
        } while( $this->where('api_token', $this->api_token)->exists() );
        $this->api_token_expire_at = Carbon::now()->addDays(30);
        $this->save();
    }

    public function mentor() {
        if ($this->account_type == 'user') return false;
        return $this->hasOne(Mentor::class);
    }

    public function login() {
        $this->roll_api_key();

        $token = ApiToken::where('user_id', $this->id)
            ->first();

        $date = Carbon::now()->addDays(30);

        if ($token) {
            $token->api_token = $this->api_token;
            $token->api_token_expire_at = $date;
            $token->save();
        } else {
            $token = ApiToken::create([
                'user_id' => $this->id,
                'api_token' => $this->api_token,
                'api_token_expire_at' => $date,
            ]);
        }
    }
}
