<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password','username',
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::created(function ($user) {
            Profile::create([
                'name' => $user['name'],
                'username' => $user['username'],
                'email' => $user['email'],
                'user_id' => $user['id'],
                'image' => 'no_img.png',
            ]);
        });
    }


    public function profile()
    {
        return $this->hasOne(Profile::class);
    }


}
