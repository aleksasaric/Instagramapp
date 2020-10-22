<?php

namespace App\Http\Controllers\Api;

use App\Post;
use App\Profile;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends ApiController
{
    use UploadTrait;

    private $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function store(Request $request)
    {
        $image = $request->file('image');
        $profile_id = $request->input('profile_id');

        $data = [
            'image' => $image,
            'profile_id' => $profile_id,
            'name' => date('Y_m_d-H-i-s'). '_' . md5($image->getClientOriginalName()),
            'description' => $request->input('description'),
            'folder' => '/uploads/images',
        ];

        $data['path'] =  $this->uploadOne($image, $data['folder'], 'public', $data['name']);

        if ($store = $this->post->store($data)){
            return $this->respondCreated('Successful upload', $store);
        }

        return $this->respondWithError();
    }

    public function storeAvatar(Request $request)
    {
        $image = $request->file('image');
        $profile_id = $request->input('profile_id');

        $data = [
            'image' => $image,
            'profile_id' => $profile_id,
            'name' => date('Y_m_d-H-i-s'). '_' . md5($image->getClientOriginalName()),
            'folder' => '/uploads/avatar',
        ];

        $data['path'] =  $this->uploadOne($image, $data['folder'], 'public', $data['name']);

        $profile = Profile::whereId($data['profile_id'])->first();
        $profile->image = $data['path'];

        if ($profile->save()){
            return $this->respondCreated('Successful upload', $profile);
        }

        return $this->respondWithError();
    }

}
