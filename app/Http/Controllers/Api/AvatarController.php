<?php

namespace App\Http\Controllers\Api;

use App\Profile;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;

class AvatarController extends ApiController
{
    use UploadTrait;
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
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
