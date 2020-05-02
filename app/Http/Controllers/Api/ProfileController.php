<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ProfileRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends ApiController
{

    /**
     * @var ProfileRepositoryInterface
     */
    private $profile;

    public function __construct(ProfileRepositoryInterface $profile)
    {

        $this->profile = $profile;
    }

    public function update(Request $request)
    {
        $data = [
            'id'           => $request->input('id'),
            'bio'          => $request->input('bio'),
            'name'         => $request->input('name'),
            'email'        => $request->input('email'),
            'image'        => $request->input('image'),
            'gender'       => $request->input('gender'),
            'user_id'      => $request->input('user_id'),
            'website'      => $request->input('website'),
            'username'     => $request->input('username'),
            'password'     => $request->input('password'),
            'is_private'   => $request->input('is_private'),
            'old_password' => $request->input('oldPassword'),
        ];
        

        $profile = $this->profile->insertOrUpdate($data, $data['id']);

        if (!$profile){
           return $this->respondWithError();
        }

        return $this->respondCreated($profile);
        
    }

}
