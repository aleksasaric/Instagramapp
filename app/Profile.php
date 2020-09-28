<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{


    protected $casts =
        ['is_private' => 'boolean'];


    protected $guarded = [ ];

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

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
