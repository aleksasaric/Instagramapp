<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function friends()
    {
        return $this->belongsToMany(Profile::class, 'friends', 'profile_id','friend_id');
    }

    public function befriendedBy()
    {
        return $this->belongsToMany(Profile::class, 'friends', 'friend_id','profile_id');
    }
}
