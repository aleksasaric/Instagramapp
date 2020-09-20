<?php

namespace App\Http\Controllers\Api;

use App\Post;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends ApiController
{

    use UploadTrait;
    /**
     * @var Post
     */
    private $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $image = $request->file('image');

        $data = [
            'image' => $image,
            'profile_id' => Auth::user()->profile->id,
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


    public function show(Post $post)
    {

    }


    public function edit(Post $post)
    {
        //
    }


    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * @param Post $post
     */
    public function destroy(Post $post)
    {
        //
    }
}
