<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function store($data){
        $post = $this->fillObject($data);
        return $post->save() ? $post : false;
    }

    private function fillObject($data){
        $post = new $this;

        if (isset($data['path'])){
            $post['path'] = $data['path'];
        }
        if (isset($data['name'])){
            $post['name'] = $data['name'];
        }
        if (isset($data['description'])){
            $post['description'] = $data['description'];
        }
        if (isset($data['profile_id'])){
            $post['profile_id'] = $data['profile_id'];
        }
        return $post;
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
